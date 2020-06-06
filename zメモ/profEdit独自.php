<?php
function getDBFormData($u_id){ ❌これはgetUser()でユーザーデータを取得する関数
	// 例外処理
	try{
		// DB接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT u.email,u.pass FROM users AS u WHERE id = :id AND delete_flg = 0';
		// SQL文にキーと値を当て込む
		$data = array(':id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		if($stmt){
			return $stmt->fetchAll();
		}
	}catch(Exception $e){
		error_log('エラーが発生しました：'.$e->getMessage());
		$err_msg['common'] = MSG06;
	}
}
⏩$dbFormDataの中身：Array
(
    [0] => Array
        (
            [email] => 8R.Matsumoto8@gmail.com
            [pass] => $2y$10$L7/gQNzkHnZbSn.6KHM5MuWPXsU5VIvES43YCrWi31QyIsfL6.iAW
        )
)
多次元配列で取り出されてしまう。そのため、最悪[0]['email']とすれば取り出せるが、それだったら初めからfetch(PDO::FETCH_ASSOC)で１行だけ取得すればいい。
⬇︎正しくは　return $stmt->fetch(PDO::FETCH_ASSOC);
⏩$dbFormDataの中身(取得したユーザー情報)：Array
(
    [id] => 14
    [username] => りょう
    [age] => 65
    [tel] => 98182819223
    [zip] => 3271212
    [addr] => 
    [email] => 8R.Matsumoto8@gmail.com
    [pass] => $2y$10$KCqXGoELWAP0uQyZA4xms.F0qim5IdCMme2leam.FgSrCQQ6KBztO
    [pic] => uploads/8281e64d6a320e1a6de97f428e968a9d08f6b6f9.jpeg
    [delete_flg] => 0
    [login_time] => 2019-10-08 17:13:39
    [create_date] => 2019-10-08 17:13:39
)
?>
<?php
///共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ユーザー情報変更ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');
//================================
// 画面処理
//================================
$u_id = $_SESSION['user_id']; ❌代入しなくて良い
$dbFormData = getDBFormData($u_id);
debug('$dbFormDataの中身：'.print_r($dbFormData,true));
// POST送信されていた場合
if(!empty($_POST)){
	debug('POST送信があります。');
	debug('POST情報：'.print_r($_POST,true));
	// POST送信された値を変数に格納する
	$email = $_POST['email'];
	$pass_old = $_POST['pass_old'];
	$pass = $_POST['pass'];
	$pass_re = $_POST['pass_re'];

	// バリデーション
	// 未入力チェック
	validRequired($email,'email');
	validRequired($pass_old,'pass_old');
	validRequired($pass,'pass');
	validRequired($pass_re,'pass_re');
	// 入力されていた場合
	if(empty($err_msg)){
		// メールアドレスの最大文字数チェック
		validMaxLen($email,'email');
		// メールアドレスの形式チェック
		validEmail($email,'email');
		// パスワードチェック
		validPass($pass_old,'pass_old');
		// パスワードチェック
		validPass($pass,'pass');
		❌入れ子にしようとしすぎていた
		if(password_verify($pass_old, $dbFormData['pass'])){ //パスワード照合
			if($email !== $dbFormData['email']){ //メールアドレスが変更されていた場合のみ
				// メールアドレスの重複チェック
				validEmailDup($email);
			}
			if(empty($err_msg)){
				
				// パスワードの再入力が合っているかチェック
				validMatch($pass,$pass_re,'pass_re');
				// エラーが無かった場合
				if(empty($err_msg)){
					// 例外処理
					try{
						// DB接続
						$dbh = dbConnect();
						// SQL文作成
						$sql = 'UPDATE users SET email = :email, pass = :pass, login_time = :login_time, create_date = :date WHERE id = :id AND delete_flg = 0';
						// SQL文にキーと値を当て込む
						$data = array(':email' => $email, ':pass' => password_hash($pass, PASSWORD_DEFAULT), ':login_time' => date('Y-m-d H:i:s'), ':date' => date('Y-m-d H:i:s'), ':id' => $u_id);
						// クエリ実行
						$stmt = queryPost($dbh, $sql, $data);
						if($stmt){
							debug('ユーザー情報を変更しました');
						}
						
					}catch(Exception $e){
						error_log('エラーが発生しました：'.$e->getMessage());
						$err_msg['common'] = MSG06;
					}
				}
			}
		}else{
			$err_msg['common'] = MSG09;
		}
	}	
}
?>

<?php
$siteTitle = 'ユーザー情報変更';
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
					<h2 class="form-title">ユーザー情報変更</h2>
					<div class="area-msg">
					<?php showErrMsg('common'); ?>
					</div>
					<label>
						メールアドレス
						<div class="area-msg">
						<?php showErrMsg('email'); ?>
						</div>
						<input type="text" name="email" value="<?php
						if(!empty($_POST)){sanitize(showInputForm($email, 'email'));}elseif(!empty($dbFormData)){echo $dbFormData['email'];} ?>">
					</label>
					
					<label>
						現在のパスワード
						<div class="area-msg">
						<?php showErrMsg('pass'); ?>
						</div>
						<input type="text" name="pass_old" value="<?php if(!empty($pass)) sanitize(showInputForm($pass_old, 'pass_old')); ?>">
					</label>
					<label>
						新しいパスワード
						<div class="area-msg">
						<?php showErrMsg('pass'); ?>
						</div>
						<input type="text" name="pass" value="<?php if(!empty($pass)) sanitize(showInputForm($pass, 'pass')); ?>">
					</label>					
					<label>
						新しいパスワード(再入力)
						<div class="area-msg">
						<?php showErrMsg('pass_re'); ?>
						</div>
						<input type="text" name="pass_re" value="<?php if(!empty($pass_re)) sanitize(showInputForm($pass_re, 'pass_re')); ?>">
					</label>				
					<div class="btn-container">
						<button type="submit" class="btn">変更</button>
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