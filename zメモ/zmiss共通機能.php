<?php
ミス、忘れてたこと一覧

function.php

// メールアドレスの形式チェック
function validEmail($str,$key){
	global $err_msg;
	validMaxLen($str,$key);
	validMinLen($str,$key);
	validHalf($str,$key);
	if(!empty($err_msg)){
		$err_msg[$key] = MSG05;
	}
}
⇨これはパスワードであり、かつ$err_msgの格納はそれぞれの関数内で行われているので不要。しかもメールアドレスチェックはこれだけで行えるわけが無い。

function queryPost($dbh, $sql, $data){
  //クエリー作成
  $stmt = $dbh->prepare($sql);
  //プレースホルダに値をセットし、SQL文を実行
  $stmt->execute($data);
  return $stmt;
}
⇨何をprepareして何をexecuteするか忘れていた。

function validEmailDup($str $key){
	global $err_msg;
	// 例外処理
	try{
		// DB接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT u.email FROM users AS u WHERE'
		$data = array(':email' => $email);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		if($stmt){
			
		}
		// クエリ結果の値を取得
		$result = $stmt->fetchAll();
		if(!empty($result)){

		}


signup.php
$data = array(':email' => $email, ':pass' => $pass, ':login_time' => )// password_hashしてない
$_SESSION['user_id'] = $stmt->lastInsertId();

どうしてもvalidEmailDupが効かない。
debug('重複チェックの結果:'.print_r($result,true));で取り出すと、ログで
Array(
    [count(*)] => 0
)
となってしまう。
ウェブカツの方だと間違いなく発動するが、signup.phpとvalidEmailDupをまんまコピペしても動かない。そのためDBの方に問題があるのかもしれない。
11/16 14:48 試しにウェブカツmarketのファイルの方でデータベースをmychecklistに変えたら、同様にvalidEmailDupが発動しなかった！！やっぱりDBに問題がある！
⬇︎
テーブルのdelete_flgカラムの設定で、デフォルト値を０にすべきところがNULLになっていた！！！
marketテーブルとmychecklistテーブルそれぞれに'SELECT count(*) FROM users WHERE email = '8R.Matsumoto8@gmail.com' AND delete_flg = 0'をベタ書きしたら、marketではcount(*)1だったにも関わらず、mychecklistではcount(*)0だった。そこで冷静になって文とテーブルを見直したら誤りに気付けた。やはりDB接続が絡むエラーが起きた時は、DBの方に直接SQL文を書くに限ると改めて思った。
//ウェブカツ質問==============================================================
？signup.phpにthrow new Exception()が書かれていませんが、
error_log('エラー発生:' . $e->getMessage());
で呼び出しているメッセージはどこから発生しているのですか？
try,catch文の中で自作したdbConnect関数を呼び出しています。
その中でデータベースに接続をしていますが、データベースに接続出来なかったりSQLの書き方や指定したカラムがなかったりといった誤りがあると通常は自動的にphpの方で例外をスロー（投げてくれる）してくれます。
なので、そういった場合にはcatchの方で自動的に投げられた例外エラーを捕まえられるため、ログ内にメッセージが書き込まれます。
ただし、この練習のコードではデータベースへ接続する際のオプションでエラーの場合に例外をスローしない
PDO::ERRMODE_SILENT
という設定にしているため、メッセージは表示されませんが、通常はエラーになった場合に例外を投げる
PDO::ERRMODE_EXCEPTION
に設定しておくため、エラーが捕まえられます。
重複したemailをインサートしようとした場合にDB側でエラーが返ってきてしまい、例外を吐いてしまうため簡易的に接続時の設定を変えていましたが、
インサート前に「同じemailが既にあるかDBを検索する」ことをしておけばエラーが出る事はないため、接続時の設定はエラーを吐く設定にしておいて問題ありません。

？Email重複チェックを行うと、登録されていないEmailアドレスにもかかわらず、「そのEmailは登録されてます」のエラーが出ます。
重複チェック関数内の「$result = $stmt->fetch(PDO::FETCH_ASSOC);」の後に「var_dump($result);」を入れて、中身を確認したところ、未登録のEmailアドレスだと「array(1) { ["count(*)"]=> string(1) "0" }」となり、登録済みのEmailアドレスの場合は、「array(1) { ["count(*)"]=> string(1) "1" }」となります。
php公式のドキュメントで確認すると、「整数 の 0」、「文字列 の 0」、「空の配列 array()」は空であるとみなされるようですが、実際に判定に使われているのは「array(1)」で、arrayの中身の（検索のヒット数？）は無視されているようです。
正常に判定を行うためには、どのような対策をすればよいでしょうか。
よろしくお願いいたします。
よくそこまで自分で調べられましたね。さすがです。
お調べになった通り、練習のコードが誤っていました。
どちらも配列には１つの要素が入っているため、empty()で調べても空とは判定されませんね。
その場合は、配列の要素の中身に対してempty()を使ってみましょう。
今回の場合だと
if(!empty($result['count(*)']){
// 重複エラー処理
}
としてあげれば大丈夫です。
配列なので、中身のindex名を指定してあげれば中身の値が取り出せるので、
今回だと
$result['count(*)']
ですね。
index名を分かりやすい名前にしたい場合はSQLを
SELECT count(*) AS dup FROM ...
などとAS句を使って別名をつけてあげれば、その名前が検索結果として入ってきます。
ちなみにデータベースから取得した値というのは全て「文字列」になりますので、
データベース内に入っている0という数値も
検索結果でPHP側で取得した時には文字列になっています。

PHPでは大丈夫なんですが、JavaScriptの場合は文字列の０をif文で判定するとtrueになってしまうので一度キャスト（型を変換）する必要があるので注意してください。

？メール重複チェックのSQL文で SELECT email ではなく SELECT count(*)とするのはなぜでしょうか？
SELECT email ならクエリの結果の確認おいて、!empty(array_shift($result))としなくも!empty($result)と簡単に書くことができる気がします。
今後の学習のためでしょうか？
 役に立った! 0
今後の学習のためでもありますが、
「そもそも何をするためのSQLなのか？」がSQLから読み取れる必要もあります。
今の時点では一つのSQLしか扱っておらず、しかも使いたい時にそのSQLをその箇所に書く（コードの「ベタ書き」といったりします）という方法をしていますが、
実際の現場では様々なSQLが書かれていて、しかもSQL文自体別のファイルとして管理されていて、それを随時使いたい箇所で読み出して使う。という方法をしています。
（詳しくはフレームワーク部でやります）
そうなれば、
「同じSQLが増産される」
可能性があるわけですね。
そうなれば、いらないコードが増えていきます。
同じSQLの書かれたファイルを使えばいいわけですからね。
さらに同じSQLを「色々な箇所で使う」ということになるわけですから
「SQLを修正することになった」場合に「影響範囲が広がる」ことになります。
もし、
SELECT email
といった形で書けば「emailを取得するSQL」という役割になるわけなので
emailを取得する箇所で多様されることになりますね。
でも、実際には
「合致したレコードがあるかどう（件数を取得する）」
という目的で使ったものなのに。です。
SQLも「命令」なので、誤解を生みやすい命令は避けた方がいいでしょう。
（もちろん、SQLの書き方によって実際のSQLを実行した際の速度差があったりするので、そことの兼ね合いにもなります）
//ウェブカツ質問==============================================================
・htmlspecialchars は、フォームから送られてきた値や、データベースから取り出した値をブラウザ上に表示する際に使用します。主に、悪意のあるコードの埋め込みを防ぐ目的で使われます。(エスケープと呼ばれます)

login.php
// SQL文作成
$sql ='SELECT u.pass, u.email FROM users AS u WHERE email = :email AND delete_flg = 0';
emailはWHEREで検索で引っ掛ける時にだけ使うから、別にSELECTで取得する必要無いのか！！！
// SQL文にキーと値を当て込む
$data = array(':email' => $email);
// クエリ実行
$stmt = queryPost($dbh, $sql, $data);
// クエリ結果を代入する
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if(!empty($result)){
	if(password_verify($pass, array_shift($stmt))){ ⬅️ 一瞬パスワードを代入することを考えたがそうじゃない。
		session_regenerate_id(true); ⬅️これいらないらしい。
		// ユーザーIDを格納する
		$_SESSION['user_id'] = $dbh->lastInsertId();
		if(!empty($_POST['session_save'])){
			$_SESSION['login_limit'] = $sessionLimit * 24 *30;
		}
		header("Location:index.php");
	}else{
		$err_msg['common'] = MSG09;
	}
}
➡︎エラー　array_shift() expects parameter 1 to be array
⇨$resultの中身　Array ( [pass] => $2y$10$pls79nPsEzRLSL7.cGnpoetRSwIe39bDX9QTM/SmiUhGD.yDsK80. [email] => 8R.Matsumoto8@gmail.com )
➡️lastInsertIdだと$_SESSION['user_id'=>0になってしまう。⇨$sql ='SELECT u.pass, u.id, u.email FROM users AS u WHERE email = :email AND delete_flg = 0';
	// ユーザーIDを格納する
	$_SESSION['user_id'] = array_shift($result);
	これで無理やりユーザーID取得できたがこれじゃダメだろ。▶︎ただ単純に$resultの配列から$result['id']で取り出すだけだった。。。いまだに配列の理解が浅い。

・ログイン認証でやりたいこと
ログイン歴がなければ($_SESSIONにidが無ければ)、ログインページに遷移させる。
ログイン有効期限が切れていれば、ログインページに遷移させる。
if($_SESSION['login_limit'] < ($_SESSION['login_limit'] + time()) ){
if(!isset($_SESSION['user_id'])){
	header("Location:login.php");
}
正しくは、$_SESSION['login_date']で判定するんだな。
なんでlogin.phpでログイン認証する必要があるんだ？＝URLにベタ書きした時にログイン済みなのにログインページに遷移出来てしまうため？(でもそれだとパスワード再送信ページとかも同じことでは？)
・header.php
// ログインされているかどうか判定
$login_flg = (isset($_SESSION['user_id'])) ? true : false ;⬅️こんなのいらなかった

・passRemindSend
	$randCode = ''; //生成したコードを格納する
	$length = 6; //認証キーの文字数を定義
	$base_strings = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',0,1,2,3,4,5,6,7,8,9]; //認証キーに使用する文字を定義
	for ($i=0; $i < $length; $i++) { 
		$randCode .= $base_strings[random_int(0,count($base_strings)-1)];
		//配列の０番目は'a'なのでそこから配列の数だけ数えてしまうと１コはみ出る。そのため−１をしないと稀に空欄が入りエラーが起きてしまう。
	}
	return $randCode;

	メールの文章内でリンクを生成する方法が分からなかった。
	認証キーの有効期限の設定方法が分からない。
サクセスメッセージ表示
	var $jsAreaMsg = $('#js-area-msg');
	// setTimeout($jsAreaMsg.show('slow'),10000);
	$jsAreaMsg.show('slow');
	// setTimeout($jsAreaMsg.hide('slow'),10000);
	// $jsAreaMsg.hide('slow');
	setTimeout(function(){
		$jsAreaMsg.hide('slow')}, 4000);

・profEdit
$dbFormData['email']とするとどうしてもUndefined index: email のエラーが出てしまう。最低限アドレスを