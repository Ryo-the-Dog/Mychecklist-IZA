<?php

ミス、忘れてたこと一覧

$__SQLベタ書き用
'INSERT INTO users (user_id,name,create_date,update_date) VALUES (14,引っ越し,date('Y-m-d H:i:s'),date('Y-m-d H:i:s'))'

'INSERT INTO sheet (user_id, name) VALUES (14,'引っ越し')'
'INSERT INTO list (sheet_id,content) VALUES (2,'電力会社へ連絡')'

'SELECT s.id,s.name,l.id,l.sheet_id,l.checklist,l.check_flg FROM list AS l RIGHT JOIN sheet AS s ON s.id = l.sheet_id WHERE s.id = 2 AND s.delete_flg=0 AND l.delete_flg=0';
id name   id sheet_id  checklist  check_flg
2 引っ越し　　1   2      電力会社へ連絡　　　0
2 引っ越し　　2   2      ガス会社へ連絡　　　0
2 引っ越し　　3   2      水道会社へ連絡　　　0
2 引っ越し　　4   2     引っ越し業者へ連絡　　0
⇨取得に関してはこれで問題無し。あとはこれの表示のさせ方だけ。
getSheetAndChecklistsの取得結果
Array
(
    [0] => Array
        (
            [id] => 1
            [user_id] => 14
            [name] => 引っ越し
            [sheet_id] => 2
            [checklist] => 電力会社へ連絡
            [check_flg] => 0
        )
    [1] => Array
        (
            [id] => 2
            [user_id] => 14
            [name] => 引っ越し
            [sheet_id] => 2
            [checklist] => ガス会社へ連絡
            [check_flg] => 0
        )
    [2] => Array
        (
            [id] => 3
            [user_id] => 14
            [name] => 引っ越し
            [sheet_id] => 2
            [checklist] => 水道会社へ連絡
            [check_flg] => 0
        )
    [3] => Array
        (
            [id] => 4
            [user_id] => 14
            [name] => 引っ越し
            [sheet_id] => 2
            [checklist] => 引っ越し業者へ連絡
            [check_flg] => 0
        )
)
$__marketのgetMyMsgsAndBoardによる取得内容
⇨これを行うにはgetMsgsAndBoardでは出来ない
[73] => Array
        (
            [id] => 79
            [product_id] => 2
            [sell_user] => 14
            [buy_user] => 15
            [delete_flg] => 0
            [create_date] => 2019-11-03 12:14:20
            [update_date] => 2019-11-03 12:14:20
            [msg] => Array
                (
                    [0] => Array
                        (
                            [id] => 14
                            [board_id] => 79
                            [send_date] => 2019-11-03 12:19:41
                            [to_user] => 14
                            [from_user] => 15
                            [msg] => dagagaga
                            [delete_flg] => 0
                            [create_date] => 2019-11-03 12:19:41
                            [update_date] => 2019-11-03 12:19:41
                        )
                )
        )
    [74] => Array
        (
            [id] => 80
            [product_id] => 2
            [sell_user] => 14
            [buy_user] => 15
            [delete_flg] => 0
            [create_date] => 2019-11-03 12:23:43
            [update_date] => 2019-11-03 12:23:43
            [msg] => Array
                (
                    [0] => Array
                        (
                            [id] => 20
                            [board_id] => 80
                            [send_date] => 2019-11-03 19:31:34
                            [to_user] => 14
                            [from_user] => 15
                            [msg] => rがdさだあ
                            [delete_flg] => 0
                            [create_date] => 2019-11-03 19:31:34
                            [update_date] => 2019-11-03 19:31:34
                        )
                    [1] => Array
                        (
                            [id] => 19
                            [board_id] => 80
                            [send_date] => 2019-11-03 19:31:24
                            [to_user] => 14
                            [from_user] => 15
                            [msg] => tsrががrg
                            [delete_flg] => 0
                            [create_date] => 2019-11-03 19:31:24
                            [update_date] => 2019-11-03 19:31:24
                        )
                    [2] => Array
                        (
                            [id] => 18
                            [board_id] => 80
                            [send_date] => 2019-11-03 19:24:39
                            [to_user] => 14
                            [from_user] => 15
                            [msg] => dasda
                            [delete_flg] => 0
                            [create_date] => 2019-11-03 19:24:39
                            [update_date] => 2019-11-03 19:24:39
                        )
                    [3] => Array
                        (
                            [id] => 17
                            [board_id] => 80
                            [send_date] => 2019-11-03 19:22:51
                            [to_user] => 14
                            [from_user] => 15
                            [msg] => dファファファ
                            [delete_flg] => 0
                            [create_date] => 2019-11-03 19:22:51
                            [update_date] => 2019-11-03 19:22:51
                        )
                    [4] => Array
                        (
                            [id] => 16
                            [board_id] => 80
                            [send_date] => 2019-11-03 12:36:19
                            [to_user] => 14
                            [from_user] => 15
                            [msg] => dsfdafavadsvd
                            [delete_flg] => 0
                            [create_date] => 2019-11-03 12:36:19
                            [update_date] => 2019-11-03 12:36:19
                        )
                    [5] => Array
                        (
                            [id] => 15
                            [board_id] => 80
                            [send_date] => 2019-11-03 12:36:15
                            [to_user] => 14
                            [from_user] => 15
                            [msg] => fdsgagag
                            [delete_flg] => 0
                            [create_date] => 2019-11-03 12:36:15
                            [update_date] => 2019-11-03 12:36:15
                        )
                )
        )
    [75] => Array
        (
            [id] => 81
            [product_id] => 5
            [sell_user] => 14
            [buy_user] => 15
            [delete_flg] => 0
            [create_date] => 2019-11-05 00:55:16
            [update_date] => 2019-11-05 00:55:16
            [msg] => Array
                (
                )

// 例外処理
	try{
		// DB接続
		$dbh = dbConnect();
		// SQL文作成
		$sql = 'SELECT id,user_id,name,create_date,update_date FROM sheet WHERE user_id = :u_id AND delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		// クエリ結果の全データ代入する
		$result = $stmt->fetchAll();
		debug('$result:'.print_r($result));
		if(!empty($result)){
			// 取得したシート情報からチェックリスト情報を取り出す
			foreach ($result as $key => $val) {
				// SQL文作成
				$sql = 'SELECT sheet_id,user_id,checklist FROM list WHERE user_id = :u_id AND delete_flg=0';
				// SQL文にキーと値を当て込む
				$data = array(':u_id' => $u_id);
				// クエリ実行
				$stmt = queryPost($dbh, $sql, $data);
				if($stmt){ ❌本来はこの$stmtの判定は不要。しかし正常に動作はする。
					$result[$key]['checklist'] = $stmt->fetchAll();
				}
				❌return を忘れた！！！そのせいで$sheetAndCheckListsの中身が空になってしまった。
			}
		}
Array
(
    [0] => Array
        (
            [id] => 2
            [user_id] => 14
            [name] => 引っ越し
            [create_date] => 
            [update_date] => 2019-11-18 12:18:18
            [checklist] => Array
                (
                    [0] => Array
                        (
                            [sheet_id] => 2
                            [user_id] => 
                            [checklist] => 電力会社へ連絡
                        )
                    [1] => Array
                        (
                            [sheet_id] => 2
                            [user_id] => 
                            [checklist] => ガス会社へ連絡
                        )
                    [2] => Array
                        (
                            [sheet_id] => 2
                            [user_id] => 
                            [checklist] => 水道会社へ連絡
                        )
                    [3] => Array
                        (
                            [sheet_id] => 2
                            [user_id] => 
                            [checklist] => 引っ越し業者へ連絡
                        )
                )
        )
    [1] => Array
        (
            [id] => 3
            [user_id] => 14
            [name] => 旅行
            [create_date] => 
            [update_date] => 2019-11-18 22:25:57
            [checklist] => Array
                (
                    [0] => Array
                        (
                            [sheet_id] => 3
                            [user_id] => 
                            [checklist] => 歯ブラシ
                        )
                    [1] => Array
                        (
                            [sheet_id] => 3
                            [user_id] => 
                            [checklist] => 下着
                        )
                    [2] => Array
                        (
                            [sheet_id] => 3
                            [user_id] => 
                            [checklist] => タオル
                        )
                    [3] => Array
                        (
                            [sheet_id] => 3
                            [user_id] => 
                            [checklist] => 充電器
                        )
                    [4] => Array
                        (
                            [sheet_id] => 3
                            [user_id] => 
                            [checklist] => ホテルの予約
                        )
                )
        )
)
$__$getMySheetsAndCheckListsの取得方法(シート)
$_1_タブ名取得
1.<?php foreach ($mySheetAndCheckLists as $key => $val) { ?>
	<a href="" class="tab"><div><p><?php $mySheetAndCheckLists[$val]['name']; ?></p></div></a>
<?php } ?> 
⇨[20-Nov-2019 10:52:15 Asia/Tokyo] PHP Warning:  Illegal offset type in /Applications/MAMP/htdocs/IZA/index.php on line 42
なぜダメなのか。 ⇨ ❌$mySheetAndCheckListsのforeach内なので$mySheetAndCheckListsを改めて入れる必要は無い。
2.<a href="" class="tab"><div><p><?php echo [$val]['name']; ?></p></div></a>
⇨ [20-Nov-2019 11:01:30 Asia/Tokyo] PHP Notice:  Undefined index: name in /Applications/MAMP/htdocs/IZA/index.php on line 42 
3.<a href="" class="tab"><div><p><?php echo ['name']; ?></p></div></a>
⇨ [20-Nov-2019 11:04:48 Asia/Tokyo] PHP Notice:  Array to string conversion in /Applications/MAMP/htdocs/IZA/index.php on line 42
4.<a href="" class="tab"><div><p><?php echo $val['name']; ?></p></div></a>
⇨ 取得成功！　❌$valに[]を付けてしまっていた！！！[$val]こんな指定方法はない。
$___$getMySheetsAndCheckListsの取得方法(チェックリスト)
1-1.<label for="checklist1"><div class="checklist"><input type="checkbox" id="checklist1"><?php echo $val['checklist'][$key]['content']; ?></div></label>
	⇨ これだとなぜか旅行のが２つだけ取り出せてしまう。もしかしたら[$key]が上のforeachと同じもので１で固定されて取得してしまっている？もう１つforeach作る？回しているのはあくまでシートのkeyなので、checklistのkeyは回してくれないのでそれ用にforeachが必要。
1-2.<?php
	if(!empty($mySheetsAndChecklists)):
		foreach ($mySheetsAndChecklists as $key => $val): 
			debug('$mySheetsAndChecklists：'.print_r($mySheetsAndChecklists,true));
			$checklist = $val['checklist'];
			debug('$checklist：'.print_r($checklist,true)); 
			foreach ($checklist as $key => $val):  ?>
				<label for="checklist<?php echo $val['id'];?>">
					<div class="checklist">
						<input type="checkbox" id="checklist<?php echo $val['id'];?>">
						<?php echo $val['content']; ?>
					</div>
				</label>
	<?php  endforeach;
		endforeach;
	endif; ?>
	⇨ これで取り出すことは出来たが、シートごとではなく全てのチェックリストが取り出されてしまう。
	これをページネーションで分けようと考えていたが、取得の時点でシート分別が出来た方が安全な気がする。また、array_shift($val['checklist'])ではエラーになってしまう。
$__$getMySheetsAndCheckListsのシート分別
marketのcategory分けは、getCategory()でcategoryテーブルからidだけを取り出して、$categoryに格納し、それをgetProductList()の引数に当てている。そしてDBから取得する時点でふるいにかけている。
⬇︎︎⭕️一つのシートからJOINで紐付けてチェックリストを取り出すことにする。
1.$s_id = (!empty($_GET['s_id'])) ? $_GET['s_id'] : '';
$oneSheetAndChecklists = getOneSheetAndChecklists($s_id);
<div class="mytab">
<?php 
if(!empty($mySheetsAndChecklists)):
	foreach ($mySheetsAndChecklists as $key => $val): ?>
	<a href="index.php?s_id=<?php echo $val['id']; ?>" class="tab"><div><p><?php echo $val['name']; ?></p></div></a>
<?php endforeach;
endif;  ?> 
</div>
<div class="mysheet-container">
<div class="mychecklist-container">	
	<?php
	if(!empty($oneSheetAndChecklists)):
		foreach ($oneSheetAndChecklists as $key => $val):?>
		<label for="checklist<?php echo $val['id'];?>">
			<div class="checklist">
				<input type="checkbox" id="checklist<?php echo $val['id'];?>">
				<?php echo $val['content']; ?>
			</div>
		</label>
	<?php endforeach;
	endif; ?>	
</div>
⇨ これでシート毎に表示させることに成功。しかし、index.phpのリンク末尾に常に?s_id=を付与させる必要がある。

$__チェックリストの追加 
<button type="submit" class="btn" name="submit_add">追加</button>
if(!empty($_POST['submit_add'])){ これだと判定できず、
	⬇︎ 
if(isset($_POST['submit_add'])){ これだと判定できた！

<input type="submit" class="btn" name="submit_add" value="追加">
if(!empty($_POST['submit_add'])){
if(isset($_POST['submit_add'])){
inputだと!emptyでもissetでも判定できる。


デバッグ：inputをissetで判定：1
デバッグ：inputを!emptyで判定：1

デバッグ：buttonをissetで判定：1
デバッグ：buttonを!emptyで判定：

$__$s_idの付与
1.会員登録時点でシートを追加して$s_idを付与することには成功したが、チェックリストの追加について、プレースホルダーを使用しての複数のデータをINSERTする方法が分からない。思わぬところでつまずいている。
 // SQL文にキーと値を当て込む
	$data = array(
		array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => '電力会社へ連絡',':date' => date('Y-m-d H:i:s')),
		array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => 'ガス会社へ連絡',':date' => date('Y-m-d H:i:s')),
		array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => '水道会社へ連絡',':date' => date('Y-m-d H:i:s')),
		array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => '引っ越し業者へ連絡',':date' => date('Y-m-d H:i:s')),
	);
	$stmt = $dbh->prepare($sql);
	// クエリ実行
	// $stmt = queryPost($dbh, $sql, $data);
	foreach ($data as $key => $val) {
		$stmt->execute($val);
	}
⇨ これでプリペアドステートメントを使用した複数行のINSERTが出来た！！しかしこれだと何回もデータベースに接続することになっちゃって良くないのかな？
※プリペアドステートメントとは、SQL文を最初に用意しておいて、その後はクエリ内のパラメータの値だけを変更してクエリを実行できる機能のことです。
$__$s_idの付与_最初の表示
	$u_id = $_SESSION['user_id'];
	$mySheetsAndChecklists = getMySheetsAndChecklists($u_id);
	$first_s_id = $mySheetsAndChecklists[0]['id'];
	$s_id = (!empty($_GET['s_id'])) ? $_GET['s_id'] : '';
	$oneSheetAndChecklists = (!empty($s_id)) ? getOneSheetAndChecklists($s_id) : getOneSheetAndChecklists($first_s_id);
	// SQL文にキーと値を当て込む
	$data = array(':u_id' => $u_id, ':s_id' => $s_id, ':content' => $add_checklist, ':date' => date('Y-m-d H:i:s') );
⇨ これだと


$__編集モード_シート名変更
 <input readonly>に使用かと考えたが、修正が面倒なのでやめる。jqueryでクリックされたらinput要素に変わるようにしよう(でもそれはそれでstyleは変えないとダメか)。

$__会員登録時の初期のデフォルトシートの挿入(複数レコードの同時挿入)
$sql = 'INSERT INTO list (user_id, sheet_id, content, create_date) VALUES (:u_id, :s_id, :content, :date)';

$data = array(
	array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => '電力会社へ連絡',':date' => date('Y-m-d H:i:s')),
	array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => 'ガス会社へ連絡',':date' => date('Y-m-d H:i:s')),
	array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => '水道会社へ連絡',':date' => date('Y-m-d H:i:s')),
	array(':u_id' => $_SESSION['user_id'],':s_id' => $s_id,':content' => '引っ越し業者へ連絡',':date' => date('Y-m-d H:i:s')),
);
$stmt = $dbh->prepare($sql);

