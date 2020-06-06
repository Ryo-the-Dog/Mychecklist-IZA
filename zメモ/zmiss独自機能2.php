<?php
$dsn = 'mysql:dbname=ryokunnext_wp3;host=mysql8050.xserver.jp;charset=utf8';
	$user = 'ryokunnext_wp3';
	$password = 'og5rlp92yu';
function dbConnect(){
	$dsn = 'mysql:dbname=mychecklist;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'root';


$__シートの追加
1.<a href="index.php?s_id=<?php echo sanitize($val['id']); ?>" class="tab color<?php echo sanitize($val['color']); ?>"><div><p><?php echo sanitize($val['name']); ?></p></div></a>
<?php endforeach; ?>
<a href="index.php?s_id=<?php $val['id']+1 ?>" class="tab color-blank"><div><p>＋追加する</p></div></a>
⇨ 最初はこれでいけたと思ったが、シートのIDは全くもって連番ではないので、すでに登録済みのシートが取得されたりしてしまう。

<?php
2.もう追加ボタンが押された時点でDBにシートを追加しちゃおう
⬇︎
しかしこれだとタグ名などが指定出来ない。

$__削除モード
削除ボタン押す　⇨ $val['id']を持ったcheckboxをリストとタブ内に出現させる。
⇨ ていうかタブのIDとリストのIDって判別出来ないからやっぱり一括管理は無理じゃね？
⬇︎
タブ削除ボタンとリスト削除ボタンを作ればいいか。

1.・jQueryでクリックした時にmytabsのa要素とmysheetcontainerのchecklistにdelete-modeのようなclass名を付与して、スタイルをopacity=0.5くらいに指定する。
・削除用のcheckboxを出現させる。checkboxのlabel for=" "をjQueryのmb_strings的な関数で('checklist','delete-list')などで変更する。
2.// ラベルを削除用のチェックボックスと連動させる
var changeFor = $deleteList.attr('for').replace('checklist','delete-list');
$deleteList.attr('for',changeFor);
⇨ これだと、replaceでcheclist1をdelete-list1に変える。そして全チェックリストのforをattrで「delete-list1」に変えるという処理になってしまっている。


$__DBのレコード数制限
登録済みシートの枚数を取得して、それをif文で判定にかける。もし６を超えていたら$err_msgを表示。
1.$sql = 'SELECT COUNT(*) FROM sheet WHERE id = :u_id AND delete_flg=0';
	// SQL文にキーと値を当て込む
	$data = array(':u_id' => $u_id);
	// クエリ実行
	$stmt = queryPost($dbh, $sql, $data);
	$result = $stmt->rowCount;
	debug('登録済みシートの枚数$result：'.print_r($result,true));
	if($result){
		return $result->rowCount();
	}
⇨ １になってしまう。配列で入っているため。

2.$sql = 'SELECT COUNT(*) FROM sheet WHERE id = :u_id AND delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		debug('登録済みシートの枚数$result：'.print_r($result,true));
		if($result){
			return $result->rowCount();
		}

⇨ [24-Nov-2019 20:51:26 Asia/Tokyo] PHP Fatal error:  Uncaught Error: Call to a member function rowCount() on array in /Applications/MAMP/htdocs/IZA/function.php:329
Stack trace:
#0 /Applications/MAMP/htdocs/IZA/index.php(27): countMySheets('14')
#1 {main}
  thrown in /Applications/MAMP/htdocs/IZA/function.php on line 329

3.$sql = 'SELECT COUNT(*) FROM sheet WHERE id = :u_id AND delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		debug('登録済みシートの枚数$stmt：'.print_r($stmt,true));
		if($stmt){
			return $stmt->rowCount();
		}
⇨ [24-Nov-2019 20:58:36 Asia/Tokyo] デバッグ：登録済みシートの枚数$stmt：PDOStatement Object
(
    [queryString] => SELECT COUNT(*) FROM sheet WHERE id = :u_id AND delete_flg=0
)

4.$sql = 'SELECT (*) FROM sheet WHERE id = :u_id AND delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		$result = $stmt->rowCount();
		debug('登録済みシートの枚数$result：'.print_r($result,true));
		if($stmt){
			return $result;
		}
⇨ [24-Nov-2019 21:05:28 Asia/Tokyo] エラーが発生しました：SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '*) FROM sheet WHERE id = '14' AND delete_flg=0' at line 1

5.$sql = 'SELECT (*) FROM sheet WHERE id = :u_id AND delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		$result['total'] = $stmt->rowCount();
		debug('登録済みシートの枚数$result：'.print_r($result,true));
		if($stmt){
			return $result;
		}
⇨ [24-Nov-2019 21:08:21 Asia/Tokyo] エラーが発生しました：SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '*) FROM sheet WHERE id = '14' AND delete_flg=0' at line 1

6.$sql = 'SELECT id FROM sheet WHERE id = :u_id AND delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		$result['total'] = $stmt->rowCount();
		debug('登録済みシートの枚数$result：'.print_r($result['total'],true));
		if($stmt){
			return $result;
		}
⇨ [24-Nov-2019 21:11:38 Asia/Tokyo] デバッグ：登録済みシートの枚数$result：0

7.$sql = 'SELECT count(*) FROM sheet WHERE id = :u_id AND delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		$result = $stmt->fetchAll();
		debug('登録済みシートの枚数$result：'.print_r($result,true));
		if($result){
			return $result;
		}
⇨ [24-Nov-2019 21:16:40 Asia/Tokyo] デバッグ：登録済みシートの枚数$result：Array
(
    [0] => Array
        (
            [count(*)] => 0
        )
)

8.$sql = 'SELECT count(*) FROM sheet';
		// SQL文にキーと値を当て込む
		$data = array();
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		$result = $stmt->fetchAll();
		debug('登録済みシートの枚数$result：'.print_r($result,true));
		if($result){
			return $result;
		}
⇨ [24-Nov-2019 21:22:12 Asia/Tokyo] デバッグ：登録済みシートの枚数$result：Array
(
    [0] => Array
        (
            [count(*)] => 10
        )
)
⬇︎なんてことはない、ただuser_idをidと書いてしまっただけだった
8.$sql = 'SELECT count(*) FROM sheet WHERE user_id = :u_id AND delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		$result = $stmt->fetchAll();
		debug('登録済みシートの枚数$result：'.print_r($result,true));
		if($result){
			return $result;
		}
⇨ (
    [0] => Array
        (
            [count(*)] => 4
        )
)
9.$sql = 'SELECT count(*) FROM sheet WHERE user_id = :u_id AND delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		debug('登録済みシートの枚数$result：'.print_r($result,true));
		if($result){
			return $result;
		}
⇨ [24-Nov-2019 21:28:33 Asia/Tokyo] デバッグ：登録済みシートの枚数$result：Array
(
    [count(*)] => 4
)
⇨ debug('登録済みシートの枚数：'.print_r($numberofMySheets['count(*)'],true));
[24-Nov-2019 21:30:45 Asia/Tokyo] デバッグ：登録済みシートの枚数：4
10.$sql = 'SELECT count(id) FROM sheet WHERE user_id = :u_id AND delete_flg=0';
		// SQL文にキーと値を当て込む
		$data = array(':u_id' => $u_id);
		// クエリ実行
		$stmt = queryPost($dbh, $sql, $data);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		debug('登録済みシートの枚数$result：'.print_r($result,true));
		if($result){
			return $result;
		}
⇨ [24-Nov-2019 21:32:07 Asia/Tokyo] デバッグ：登録済みシートの枚数$result：Array
(
    [count(id)] => 4
)
⬇︎
if($result){
	return array_shift($result);
}
[25-Nov-2019 10:38:55 Asia/Tokyo] デバッグ：登録済みシートの枚数：6
そうだ、array_shift()すれば取り出せるじゃん。。。

$__ハンバーガーメニュー
	var $navToggle = $('#nav-toggle');
	var $navToggleOpen = $('#nav-toggle,#top-nav');
	$navToggle.on('click',function(){
		
		$navToggleOpen.toggleClass('nav-toggle-open');

		// ハンバーガーメニューを閉じるための処理
		//================================
		$(document).on('click',function(event){
			var $clickTarget = $('#nav-toggle,#nav-list');
			if(!$(event.target).closest($clickTarget).length){
				$navToggleOpen.removeClass('nav-toggle-open');
			}
		})
	})



