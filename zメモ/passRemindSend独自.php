<?php反省点
getSessionFlash()が出来ず。

//================================
// メール送信
//================================
function sendMail($from,$to,$subject,$message){
	mb_language("Japanese");
	mb_internal_encoding("UTF-8");
	mb_send_mail($to,$subject,$message);
}
?>
<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　認証キー送信ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// POST送信されていた場合
if(!empty($_POST)){
	debug('POST送信があります');
	// POST送信された値を変数に格納する
	$_SESSION['email'] = $_POST['email']; ❌
	// バリデーション
	// 未入力チェック
	validRequired($_SESSION['email'], 'email');
	// 入力されていた場合
	if(empty($err_msg)){
		// メールアドレス最大文字数チェック
		validMaxLen($_SESSION['email'], 'email');
		// メールアドレスの形式チェック
		validEmail($_SESSION['email'],'email');
		// エラーが無かった場合
		if(empty($err_msg)){
			❌登録されたメールアドレスに送信するので要DB接続
			// 認証キーを生成する&キーの寿命を定義する			
			$randCode = makeCode(6);
			$_SESSION['code'] = $randCode;
			$_SESSION['code_send_date'] = time(); ❌認証キーの送信された日時はlimitに足せば良い。
			$_SESSION['code_limit'] = 60*30; 
			// setcookie('key',$randCode,60*30);
			// debug('クッキー変数の中身：'.print_r($_COOKIE,true));
			// メールを送信できるように準備する
			❌$from忘れ
			$to = $_SESSION['email'];
			$subject = '認証キー送信　| IZA';
			❌'<<<EOT EOT;'忘れ。EOTの文字はなんでもよくて、最初と最後だけ括ればOK。
			$message ='認証キーは、

'.$randCode.'

です。認証キーは３０分間のみ有効です。
下記のURLにアクセスして認証キーを送信してください。
'.$_SERVER["HTTP_HOST"].'/IZA/passRemindRecieve.php';❌この段階ではURLはいらない
			
			
			

			// 一致していればpassRemindRecieveへ遷移する
			// サクセスメッセージを表示させる。但し処理が実行されていない時にはメッセージが表示されないようにする。
			// メールで認証キーとURLを送信する
			// if(sendMail($to,$subject,$message)){
				sendMail($to,$subject,$message); ❌関数内ですでに送ってる。
				debug('メールを送信しました'); ❌メール送信結果の判定は関数内で行う。
				$_SESSION['success_msg'] = SUC01;
				getSessionFlash(); ❌ここではセッションを取得する必要が無い。
				// session_destroy();
				debug('セッション変数の中身：'.print_r($_SESSION,true));
				header("Location:passRemindRecieve.php");
			// }
		}
	}
}

?>

<?php
$siteTitle = 'パスワード再送信';
require('head.php');
?>

<body class="page-passRemindSend page-1column">
	<!-- メッセージ表示 -->
	<?php if(!empty($_SESSION['success_msg'])) { ?>
	<div id="js-area-msg"><?php echo $_SESSION['success_msg'] ;?></div>
	<?php } ?>
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
					<p>入力されたメールアドレスにパスワード再発行用のURLと認証キーを送信します。</p>
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
						<button type="submit" class="btn">送信</button>
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