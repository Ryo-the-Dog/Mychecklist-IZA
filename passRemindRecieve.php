<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　パスワード再送信ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//================================
// 画面処理
//================================

// SESSIONに認証キーが無ければリダイレクト
if(empty($_SESSION['auth_code'])){
	header("Location:page-passRemindSend.php");
}
// POST送信されていた場合
if(!empty($_POST)){
	debug('POST送信があります');
	debug('POST情報：'.print_r($_POST,true));
	// POST送信された値を変数に格納する
	$send_code = $_POST['send_code'];
	// バリデーション
	// 未入力チェック
	validRequired($send_code,'send_code');
	// 入力されていた場合
	if(empty($err_msg)){
		// 固定長チェック
		validLength($send_code,'send_code',6);
		// 認証キー形式チェック
		validHalf($send_code,'send_code');
		// エラーが無かった場合
		if(empty($err_msg)){
			debug('バリデーションOK。');
			// 認証キーに誤りがあった場合
			if($send_code !== $_SESSION['auth_code']){
				$err_msg['send_code'] = MSG10;
			}
			// 認証キーの有効期限が切れていた場合
			if(time() > $_SESSION['auth_code_limit']){
				$err_msg['send_code'] = MSG11;
			}
			// エラーが無かった場合
			if(empty($err_msg)){
				debug('認証OK');

				// パスワードを生成
				$new_pass = makeCode(8);

			}
			// 認証キーが有効期限内の場合
			if(($_SESSION['code_send_date']+$_SESSION['code_limit']) > time() ){
				debug('認証キーが有効期限内です');
				if($_SESSION['code'] === $send_code){
					debug('認証キーが一致しました');
					// パスワードを生成する		
					$randCode = makeCode(8);

					try{
						// DB接続
						$dbh = dbConnect();
						// SQL文作成
						$sql = 'UPDATE users SET pass = :pass WHERE email = :email';
						// SQL文にキーと値を当て込む
						$data = array(':pass' => password_hash($new_pass, PASSWORD_DEFAULT),':email' => $_SESSION['email']);
						// クエリ実行
						$stmt = queryPost($dbh, $sql, $data);
						if($stmt){
							debug('パスワードを変更しました');

							// メールの送信内容を定義する
							$from = 'info@nextStandard.com';
							$to = $_SESSION['email'];
							$subject = '新しいパスワードの送信　| IZA';
							$message = <<<EOT
新しいパスワードは、

{$new_pass}

です。

////////////////////////////////////////
マイチェックリストIZAカスタマーセンター
URL  http://nextStandard.com/
E-mail info@nextStandard.com
////////////////////////////////////////
EOT;
							sendMail($from,$to,$subject,$message);

							debug('パスワードメールを送信しました');
							session_unset();
							$_SESSION['success_msg_pass'] = SUC02;
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
	}
}
// メールで送信した認証キーとフォームに入力された認証キーが一致しているか判定する
?>

<?php
$siteTitle = 'パスワード再送信';
require('head.php');
?>

<body class="page-passRemindRecieve page-1column">
	<!-- メッセージ表示 -->
	<p id="js-area-msg" class="area-slide-msg"><?php echo getSessionFlash('success_msg_code') ;?></p>
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
						<button type="submit" class="btn" name="submit" value="submit">送信</button>
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