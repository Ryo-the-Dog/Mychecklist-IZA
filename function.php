<?php
//================================
// ログ
//================================
// ログを取るか
ini_set('log_errors', 'on');
// ログ(error_log)の出力ファイルを設定
ini_set('error_log', 'php.log');
error_reporting(E_ALL); //E_STRICT以外のエラーを報告する
ini_set('display_errors', 'on'); //画面にエラーを表示するか
//================================
// デバッグ
//================================
$debug_flg = true;
// デバッグログ関数
function debug($str){
	global $debug_flg;
	if(!empty($debug_flg)){
		error_log('デバッグ：'.$str);
	}
}
//================================
// セッション準備・セッション有効期限を延ばす
//================================
//セッションファイルの置き場所を変更する(var/tmp/以下に置くと30日間は削除されない)
session_save_path("/var/tmp");
// ガーベージコレクションが削除するセッションの有効期限を設定(30日以上経っているものに対してだけ100分の1の確率で削除)
ini_set('session.gc_maxlifetime', 60*60*24*30);
// ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
ini_set('session.cookie_lifetime',60*60*24*30);
// セッションを使う
session_start();
// 現在のセッションIDを新しく生成したものと置き換える(なりすましのセキュリティ対策)
session_regenerate_id();
//================================
// 画面表示処理開始ログ吐き出し関数
//================================
function debugLogStart(){
	debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');
	debug('セッションID：'.session_id());
	debug('セッション変数の中身：'.print_r($_SESSION,true));
	debug('現在日時のタイムスタンプ：'.time());
	if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
		debug('ログイン期限日時のタイムスタンプ：'.($_SESSION['login_date'] + $_SESSION['login_limit']));
	}
}

