<?php
///共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　登録内容変更ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');
//================================
// 画面処理
//================================
$u_id = $_SESSION['user_id'];
$dbFormData = getUser($u_id);
debug('$dbFormDataの中身：'.print_r($dbFormData,true));
// POST送信されていた場合
if(!empty($_POST)){
	debug('POST送信があります。');
	debug('POST情報：'.print_r($_POST,true));
	// POST送信された値を変数に格納する
	$email = $_POST['email'];
	$pass_old = $_POST['pass_old'];
	$pass_new = $_POST['pass_new'];
	$pass_new_re = $_POST['pass_new_re'];
	// バリデーション
	// 未入力チェック
	validRequired($email,'email');
	validRequired($pass_old,'pass_old');
	validRequired($pass_new,'pass_new');
	validRequired($pass_new_re,'pass_new_re');
	// 入力されていた場合
	if(empty($err_msg)){
		debug('未入力チェックOKです');
		// メールアドレスが変更されていたら
		if($email !== $dbFormData['email']){
			// メールアドレスの最大文字数チェック
			validMaxLen($email,'email');
			// メールアドレスの最大文字数チェック
			validMaxLen($email,'email');
			// メールアドレスの形式チェック
			validEmail($email,'email');
			if(empty($err_msg)){
				// メールアドレスの重複チェック
				validEmailDup($email);
			}
		}
		// 現在のパスワードチェック
		validPass($pass_old,'pass_old');
		// 新しいパスワードチェック
		validPass($pass_new,'pass_new');
		// 現在のパスワードに誤りがある場合
		if(!password_verify($pass_old, $dbFormData['pass'])){
			debug('パスワードがマッチしません');
			$err_msg['common'] = MSG09;
		}
		if($pass_old === $pass_new){
			$err_msg['pass_new'] = MSG14;
		}
		// 新しいパスワード(再入力)の照合
		validMatch($pass_new,$pass_new_re,'pass_new_re');
		// メールアドレスとパスワードにエラーが無い場合
		if(empty($err_msg)){			
			debug('バリデーションOKです');
			// 例外処理
			try{
				// DB接続
				$dbh = dbConnect();
				// SQL文作成
				$sql = 'UPDATE users SET email = :email, pass = :pass WHERE id = :id AND delete_flg = 0';
				// SQL文にキーと値を当て込む
				$data = array(':email' => $email, ':pass' => password_hash($pass_new, PASSWORD_DEFAULT),':id' => $u_id);
				// クエリ実行
				$stmt = queryPost($dbh, $sql, $data);
				if($stmt){
					debug('ユーザー情報を変更しました');
					$_SESSION['success_msg_prof'] = SUC03;
					header("Location:index.php");
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
$siteTitle = '登録内容変更';
require('head.php');
?>

<body class="page-profEdit">
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
					<h2 class="form-title">登録内容変更</h2>
					<div class="area-msg">
					<?php showErrMsg('common'); ?>
					</div>
					<label>
						メールアドレス
						<div class="area-msg">
						<?php showErrMsg('email'); ?>
						</div>
						<input type="text" name="email" value="<?php echo getFormData('email'); ?>">
					</label>
					
					<label>
						現在のパスワード
						<div class="area-msg">
						<?php showErrMsg('pass_old'); ?>
						</div>
						<input type="password" name="pass_old" value="">
					</label>
					<label>
						新しいパスワード
						<div class="area-msg">
						<?php showErrMsg('pass_new'); ?>
						</div>
						<input type="password" name="pass_new" value="">
					</label>					
					<label>
						新しいパスワード(再入力)
						<div class="area-msg">
						<?php showErrMsg('pass_new_re'); ?>
						</div>
						<input type="password" name="pass_new_re" value="">
					</label>				
					<div class="btn-container">
						<button type="submit" class="btn" name="submit" value="submit">変更</button>
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