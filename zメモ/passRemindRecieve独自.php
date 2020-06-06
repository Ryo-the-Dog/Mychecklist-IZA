<?php
	// 処理を実行した時にメッセージを表示させる
	var $jsAreaMsg = $('#js-area-msg');
	// setTimeout($jsAreaMsg.show('slow'),10000);
	$jsAreaMsg.show('slow');
	// setTimeout($jsAreaMsg.hide('slow'),10000);
	// $jsAreaMsg.hide('slow');
	setTimeout(function(){
		$jsAreaMsg.hide('slow')}, 4000);
	❌メッセージが空だった時の処理はJS内で行う！！
?>
<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　パスワード再送信ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();
❌$_SESSION内のauth_codeがあるか判定していない。
// POST送信されていた場合
if(!empty($_POST)){
	debug('POST送信があります');
	// POST送信された値を変数に格納する
	$send_code = $_POST['send_code'];
	// バリデーション
	// 未入力チェック
	validRequired($send_code,'send_code');
	// 認証キー形式チェック
	validHalf($send_code,'send_code');
	❌固定長チェックしてない
	// debug('クッキー変数の中身：'.print_r($_COOKIE,true));
	debug('セッション変数の中身：'.print_r($_SESSION,true));
		// if(empty($err_msg) && preg_match($_COOKIE['key'], $send_code)){
	// 認証キーが有効期限内の場合
	if(($_SESSION['code_send_date']+$_SESSION['code_limit']) > time() ){
		debug('認証キーが有効期限内です');
		if($_SESSION['code'] === $send_code){
			debug('認証キーが一致しました');
			// パスワードを生成する		
			$randCode = makeCode(8);
						// メールを送信できるように準備する

			❌先にパスワードを更新する！
			$to = $_SESSION['email'];
			$subject = '新しいパスワードの送信　| IZA';
			$message ='新しいパスワードは、

'.$randCode.'

です。
下記のログイン画面にて新しいパスワードを入力してください。
'.$_SERVER["HTTP_HOST"].'/IZA/passRemindRecieve.php';

			sendMail($to,$subject,$message);
			debug('パスワードメールを送信しました');
			$_SESSION['success_msg'] = SUC01;
			// 例外処理
			try{
				// DB接続
				$dbh = dbConnect();
				// SQL文作成
				$sql = 'UPDATE users SET pass = :pass WHERE email = :email';
				// SQL文にキーと値を当て込む
				$data = array(':pass' => password_hash($randCode, PASSWORD_DEFAULT),':email' => $_SESSION['email']);
				// クエリ実行
				$stmt = queryPost($dbh, $sql, $data);
				if($stmt){
					debug('パスワードを変更しました');

					❌session_unset()忘れ。

					header("Location:login.php");
				}				
			}catch(Exception $e){
				error_log('エラーが発生しました：'.$e->getMessage());
				$err_msg['common'] = MSG06;
			}
			

		// 認証キーが一致しなかった場合
		}else{
			debug('認証キーが一致しません');
			$err_msg['send_code'] = MSG10;
		}
	// 認証キーの有効期限が切れていた場合
	}else{
		debug('認証キーの有効期限が切れています');
		$err_msg['send_code'] = MSG11;
	}
}
// メールで送信した認証キーとフォームに入力された認証キーが一致しているか判定する
?>

<?php
$siteTitle = 'パスワード再送信';
require('head.php');
?>

<body class="page-passRemindRecieve page-1column">
	<?php if(!empty($_SESSION['success_msg'])) { ?>
	<div id="js-area-msg"><?php echo $_SESSION['success_msg'] ;?></div>
	<?php } ?> ❌getSessionFlashはここで使用する！！！！最初にページ遷移した時(POST送信されていない段階)でgetSessionFlash()でメッセージ内容を取得してすぐにメッセージ内容を空にする。
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
					<h2 class="form-title">パスワード再発行</h2>
					<p>メールアドレス送信された認証キーを入力してください。新しいパスワードを再発行します。</p>
					<div class="area-msg">
					<?php showErrMsg('common'); ?>
					</div>
					<label>
						認証キー(６文字)
						<div class="area-msg">
						<?php showErrMsg('send_code'); ?>
						</div>
						<input type="text" name="send_code">
					</label>
					<div class="btn-container">
						<button type="submit" class="btn">送信</button>
					</div>
					<p><a href="passRemindSend.php">&lt; もう一度認証キーを取得する</a></p>
				</form>
			</div>
		</section>
	</div>

	<!-- フッター -->
	<?php
	require('footer.php');
	?>	

</body>