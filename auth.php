<?php
//================================
// ログイン認証・自動ログアウト
//================================
// ログインしている場合
if(!empty($_SESSION['login_date'])){
	debug('ログイン済みユーザーです');
	// 現在日時がログイン有効期限を超えている場合
	if( ($_SESSION['login_date'] + $_SESSION['login_limit']) < time() ){
		debug('ログイン有効期限を超えています');
		// セッションを削除
		session_destroy();
		// ログインページへ遷移させる
		header("Location:login.php");
	// ログイン有効期限内だった場合
	}else{
		// 最終ログイン日時を現在に更新
		$_SESSION['login_date'] = time();
		// 現在実行中のスクリプトファイル名がlogin.phpの場合
		if(basename($_SERVER['PHP_SELF']) === 'login.php'){
			debug('ホーム画面へ遷移します');
			header("Location:index.php");
		}
	}
// ログインしていない場合
}else{
	debug('ログインしていません');
	if(basename($_SERVER['PHP_SELF']) !== 'login.php'){
		header("Location:login.php");
	}
}
?>