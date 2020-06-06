<?php
///共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ホーム画面　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//================================
// 画面処理
//================================
// ログイン認証
require('auth.php');

//ユーザーIDを格納
$u_id = $_SESSION['user_id']; 
//自分が登録したシートとチェックリストの情報を格納
$mySheetsAndChecklists = getMySheetsAndChecklists($u_id); 
//会員がこのページ遷移した時に最初に表示するシートのIDを格納
$first_s_id = $mySheetsAndChecklists[0]['id']; 
//GETパラメータにシートのIDがあれば格納
$s_id = (!empty($_GET['s_id'])) ? $_GET['s_id'] : $first_s_id; 
// GETパラメータのシートIDか最初のシートIDを引数にしてチェックリスト情報を格納
$oneSheetAndChecklists = (!empty($s_id)) ? getOneSheetAndChecklists($s_id) : getOneSheetAndChecklists($first_s_id); 
// 登録済みシートの数を取得する
$numberOfMySheets = countMySheets($u_id);
debug('特定のチェックリストシート情報：'.print_r($oneSheetAndChecklists,true));
debug('登録済みチェックリストシート情報：'.print_r($mySheetsAndChecklists,true));
debug('登録済みシートの枚数：'.print_r($numberOfMySheets,true));

// POST送信(チェックリスト追加ボタン)された場合
if(!empty($_POST['submit_add_check'])){
	debug('POST送信(追加ボタン)があります。');
	debug('POST情報(追加ボタン)：'.print_r($_POST,true));
	// POST送信された値を変数に格納する
	$add_checklist = $_POST['add_checklist'];

	// バリデーション
	// 未入力チェック
	validRequired($add_checklist,'add_checklist');
	// 最大文字数チェック
	validMaxLen($add_checklist,'add_checklist',28);
	// エラーが無い場合
	if(empty($err_msg)){
		// 例外処理
		try{
			// DB接続
			$dbh = dbConnect();
			// SQL文作成
			$sql = 'INSERT INTO list (user_id, sheet_id, content, create_date) VALUES (:u_id, :s_id, :content, :date)';
			// SQL文にキーと値を当て込む
			$data = array(':u_id' => $u_id, ':s_id' => $s_id, ':content' => $add_checklist, ':date' => date('Y-m-d H:i:s') );
			// クエリ実行
			$stmt = queryPost($dbh, $sql, $data);
			// クエリ成功の場合
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
// POST送信(シート追加ボタン)された場合
if(!empty($_POST['submit_add_sheet'])){
	debug('POST送信(シート追加ボタン)があります。');
	debug('POST情報(シート追加ボタン)：'.print_r($_POST,true));
	// POST送信された値を変数に格納する
	$tab_name = $_POST['tab_name'];
	$select_color = (isset($_POST['select_color']))? $_POST['select_color']:'1';
	debug('$select_color:'.$select_color);

	// 作成したシートが６枚を超えたらエラー
	if((int)$numberOfMySheets === 6){
		$err_msg['common'] = MSG16;
	}
	// バリデーション
	// 未入力チェック
	validRequired($tab_name,'common');
	validRequired($select_color,'common');
	// 入力されていた場合
	if(empty($err_msg)){
		// タブ名チェック
		validMaxLen($tab_name,'common',6);
		// 色の値チェック
		validHalfnumber($select_color,'common');
		validMaxLen($select_color,'common',2);
		// エラーが無い場合
		if(empty($err_msg)){
			// 例外処理
			try{
				// DB接続
				$dbh = dbConnect();
				// SQL文作成
				$sql = 'INSERT INTO sheet (user_id, name, color, create_date) VALUES (:u_id, :tab_name, :color, :date)';
				// SQL文にキーと値を当て込む
				$data = array(':u_id' => $u_id, ':tab_name' => $tab_name, ':color' => $select_color, ':date' => date('Y-m-d H:i:s') );
				// クエリ実行
				$stmt = queryPost($dbh, $sql, $data);
				// クエリ成功の場合
				if($stmt){
					// GETパラメータを付与するためにシートのIDを取得する
					$s_id = $dbh->lastInsertId();		
					debug('ホーム画面へ遷移します');
					header("Location:index.php?s_id=".$s_id);
				}
			}catch(Exception $e){
				error_log('エラーが発生しました：'.$e->getMessage());
				$err_msg['common'] = MSG06;
			}
		}
	}
}
// POST送信(チェックリストの削除ボタン)された場合
if(!empty($_POST['submit_delete_list'])){
	debug('POST送信(チェックリストの削除ボタン)があります。');
	debug('POST情報(チェックリストの削除ボタン)：'.print_r($_POST,true));	
	// 未選択チェック
	if(isset($_POST['delete_list']) && is_array($_POST['delete_list'])){	
		// 選択されたチェックリストのIDを変数に格納
		$delete_id = $_POST['delete_list'];
		debug('$delete_listの中身：'.print_r($delete_list,true));
		// 例外処理
		try{
			// DB接続
			$dbh = dbConnect();
			// SQL文作成
			$sql = 'DELETE FROM list WHERE id = :delete_id AND delete_flg=0';
			// ループ処理でSQL文にキーと値を当て込む
			foreach($delete_id as $val){
				$data = array(':delete_id' => $val);
				$stmt = queryPost($dbh, $sql, $data);
			}
			// クエリ成功の場合
			if($stmt){
				debug('ホーム画面へ遷移します');
				header("Location:index.php?s_id=".$s_id);
			}
		}catch(Exception $e){
			error_log('エラーが発生しました：'.$e->getMessage());
			$err_msg['common'] = MSG06;
		}
	}else{
		$err_msg['common'] = MSG15;
	}
}
// POST送信(シートの削除ボタン)された場合
if(!empty($_POST['submit_delete_sheet'])){
	debug('POST送信(シートの削除ボタン)があります。');
	debug('POST情報(シートの削除ボタン)：'.print_r($_POST,true));	
	// 不正な値がPOST送信されていないか判定
	if($_POST['submit_delete_sheet'] === 'submit'){
		debug('削除するシートID：'.$s_id);

		// 作成したシートが１枚ならエラー
		if((int)$numberOfMySheets === 1){
		$err_msg['common'] = MSG17;
		}
		// エラーが無い場合
		if(empty($err_msg)){
			// 例外処理
			try{
				// DB接続
				$dbh = dbConnect();
				// SQL文作成
				$sql = 'DELETE FROM sheet WHERE id = :s_id AND delete_flg=0';
				// SQL文にキーと値を当て込む
				$data = array(':s_id' => $s_id);
				// クエリ実行
				$stmt = queryPost($dbh, $sql, $data);
				// クエリ成功の場合
				if($stmt){
					debug('ホーム画面へ遷移します');
					header("Location:index.php");
				}
			}catch(Exception $e){
				error_log('エラーが発生しました：'.$e->getMessage());
				$err_msg['common'] = MSG06;
			}
		}
	}
}
?>

<?php
$siteTitle = 'HOME';
require('head.php');
?>

<body class="page-home">
	<!-- メッセージ表示 -->
	<p id="js-area-msg" class="area-slide-msg"><?php echo getSessionFlash('success_msg_prof') ;?></p>
	<!-- メニュー -->
	<?php
	require('header.php');
	?>
	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">	
		<h1 class="page-title">MY CHECKLIST</h1>
		<div class="area-msg">
		<?php showErrMsg('common'); ?>
		</div>
		<section id="main">
			<div class="mynote-container">
				<form action="" method="post" class="form">
					<!-- タブ -->
					<div class="tab-area">
						<div class="mytabs">
						<?php 
						if(!empty($mySheetsAndChecklists)):
							foreach ($mySheetsAndChecklists as $key => $val): 
							 ?>
								<a href="index.php?s_id=<?php echo sanitize($val['id']); ?>" class="tab color<?php echo sanitize($val['color']); ?> 
								<?php
								if($val===reset($mySheetsAndChecklists)){
										if(empty($_GET)){ 
											echo 'active-tab';
										}elseif($val['id'] === $s_id){
											echo 'active-tab';
										}
									}elseif($val['id'] === $s_id ){
										echo 'active-tab';
									}; ?>
								">
									<p class="tab-name
										<?php
										if($val===reset($mySheetsAndChecklists)){
											if(empty($_GET)){ 
												echo 'active-name';
											}elseif($val['id'] === $s_id){
												echo 'active-name';
											}
										}elseif($val['id'] === $s_id ){
											echo 'active-name';
										}; ?>
									">
									<?php echo sanitize($val['name']); ?>
									</p>
								</a>
								<?php endforeach; ?>
						</div>
						<?php endif;  ?>
						<div class="tab tab-blank">
							<input type="text" class="tab-name-input" name="tab_name" maxlength="6" placeholder="新規タブ名">
							<a class="color-palette-btn js-color-palette-btn">
							</a>
							<button type="submit" class="add-tab-btn" name="submit_add_sheet" value="submit">＋</button>
							<div class="color-palettes js-modal" style="display: none;">
								<p>タブの色を選んでください</p>
								<div class="palette-area">					<?php 
									for ($i=1; $i <= 9; $i++) { 
										echo '<input type="radio" id="select-color'.$i.'" name="select_color" value="'.$i.'">
											<label for="select-color'.$i.'" class="js-color-palette select-color'.$i. '"></label>';
									}
									?>
								</div>
								<a class="js-modal-close">閉じる</a>
							</div>
						</div>
											
					</div>

					<!-- チェックリスト -->
					<div class="mysheet-container">
						<?php if(!empty($oneSheetAndChecklists)): ?>
							<p class="js-delete-show" style="display: none;">削除したいチェックリストを選択してください</p>
						<?php endif; ?>
						<div class="mychecklist-container">	
							<?php
							if(!empty($oneSheetAndChecklists)){
								foreach ($oneSheetAndChecklists as $key => $val): ?>
									<label for="checklist<?php echo sanitize($val['id']);?>" class="checklist js-delete-list">
									<input type="checkbox" id="checklist<?php echo sanitize($val['id']);?>" class="js-click-check"
									data-clickcheckid="<?php echo sanitize($val['id']); ?>" value="<?php echo sanitize($val['id']); ?>" <?php if($val['check_flg']==1){ 
											echo ' checked';
										}elseif($val['check_flg']==0){
											echo '';
										} ?> >
									<input type="checkbox" id="delete-list<?php echo sanitize($val['id']);?>" class="js-click-delete" name="delete_list[]" value="<?php echo sanitize($val['id']); ?>" style="display: none;" >
									<?php echo sanitize($val['content']); ?>
								</label>							
							<?php
								endforeach;
							}else{ ?>
							<p>チェックリストを追加してください</p>
							<?php } ?>
						</div>
						<div class="btn-container">
							<?php if(!empty($oneSheetAndChecklists)): ?>
							<button type="submit" class="btn delete-list-btn js-delete-show" name="submit_delete_list" value="submit" style="display: none;">チェックリスト削除</button>
							<?php endif; ?>	
							<button type="submit" class="btn delete-sheet-btn js-delete-show" name="submit_delete_sheet" value="submit" style="display: none;">現在のシート削除</button>					
							
							<a href="index.php?s_id=<?php echo sanitize($s_id); ?>" class="js-delete-show" style="display: none;">キャンセル</a>

						</div>
					</div>					
				</form>
			</div>
			<div class="area-msg">
			<?php showErrMsg('add_checklist'); ?>
			</div>
			<div class="area-edit">
				<div class="area-add-checklist">
					<form action="" class="form" method="post">
						<input type="text" class="add-checklist" name="add_checklist"  placeholder="追加したいリストを入力">
						<button type="submit" class="btn" name="submit_add_check" value="submit">追加</button>
					</form>
				</div>
				<div class="area-delete-checklist">
					<div class="delete-icon js-delete-mode">
						<span>削除モード</span>
					</div>
				</div>
			</div>
		</section>
	</div>

	<!-- フッター -->
	<?php
	require('footer.php');
	?>

</body>











