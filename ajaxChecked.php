<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　Ajax　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//================================
// Ajax処理
//================================
debug('POST送信直後チェックリストのID：'.print_r($_POST['clickcheckId']));
// IDが０の場合もあるためissetで判定。
if(isset($_POST['clickcheckId']) && isset($_SESSION['user_id']) ){
	debug('AjaxによるPOST送信があります');
	$check_id = $_POST['clickcheckId'];
	debug('チェックリストのID：'.$check_id);
	// 例外処理
	try{
		// DBへ接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT check_flg FROM list WHERE id = :c_id AND delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':c_id' => $check_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		$resultCheck = $stmt->fetch(PDO::FETCH_ASSOC);
		// すでにチェックされていた場合
		if(array_shift($resultCheck) == 1 ){
			// SQL文作成
			$sql = 'UPDATE list SET check_flg = :check_flg WHERE id = :c_id AND delete_flg=0';
			// SQL文にキーと値を当て込む
			$data = array(':check_flg' => 0,':c_id' => $check_id);
			// クエリ実行
			$stmt = queryPost($dbh, $sql, $data);
		// まだチェックされていない場合
		}elseif(array_shift($resultCheck) == 0 ){
			// SQL文作成
			$sql = 'UPDATE list SET check_flg = :check_flg WHERE id = :c_id AND delete_flg=0';
			// SQL文にキーと値を当て込む
			$data = array(':check_flg' => 1,':c_id' => $check_id);
			// クエリ実行
			$stmt = queryPost($dbh, $sql, $data);
		}
	}catch(Exception $e){
		error_log('エラー発生:' . $e->getMessage());
	}
}