foreach ($data as $key => $val) {
	$stmt->execute($val);
}

$__チェック状況の保存
1.nameにcheck_flgを付与すると。。。
[21-Nov-2019 12:18:39 Asia/Tokyo] デバッグ：POST情報：Array
(
    [check_flg] => on
)
として、判定はできる。しかしこれだとどれがチェックされているか分からない。そのためお決まりのパターンでname="check_flg<?php echo sanitize($val['id']);"としてIDを付与する。
⬇︎
[21-Nov-2019 12:23:05 Asia/Tokyo] デバッグ：POST情報：Array
(
    [check_flg1] => on
    [check_flg10] => on
    [check_flg35] => on
)
このように判定できる。
⇨ しかしこれだと、配列に格納するときに$check_flgs = $_POST['check_flg']ができなくなる。

2.<input type="checkbox" id="checklist<?php echo sanitize($val['id']);?> js-checklist" name="⭕️check_flg[]" value="<?php echo sanitize($val['id']); ?>"><?php echo sanitize($val['content']); ?>
[21-Nov-2019 13:11:01 Asia/Tokyo] デバッグ：POST情報(チェックの保存ボタン)：Array
(
    [check_flg] => Array
        (
            [0] => 3
            [1] => 4
            [2] => 10
        )
    [submit_save] => チェックの保存
)
check_flg[]のようにnameを配列形式にすると、勝手にキーを作ってくれてその中に値が格納される。
ちなみにvalueを付与しないと値は全て「on」になる。
[21-Nov-2019 13:16:01 Asia/Tokyo] デバッグ：POST情報(チェックの保存ボタン)：Array
(
    [check_flg] => Array
        (
            [0] => on
            [1] => on
        )
    [submit_save] => チェックの保存
)
・処理の流れを想定
もし$check_flg===1なら、class="<?php echo 'checked' ?>"をする？
⇨ でもそれだけだともう１回クリックした時に実際のチェック状況とチェックマークの表示がチグハグになってしまう。
⇨ 上に加えて、$check_flg===1なら　value="<?php echo sanitize($val['id']); ?>" を付与するでいけるかとも思ったが、valueは元々付与されているものなのでこれではクリックされたことにはならない。

