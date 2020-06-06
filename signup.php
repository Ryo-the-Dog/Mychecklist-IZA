<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　新規登録ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//================================
// 画面処理
//================================
// POST送信されていた場合
if(!empty($_POST)){
	debug('POST送信があります。');
	debug('POST情報：'.print_r($_POST,true));
	// POST送信された値を変数に格納する
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	$pass_re = $_POST['pass_re'];

	// バリデーション
	// 未入力チェック
	validRequired($email,'email');
	validRequired($pass,'pass');
	validRequired($pass_re,'pass_re');
	// 入力されていた場合
	if(empty($err_msg)){
		// メールアドレスの最大文字数チェック
		validMaxLen($email,'email');
		// メールアドレスの形式チェック
		validEmail($email,'email');
		// パスワードチェック
		validPass($pass,'pass');
		if(empty($err_msg)){
			// メールアドレスの重複チェック
			validEmailDup($email);
			// パスワードの再入力が合っているかチェック
			validMatch($pass,$pass_re,'pass_re');
			// エラーが無かった場合
			if(empty($err_msg)){
				// 例外処理
				try{
					// DB接続
					$dbh = dbConnect();
					// SQL文作成
					$sql = 'INSERT INTO users (email, pass, login_time, create_date) VALUES (:email, :pass, :login_time, :date)';
					// SQL文にキーと値を当て込む
					$data = array(':email' => $email, ':pass' => password_hash($pass, PASSWORD_DEFAULT), ':login_time' => date('Y-m-d H:i:s'), ':date' => date('Y-m-d H:i:s'));
					// クエリ実行
					$stmt = queryPost($dbh, $sql, $data);
					// クエリ成功の場合
					if($stmt){
						// ログインの有効期限(デフォルトは１時間に設定する)
						$sessionLimit = 60 * 60;
						// 最終ログイン日時を現在日時に設定する
						$_SESSION['login_date'] = time();
						// デフォルトのログイン有効期限をセッション変数に代入する
						$_SESSION['login_limit'] = $sessionLimit;
						// ユーザーIDを格納する
						$_SESSION['user_id'] = $dbh->lastInsertId();
						debug('セッション変数の中身：'.print_r($_SESSION,true));

						// テンプレートのシートを登録
						// SQL文作成
						$sql = 'INSERT INTO sheet (user_id, name, color, create_date) VALUES (:u_id, :name, :color, :date)';
						// SQL文にキーと値を当て込む
						$data = array(':u_id' => $_SESSION['user_id'],':name' => '防災',':color' => 1,':date' => date('Y-m-d H:i:s'));
						// クエリ実行
						$stmt = queryPost($dbh, $sql, $data);
						// クエリ成功の場合
						if($stmt){
							// シートのIDを取得する
							$s_id = $dbh->lastInsertId();
							// テンプレートのチェックリストを登録
							// SQL文作成
							$sql = 'INSERT INTO list (user_id, sheet_id, content, create_date) VALUES (:u_id, :s_id, :content, :date)';
							// チェックリストを一気に挿入するために連想配列に格納する
							// $checklists = array('')
							// SQL文にキーと値を当て込む
							$data = array(
								array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => '食料(３日分)',':date' => date('Y-m-d H:i:s')),
								array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => '飲料水(３日分)',':date' => date('Y-m-d H:i:s')),
								array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => 'トイレットペーパー',':date' => date('Y-m-d H:i:s')),
								array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => 'ランタン',':date' => date('Y-m-d H:i:s')),
								array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => '充電器',':date' => date('Y-m-d H:i:s')),
								array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => '軍手',':date' => date('Y-m-d H:i:s')),
								array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => 'タオル',':date' => date('Y-m-d H:i:s')),
								array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => '衣類・下着',':date' => date('Y-m-d H:i:s')),
								array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => '救急用品',':date' => date('Y-m-d H:i:s')),
							);
							$stmt = $dbh->prepare($sql);
							// クエリ実行
							// $stmt = queryPost($dbh, $sql, $data);
							foreach ($data as $key => $val) {
								$stmt->execute($val);
							}
							// クエリ成功の場合
							if($stmt){
								debug('ホーム画面へ遷移します');
								header("Location:index.php?s_id=".$s_id);
							}						
						}				
					}
				}catch(Exception $e){
					error_log('エラーが発生しました：'.$e->getMessage());
					$err_msg['common'] = MSG06;
				}
			}
		}
	}	
}
?>

<?php
$siteTitle = '会員登録';
require('head.php');
?>

<body class="page-signup">
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
					<h2 class="form-title">会員登録</h2>
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
						パスワード(再入力)
						<div class="area-msg">
						<?php showErrMsg('pass_re'); ?>
						</div>
						<input type="password" name="pass_re" value="<?php if(!empty($pass_re)) sanitize(showInputForm($pass_re, 'pass_re')); ?>">
					</label>				
					<div class="btn-container">
						<button type="submit" class="btn" name="submit" value="submit">会員登録</button>
					</div>
				</form>
			</div>
		</section>
	</div>
	<!-- フッター -->
	<?php
	require('footer.php');
	?>
</body>