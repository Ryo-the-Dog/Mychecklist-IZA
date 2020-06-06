<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　認証キー送信ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//================================
// 画面処理
//================================
// POST送信されていた場合
if(!empty($_POST)){
	debug('POST送信があります');
	debug('POST情報：'.print_r($_POST,true));
	// POST送信された値を変数に格納する
	$email = $_POST['email'];
	// バリデーション
	// 未入力チェック
	validRequired($email, 'email');
	// 入力されていた場合
	if(empty($err_msg)){
		// メールアドレス最大文字数チェック
		validMaxLen($email, 'email');
		// メールアドレスの形式チェック
		validEmail($email,'email');
		// エラーが無かった場合
		if(empty($err_msg)){
			debug('バリデーションOK。');
			// 例外処理
			try{
				// DB接続
				$dbh = dbConnect();
				// SQL文作成
				$sql = 'SELECT count(*) FROM users WHERE email = :email AND delete_flg = 0';
				// SQL文にキーと値を当て込む
				$data = array(':email' => $email);
				// クエリ実行
				$stmt = queryPost($dbh, $sql, $data);
				// クエリ結果を代入する
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				// DBにメールアドレスがあった場合
				if($result && array_shift($result)){
					debug('クエリ成功。DB登録あり。');
	    			debug('$resultの中身：'.print_r($result,true));
	    			// サクセスメッセージを格納
	    			$_SESSION['success_msg_code'] = SUC01;
					// 認証キーを生成する			
					$randCode = makeCode(6);
					// 送信主を定義する
					$from = 'info@nextStandard.com';
					// メールの内容を定義する
					$to = $email;
					$subject = '認証キー送信　| IZA';
					$message = <<<EOT
認証コードは、

{$randCode}

です。認証キーは３０分間のみ有効です。

////////////////////////////////////////
マイチェックリストIZAカスタマーセンター
URL  http://nextStandard.com/
E-mail info@nextStandard.com
////////////////////////////////////////
EOT;
					// メールを送信する
					sendMail($from,$to,$subject,$message);

					// 認証に必要な情報をセッションへ保存
					$_SESSION['auth_email'] = $email;
					$_SESSION['auth_code'] = $randCode;
					$_SESSION['auth_code_limit'] = time() + (60*30);

					debug('セッション変数の中身：'.print_r($_SESSION,true));
					header("Location:passRemindRecieve.php");
				// DBにメールアドレスが無かった場合
				}else{
					debug('クエリに失敗したかDBに登録のないEmailが入力されました。');
					$err_msg['email'] = MSG12;
				}
			}catch(Exception $e){
	    		error_log('エラー発生:' . $e->getMessage());
      			$err_msg['common'] = MSG07;
	    	}
			
		}
	}
}

?>

<?php
$siteTitle = 'パスワード再送信';
require('head.php');
?>

<body class="page-passRemindSend page-1column">
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
					<p>登録したメールアドレスを入力してください。パスワード再発行用のURLと認証キーを送信します。</p>
					<div class="area-msg">
					<?php showErrMsg('common'); ?>
					</div>
					<label>
						メールアドレス
						<div class="area-msg">
						<?php showErrMsg('email'); ?>
						</div>
						<input type="text" name="email">
					</label>
					<div class="btn-container">
						<button type="submit" class="btn" name="submit" value="submit">送信</button>
					</div>
					<p class="back-link"><a href="login.php">&lt; ログインページへ戻る</a></p>
				</form>
			</div>
		</section>
	</div>

	<!-- フッター -->
	<?php
	require('footer.php');
	?>	

</body>