最初にクリックした時にjQueryでvalueにsaved_check的なのを付与する？
判定時には、if(saved_checkを持っていたら)にするか？
そして取得時も、
$check_flg===1なら　value="<?php echo sanitize($val['id']).echo saved_check; ?>"
で付与させる？

取得した時に
PHPで$check_flg===1ならcheckedを付与したい。

$('input[value*="check_on"]').prop(':checked');
// var $checkFlgs = $('input[name="check_flg[]"]');

// チェックされたリストのvalueを配列形式で格納
$('input[name="check_flg[]"]').on('change',function(){
	//チェックされたcheckboxのvalueを格納するための空の配列
	var checkFlgsVal = []; 
	// チェックされたらループ処理
	$('input[name="check_flg[]"]:checked').each(function(){
		checkFlgsVal.push($(this).val());
	})
	console.log(checkFlgsVal);
})
こんなようにjQueryを使って:checkedを付与してcheck状態にしようとしたがダメだった。
⬇︎
タグに「checked」を付与するだけで良かったのか！！！
<input type="checkbox" id="checklist<?php echo sanitize($val['id']);?>" name="check_flg[]" value="<?php echo sanitize($val['id']); ?>" <?php if($val['check_flg']==1) echo ' checked'; ?> >
こうすればcheck_flgが立っている時だけチェック状態にできるじゃん！！！
今は確認のためにSQLを直接いじったから、あとは複数のチェック状態をSQLでUPDATEする方法だけだ。