//================================
// 定数
//================================
define('MSG01', '入力必須です');
define('MSG02', '256文字以内で入力してください');
define('MSG03', '6文字以上で入力してください');
define('MSG04', '半角英数字のみご利用いただけます');
define('MSG05', 'メールアドレスの形式で入力してください');
define('MSG06', 'エラーが発生しました。しばらく経ってからやり直してください。');
define('MSG07', 'すでに使用されているメールアドレスです');
define('MSG08', 'パスワード(再入力)に誤りがあります');
define('MSG09', 'メールアドレスかパスワードに誤りがあります');
define('MSG10', '認証キーに誤りがあります');
define('MSG11', '認証キーの有効期限が切れています');
define('MSG12', '登録されていないメールアドレスです');
define('MSG13', '文字以内で入力してください');
define('MSG14', '現在使用中のパスワードと同じです');
define('MSG15', '削除するチェックリストが未選択です');
define('MSG16', '作成できるシートは最大６枚です。シートを削除してから追加してください。');
define('MSG17', 'これ以上削除できません');
define('SUC01', '認証キーをメール送信しました');
define('SUC02', '新しいパスワードをメール送信しました');
define('SUC03', '登録内容を変更しました');
//================================
// グローバル変数
//================================
// エラーメッセージを格納するための配列
$err_msg = array();
//================================
// バリデーション関数
//================================
// エラーメッセージ表示関数
function showErrMsg($key){
	global $err_msg;
	if(!empty($err_msg[$key])){
		echo $err_msg[$key];
	}
}
// 未入力チェック
function validRequired($str,$key){
	if(empty($str)){
		global $err_msg;
		$err_msg[$key] = MSG01;
	}
}
// 最大文字数チェック
function validMaxLen($str,$key,$max = 256){
	if(mb_strlen($str) > $max){
		global $err_msg;
		$err_msg[$key] = $max.'文字以内で入力してください';
	}
}
// 最大文字数チェック
function validMinLen($str,$key,$min = 6){
	if(mb_strlen($str) < $min){
		global $err_msg;
		$err_msg[$key] = MSG03;
	}
}
// 固定長チェック
function validLength($str,$key,$length = 8){
	if(mb_strlen($str) !== $length){
		global $err_msg;
		$err_msg[$key] = $length.MSG13;
	}
}
// 半角英数字チェック
function validHalf($str,$key){
	if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
		global $err_msg;
		$err_msg[$key] = MSG04;
	}
}
// メールアドレスの形式チェック
function validEmail($str,$key){
	if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])+@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $str)){
		global $err_msg;
		$err_msg[$key] = MSG05;
	}
}
// メールアドレスの重複チェック
function validEmailDup($email){
	debug('メールアドレスの重複チェックを開始します');
	global $err_msg;
	// 例外処理
	try{
		// DB接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT count(*) FROM users WHERE email = :email AND delete_flg = 0';
		// SQL文に値を当て込む
		$data = array(':email' => $email);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		// クエリ結果の値を取得
		$result = $stmt->fetch(PDO::FETCH_ASSOC); //検索して
		debug('重複チェックの結果:'.print_r($result,true));
		if(!empty(array_shift($result))){ //取り出す
			$err_msg['email'] = MSG07;
		}
	}catch(Exception $e){
		error_log('エラーが発生しました：'.$e->getMessage());
		$err_msg['common'] = MSG06;
	}
}
// パスワードチェック
function validPass($str, $key){
	validMaxLen($str,$key);
	validMinLen($str,$key);
	validHalf($str,$key);
}
// パスワード再入力チェック
function validMatch($str1,$str2,$key){
	if($str1 !== $str2){
		global $err_msg;
		$err_msg[$key] = MSG08;
	}
}
// 半角数字チェック(タブの色用)
function validHalfnumber($str,$key){
	if(!preg_match("/^[0-9]+$/", $str)){
		$err_msg[$key] = MSG06;
	}
}
//================================
// データベース
//================================
// DB接続関数
function dbConnect(){
	$dsn = 'mysql:dbname=ryokunnext_wp3;host=mysql8050.xserver.jp;charset=utf8';
	$user = 'ryokunnext_wp3';
	$password = 'og5rlp92yu';
	$options = array(
		// SQL実行失敗時にはエラーコードのみ設定
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		// デフォルトフェッチモードを連想配列形式に設定
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		// バッファードクエリを使う(一度に結果セットを全て取得し、サーバー負荷を軽減)
		// SELECTで得た結果に対してもrowCountメソッドを使えるようにする
		PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
	);
	// PDOオブジェクトを生成
	$dbh = new PDO($dsn, $user, $password, $options);
	return $dbh;
}
// クエリ実行関数
function queryPost($dbh, $sql, $data){
	// クエリ作成
	$stmt = $dbh -> prepare($sql);
	//プレースホルダに値をセットし、SQL文を実行
	if(!$stmt -> execute($data)){
		debug('クエリ失敗しました');
		global $err_msg;
		$err_msg['common'] = MSG06;
		return 0;
	}
	debug('クエリ成功');
	return $stmt;
}
// ユーザー情報取得関数
function getUser($u_id){
	// 例外処理
	try{
		// DB接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT * FROM users AS u WHERE id = :id AND delete_flg = 0';
		// SQL文にキーと値を当て込む
		$data = array(':id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		if($stmt){
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
	}catch(Exception $e){
		error_log('エラーが発生しました：'.$e->getMessage());
		$err_msg['common'] = MSG06;
	}
}
// シートとチェックリストの取得関数
function getSheetAndChecklists($s_id){
	debug('チェックリストシート情報を取得します');
	debug('シートID：'.$s_id);
	// 例外処理
	try{
		// DB接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT s.id,s.user_id,s.name,l.id,l.sheet_id,l.content,l.check_flg FROM list AS l RIGHT JOIN sheet AS s ON s.id = l.sheet_id WHERE s.user_id = :u_id AND s.delete_flg=0 AND l.delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		// クエリ結果の全データ代入する
		$result = $stmt->fetchAll();
		if(!$rst){
			foreach ($result as $key => $value) {
				# code...
			}
		}
	}catch(Exception $e){
		error_log('エラーが発生しました：'.$e->getMessage());
		$err_msg['common'] = MSG06;
	}
}
function getMySheetsAndChecklists($u_id){
	debug('マイチェックリストに登録済みの情報を取得します');
	debug('ユーザーID：'.$u_id);
	// 例外処理
	try{
		// DB接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT id,user_id,name,color,create_date,update_date FROM sheet WHERE user_id = :u_id AND delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		// クエリ結果の全データ代入する
		$result = $stmt->fetchAll();
		// debug('$result:'.print_r($result,true));
		if(!empty($result)){
			// 取得したシート情報からチェックリスト情報を取り出す
			foreach ($result as $key => $val) {
				// SQL文作成
				$sql = 'SELECT id,sheet_id,user_id,content,check_flg FROM list WHERE sheet_id = :s_id AND delete_flg=0';
				// SQL文にキーと値を当て込む
				$data = array(':s_id' => $val['id']); //listテーブルのsheet_idがsheetテーブルのidと一致するもの
				// クエリ実行
				$stmt = queryPost($dbh, $sql, $data);
				// 取得したシートのデータにchecklistというキーを追加して、listテーブルのデータを格納する。
				if($stmt){
					$result[$key]['checklist'] = $stmt->fetchAll();
				}
			}
			if($stmt){
				return $result;
			}
		}
	}catch(Exception $e){
		error_log('エラーが発生しました：'.$e->getMessage());
		$err_msg['common'] = MSG06;
	}
}
function getOneSheetAndChecklists($s_id){
	debug('特定のチェックリストシート情報を取得します');
	debug('シートID：'.$s_id);
	// 例外処理
	try{
		// DB接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT s.id,s.user_id,s.name,l.id,l.sheet_id,l.content,l.check_flg FROM list AS l RIGHT JOIN sheet AS s ON s.id = l.sheet_id WHERE s.id = :s_id AND s.delete_flg=0 AND l.delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':s_id' => $s_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		// クエリ結果の全データ代入する
		if($stmt){
			return $stmt->fetchAll();
		}
		
	}catch(Exception $e){
		error_log('エラーが発生しました：'.$e->getMessage());
		$err_msg['common'] = MSG06;
	}
}
function countMySheets($u_id){
	debug('登録済みのシート数を取得します');
	debug('ユーザーID：'.$u_id);
	// 例外処理
	try{
		// DB接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT count(*) FROM sheet WHERE user_id = :u_id AND delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		debug('登録済みシートの枚数$result：'.print_r($result,true));
		if($result){
			return array_shift($result);
		}
	}catch(Exception $e){
		error_log('エラーが発生しました：'.$e->getMessage());
		$err_msg['common'] = MSG06;
	}
}
//================================
// ログイン認証
//================================
function isLogin(){
	// ログイン済みの場合
	if(isset($_SESSION['login_date'])){
		debug('ログイン済みユーザーです');
		// ログイン有効期限内の場合
		if( ($_SESSION['login_date']+$_SESSION['login_limit'])  < time() ){
			debug('ログイン有効期限が切れています');
			session_destroy();		
			return false;
		// ログイン有効期限が切れていた場合
		}else{
			debug('ログイン有効期限内です');
			return true;
		}
	}else{
		debug('未ログインユーザーです');
		return false;
	}
}
//================================
// メール送信
//================================
function sendMail($from,$to,$subject,$message){
	if(!empty($to) && !empty($subject) && !empty($message)){
		//文字化けしないように設定
		mb_language("Japanese"); //現在使っている言語を設定する
		mb_internal_encoding("UTF-8"); //内部の日本語をUTF-8にエンコーディング
		// メールを送信
		$result = mb_send_mail($to,$subject,$message,"From:".$from);
		// 送信結果を判定する
		if($result){
			debug('メールを送信しました。');
		}else{
			debug('メールの送信に失敗しました。');
		}
	}
	
}
//================================
// その他
//================================
// フォームにエラーがあった時に正しく入力されている項目は残す
function showInputForm($str,$key){
	global $err_msg;
	if(!empty($err_msg) && empty($err_msg[$key]) ){
		echo $str;
	}
}
// サニタイズ
function sanitize($str){
	return htmlspecialchars($str,ENT_QUOTES);
}
// 認証キー、パスワード生成
function makeCode($length){ //コードの文字数を定義
	$randCode = ''; //生成したコードを格納する
	$base_strings = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',0,1,2,3,4,5,6,7,8,9]; //コードに使用する文字を配列で定義
	for ($i=0; $i < $length; $i++) {
		$randCode .= $base_strings[random_int(0,count($base_strings)-1)];
	}
	return $randCode;
}
// セッションを一時的に取得
function getSessionFlash($key){
	if(!empty($_SESSION[$key])){
		$data = $_SESSION[$key];
		$_SESSION[$key] = '';
		return $data;
	}
}
// フォームの入力保持
function getFormData($str, $flg = false){
	if($flg){
		$method = $_GET;
	}else{
		$method = $_POST;
	}
	global $dbFormData;
	// ユーザーデータが登録されている場合
	if(!empty($dbFormData)){
		// フォームにエラーがある場合
		if(!empty($err_msg[$str])){
			// データが送信されている場合
			if(isset($method[$str])){
				return sanitize($method[$str]);
			// データが送信されていない場合(基本起こり得ない)
			}else{
				return sanitize($dbFormData[$str]);
			}
		// フォームにエラーが無い場合
		}else{
			// データが送信されていて、DBのデータと送信されたデータが異なる場合
			if(isset($method[$str]) && $method[$str] !== $dbFormData[$str]){
				return sanitize($method[$str]);
			// DBのデータと送信されたデータが同じ場合
			}else{
				return sanitize($dbFormData[$str]);
			}
		}
	// ユーザーデータが登録されていない場合
	}else{
		// データが送信されている場合
		if(isset($method[$str])){
			return sanitize($method[$str]);
		}
	}
}
