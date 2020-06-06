<?php
///共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　退会ページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ログイン認証
require('auth.php');

//================================
// 画面処理
//================================
// post送信されていた場合
if(!empty($_POST)){
	debug('POST送信があります。');
	// 例外処理
	try{
		$dbh = dbConnect();
		// SQL文作成
		$sql1 = 'UPDATE users SET delete_flg = 1 WHERE id = :u_id';
		$sql2 = 'UPDATE sheet SET delete_flg = 1 WHERE user_id = :u_id';
		$sql3 = 'UPDATE list SET delete_flg = 1 WHERE user_id = :u_id';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $_SESSION['user_id']);
		// クエリ実行
		$stmt1 = queryPost($dbh, $sql1, $data);
		$stmt2 = queryPost($dbh, $sql2, $data);
		$stmt3 = queryPost($dbh, $sql3, $data);

		if($stmt1 && $stmt2 && $stmt3){
			// セッション削除
			session_destroy();
			debug('セッション変数の中身：'.print_r($_SESSION,true));
			header("Location:signup.php");
		}else{
			debug('クエリが失敗しました。');
      		$err_msg['common'] = MSG06;
		}
	}catch(Exception $e){
		error_log('エラー発生:' . $e->getMessage());
		$err_msg['common'] = MSG06;
	}
}


?>

<?php
$siteTitle = '退会';
require('head.php');
?>
	<body class="page-withdraw page-1column">
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
					<h2 class="form-title">退会</h2>
					<p>退会するとユーザー情報や登録されたチェックリストのデータなどが全て削除されます。<br>よろしければ退会ボタンを押してください。</p>
					<div class="area-msg">
					<?php showErrMsg('common'); ?>
					</div>				
					<div class="btn-container">
						<button type="submit" class="btn" name="submit" value="submit">退会する</button>
					</div>
					<p class="back-link"><a href="login.php">&lt; マイチェックリストページへ戻る</a></p>
				</form>
			</div>
		</section>
	</div>

	<!-- フッター -->
	<?php
	require('footer.php');
	?>	

	</body>