1.signupと同じ要領でやったがダメだった。
	foreach ($check_id as $val) {
	$data = array(':check_id' => $val);
}
// $stmt = queryPost($dbh, $sql, $data);
$stmt = $dbh->prepare($sql);
foreach ($data as $key => $val) {
	$stmt->execute($val);
}
[21-Nov-2019 17:09:46 Asia/Tokyo] PHP Warning:  PDOStatement::execute() expects parameter 1 to be array, string given in /Applications/MAMP/htdocs/IZA/index.php on line 88
[21-Nov-2019 17:14:56 Asia/Tokyo] デバッグ：$check_idの中身：Array
(
    [0] => 1
    [1] => 3
    [2] => 10
)
[21-Nov-2019 17:14:56 Asia/Tokyo] デバッグ：$dataの中身：Array
(
    [:check_id] => 10
)

2.$data = array(':check_id' => $check_id);
[21-Nov-2019 17:18:36 Asia/Tokyo] エラーが発生しました：SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens
これだと当然ダメ。
3.まずSQL文でcheck_flgの=以下を忘れていた。
$sql = 'UPDATE list SET check_flg = :check_flg WHERE id = :check_id AND delete_flg=0';
foreach ($check_id as $val) {
	// SQL文にキーと値を当て込む
	$data = array(':check_flg' => 1,':check_id' => $val);
	// クエリ実行
	$stmt = queryPost($dbh, $sql, $data);
}
このように格納してクエリ実行を繰り返すことで出来た！
// POST送信(チェックの保存ボタン)された場合
if(!empty($_POST['submit_save'])  ){
	debug('POST送信(チェックの保存ボタン)があります。');
	debug('POST情報(チェックの保存ボタン)：'.print_r($_POST,true));
	// 不正な値がPOST送信されていないか判定
	if(!empty($_POST['check_flg']) && is_array($_POST['check_flg'])){
		// チェック状況を変数に格納
		$check_id = $_POST['check_flg'];
		debug('$check_idの中身：'.print_r($check_id,true));
// 配列をINSERTやUPDATEするのはどうやるの？またforeachとかかな？
// あとチェック外されたらどうすんだー
// あと取得する時にチェック状況を復帰させるのはどうやんだ！
// ⇨これ普通のチェックじゃダメなパターンじゃないか？
		// 例外処理
		try{
			// DB接続
			$dbh = dbConnect();
			// SQL文作成
			$sql = 'UPDATE list SET check_flg = :check_flg WHERE id = :check_id AND delete_flg=0';
			foreach ($check_id as $val) {
				// SQL文にキーと値を当て込む
				$data = array(':check_flg' => 1,':check_id' => $val);
				// クエリ実行
				$stmt = queryPost($dbh, $sql, $data);
			}
			// $data = array(
			// 	array()
			// )
			// $data = array(':check_id' => $check_id);
			debug('$dataの中身：'.print_r($data,true));
			// $stmt = queryPost($dbh, $sql, $data);
			// $stmt = $dbh->prepare($sql);
			// foreach ($data as $key => $val) {
			// 	$stmt->execute($val);
			// }
			if($stmt){
				debug('ホーム画面へ遷移します');
				header("Location:index.php?s_id=".$s_id);
			}
		}catch(Exception $e){
			error_log('エラーが発生しました：'.$e->getMessage());
			$err_msg['common'] = MSG06;
		}
	}
}

