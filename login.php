<?php
///共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ログインページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

//================================
// 画面処理
//================================
// POST送信されていた場合
if(!empty($_POST)){
	debug('POST送信があります');
	debug('POST情報：'.print_r($_POST,true));
	// POST送信された値を変数に格納する
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$session_save = (!empty($_POST['session_save']))? true : false ;
	
	// バリデーション
	// 未入力チェック
	validRequired($email, 'email');
	validRequired($pass, 'pass');
	// 入力されていた場合
	if(empty($err_msg)){
		// メールアドレスの最大文字数チェック
		validMaxLen($email,'email');
		// メールアドレスの形式チェック
		validEmail($email,'email');
		// パスワードチェック
		validPass($pass,'pass');
		// エラーが無かった場合
		if(empty($err_msg)){
			// 例外処理
			try{
				// DB接続
				$dbh = dbConnect();
				// SQL文作成
				$sql ='SELECT u.pass, u.id FROM users AS u WHERE email = :email AND delete_flg = 0';
				// SQL文にキーと値を当て込む
				$data = array(':email' => $email);
				// クエリ実行
				$stmt = queryPost($dbh, $sql, $data);
				// クエリ結果を代入する
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				debug('クエリ結果の中身：'.print_r($result,true));
				// debug('$resultの中身：'.print_r($result));
				if(!empty($result) && password_verify($pass, array_shift($result))){
					debug('パスワードがマッチしました');
					// ログインの有効期限(デフォルトは１時間とする)
					$sessionLimit = 60 * 60;
					// 最終ログイン日時を現在日時に設定する
					$_SESSION['login_date'] = time();
					// debug('$resultの中身：'.print_r($result));
					// debug('セッション変数の中身：'.print_r($_SESSION));
					if(!empty($session_save)){
						debug('ログイン保持にチェックがあります');
						$_SESSION['login_limit'] = $sessionLimit * 24 *30;
					}else{
						debug('ログイン保持にチェックはありません');
						// デフォルトのログイン有効期限をセッション変数に格納する
						$_SESSION['login_limit'] = $sessionLimit;
					}
					// ユーザーIDを格納する
					$_SESSION['user_id'] = $result['id'];
					debug('セッション変数の中身：'.print_r($_SESSION,true));
					debug('ホーム画面へ遷移します');
					header("Location:index.php");
				}else{
					debug('パスワードがマッチしません。');
					$err_msg['common'] = MSG09;
				}
			}catch(Exception $e){
				error_log('エラーが発生しました：'.$e->getMessage());
				$err_msg['common'] = MSG06;
			}
		}
	}
}
?>
<?php
$siteTitle = 'ログイン';
require('head.php');
?>

<body class="page-login page-1column">
	<!-- メッセージ表示 -->
	<p id="js-area-msg" class="area-slide-msg"><?php echo getSessionFlash('success_msg_pass') ;?></p>
	<!-- メニュー -->
	<?php
	require('header.php');
	?>
	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">
		<!-- Main -->
		<section id="main">
			<div class="form-container">
				<form action="" method="post" class="form">
					<h2 class="form-title">ログイン</h2>
					<div class="area-msg">
					<?php showErrMsg('common'); ?>
					</div>
					<label>
						メールアドレス
						<div class="area-msg">
						<?php showErrMsg('email'); ?>
						</div>
						<input type="text" name="email" value="<?php if(!empty($email)) sanitize(showInputForm($email, 'email')); ?>">
					</label>					
					<label>
						パスワード
						<div class="area-msg">
						<?php showErrMsg('pass'); ?>
						</div>
						<input type="password" name="pass" value="<?php if(!empty($pass)) sanitize(showInputForm($pass, 'pass')); ?>">
					</label>					
					<label>
						<input type="checkbox" name="session_save"><span>次回のログインを省略する</span>
					</label>
					<div class="btn-container">
						<button type="submit" class="btn" name="submit" value="submit">ログイン</button>
					</div>
					<p>パスワードを忘れた方は<a href="passRemindSend.php">コチラ</a></p>
					<p>未登録の方は<a href="signup.php">会員登録</a>へ</p>
				</form>
			</div>
		</section>
	</div>

	<!-- フッター -->
	<?php
	require('footer.php');
	?>

</body>