今度はチェック外れているもののcheck_flgを０に変える方法が分からない！！！！
1.<input type="hidden" name="check_flg[]" value="0">
<input type="checkbox" id="checklist<?php echo sanitize($val['id']);?>" class="js-checklist" name="check_flg[]" value="<?php echo sanitize($val['id']); ?>" <?php if($val['check_flg']==1) echo ' checked'; ?> >
こう書いてあったが動作せず。
[21-Nov-2019 21:30:23 Asia/Tokyo] デバッグ：$check_idの中身：Array
(
    [0] => 0
    [1] => 1
    [2] => 0
    [3] => 2
    [4] => 0
    [5] => 3
    [6] => 0
    [7] => 4
    [8] => 0
    [9] => 10
    [10] => 0
    [11] => 0
    [12] => 34
    [13] => 0
)

2.<label for="checklist<?php echo sanitize($val['id']);?>" class="checklist">
	<input type="checkbox"  id="checklist<?php echo sanitize($val['id']);?>" key="<?php echo sanitize($val['id']);?>">
	<input type="hidden" class="js-checklist" name="check_flg[]" value="false">
	<?php echo sanitize($val['content']); ?>
</label>
// チェックリストがクリックされた時の動作
$('[key]').change(function(){
	var key = $(this).attr('key');
	$('[name="check_flg[' + key + ']"]').val($(this).is(':checked') ? 'true' : 'false');
})
⇨ これはマジでよく分からん。

3.失敗例
// var $jsCheckBox = $('.js-checkbox');
	// $jsCheckList.on('click',function(){
	// 	$(this).siblings($jsCheckBox).toggleClass('checked');
	// })
	// $jsCheckList.on('change',function(){
	// 	var prop = $(this).prop('checked');
	// 	console.log(prop);
		
	// })
	// $('input[value*="check_on"]').prop(':checked');
	// var $checkFlgs = $('input[name="check_flg[]"]');

	// チェックされたリストのvalueを配列形式で格納
	// $('input[name="check_flg[]"]').on('change',function(){
	// 	//チェックされたcheckboxのvalueを格納するための空の配列
	// 	var checkFlgsVal = []; 
	// 	// チェックされたらループ処理
	// 	$('input[name="check_flg[]"]:checked').each(function(){
	// 		checkFlgsVal.push($(this).val());
	// 	})
	// 	console.log(checkFlgsVal);

4.valueにIDとfalseを配列で入れられないかな？
⬇︎
ていうかこれこそAjaxじゃないか！？なぜ気づかなかった。。。
・isLike($u_id,$p_id)はlikeテーブルに入っているかどうかを判定してアイコンに色を付けるだけのため、これはif($val['check_flg']==1){echo 'checked';}で代用出来る。

・Ajax.php
$sql = 'SELECT * FROM `like` WHERE product_id = :p_id AND user_id = :u_id';
⬇︎
$sql = 'SELECT check_flg FROM list WHERE id = :check_id 一応 AND sheet_id = :s_id';
$data = array(':check_id' => $oneSheetAndChecklists['id'],':s_id' => $s_id);
$stmt = queryPost($dbh, $sql, $data);
$result = $stmt->fetch(PDO::FETCH_ASSOC);//fetchAllかどうかはやってみないと分からん
if($result==1){
	$sql = 'UPDATE check_flg=:check_flg';
	$data = array(':check_flg' => 0);
}elseif($result==0){
	$sql = 'UPDATE '
}
⇨JS:clickCheckId:1
 [22-Nov-2019 13:06:35 Asia/Tokyo] デバッグ：チェックリストのID：1
	通信には成功したが、チェックリストのIDが全て１になってしまう。。。
・<input type="checkbox" id="checklist3" class=" js-click-check" data-clickcheckid="3" name="check_flg[]" value="3">
	検証で見ると、ちゃんとIDの数値になっている。取得は出来ている。
・clickCheckId:number：もしかしたら取得する段階のどこかで文字列に変わってしまっているのではないかと思ったが、ちゃんと数値型になっている。
・debug('POST送信直後チェックリストのID：'.print_r($_POST['clickcheckId']));
// IDが０の場合もあるためissetで判定。
if(isset($_POST['clickcheckId']) && isset($_SESSION['user_id']) ){
[22-Nov-2019 13:10:34 Asia/Tokyo] デバッグ：POST送信直後チェックリストのID：1
・// clickcheckIdをキー名としてclickCheckIdの値を送信する
 data: {clickcheckId : 3}
 ここで試しに3を渡してみたら、正常に動いた！！やはりHTMLからJSでdataを取得する際に1に変わってしまっている。つまりajaxChecked.phpには間違いは無い。
 ・$jsClickCheck.data('clickcheckid'):1
 	格納される前からすでに１に変わっている。つまり完全にHTML⇨JSの段階。
 ・<input type="checkbox" id="checklist<?php echo sanitize($val['id']);?>" class=" js-click-check" data-clickcheckid="3"
 	clickCheckId:3
 	dataの値をPHPで取得するのではなく直接3としたら正常に動いた。。。
 ⬇︎
 分かった！！！！foreachでidを回してるからだ！！！！おそらくforeach文の１周目の段階でJSでデータを取得してしまうため全て1になってしまうんだ。
 ⬇︎それだけじゃなかった！！！
 	// チェックボックスをDOMに格納
	$jsClickCheck = $('.js-click-check') || null ;
	// チェックリストのIDを格納
	clickCheckId = $jsClickCheck.data('clickcheckid') || null ;	　
	// IDが０の場合もあるのでundefinedとnullの時のみfalseと判定する
	if(clickCheckId !== undefined && clickCheckId !== null){
		// チェックボックスがクリックされた時の処理
		$jsClickCheck.on('click',function(){
⭕️追加	
			$.ajax({
				//ajaxChecked.phpにPOST送信
				type:"POST",
				url:"ajaxChecked.php",
				// clickcheckIdをキー名としてclickCheckIdの値を送信する
				data: {clickcheckId : clickCheckId}
			// Ajaxリクエストに成功した場合
			}).done(function(data) {
				console.log('Ajaxに成功しました');
			// Ajaxリクエストに失敗した場合
			}).fail(function(data){
				console.log('Ajaxに失敗しました');
			});		
		});
	}
	これだとクリックされた時にどのチェックリストのdataを格納するか指定されていない！！！
	だから一番最初の要素のdataが格納されてしまっていたんだ。
⬇︎

// $__チェックボックス作成
// jQueryだとDOMを作成する時にクリックされたものとして特定しなければいけない。
// $('#js-checkbox').on('click',function(){
// 	$(this).
// })
// で特定できるんだっけ？ ⇨ 出来た。
// <label for="checklist<?php echo sanitize($val['id']);?>" class="checklist js-checklist">
// 	<input type="checkbox" id="checklist<?php echo sanitize($val['id']);?>" name="check_flg[]" value="<?php echo sanitize($val['id']);?>">
// ⇨ ❌これだとlabelにfor属性があるせいか、２回クリックされていると判定されてしまう。
// ⬇︎
// <label for="checklist<?php echo sanitize($val['id']);?>" class="checklist">
// 	<input type="checkbox" id="checklist<?php echo sanitize($val['id']);?>" class="js-checklist" name="check_flg[]" value="<?php echo sanitize($val['id']);?>">
// ⇨ inputタグをDOMに指定すれば解決！


