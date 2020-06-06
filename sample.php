<?php
///共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　サンプルページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

?>

<?php
$siteTitle = 'サンプル';
require('head.php');
?>

<body class="page-sample">
	<!-- メニュー -->
	<?php
	require('header.php');
	?>
	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">	
		<h1 class="page-title">SAMPLE</h1>
		<p class="signup-msg">ご利用には<a href="signup.php" class="signup-link">会員登録</a>が必要です<br>
		※最初は「防災」のみ登録されています</p>
		<section id="main">
			<div class="mynote-container">
				<form action="" method="post" class="form">
					<!-- タブ -->
					<div class="tab-area">
						<div class="mytabs">
							<a href="sample.php?sample_id=1" class="tab color1 <?php if($_GET['sample_id']==1) echo 'active-tab';  ?>"><div><p class="tab-name <?php if($_GET['sample_id']==1) echo 'active-name';  ?>">防災</p></div></a>
							<a href="sample.php?sample_id=2" class="tab color2 <?php if($_GET['sample_id']==2) echo 'active-tab';  ?>"><div><p class="tab-name <?php if($_GET['sample_id']==2) echo 'active-name';  ?>">引っ越し</p></div></a>							
						</div>
						<div class="tab tab-blank">
							<input type="text" class="tab-name-input" name="tab_name" maxlength="6" placeholder="新規タブ名" >
							<a class="color-palette-btn js-color-palette-btn">
							</a>
							<input type="" class="add-tab-btn" name="submit_add_sheet" value="＋">
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
							<p class="js-delete-show" style="display: none;">削除したいチェックリストを選択してください</p>
						<div class="mychecklist-container">
						<?php
						if($_GET['sample_id']==1): 
						?>
							<label for="checklist1" class="checklist js-delete-list">
								<input type="checkbox" id="checklist1" class="js-click-check">
								<input type="checkbox" id="delete-list1" class="js-click-delete" style="display: none;" >
								食料(３日分)
							</label>
							<label for="checklist2" class="checklist js-delete-list">
								<input type="checkbox" id="checklist2" class="js-click-check">
								<input type="checkbox" id="delete-list2" class="js-click-delete" style="display: none;" >
								飲料水(３日分)
							</label>
							<label for="checklist3" class="checklist js-delete-list">
								<input type="checkbox" id="checklist3" class="js-click-check">
								<input type="checkbox" id="delete-list3" class="js-click-delete" style="display: none;" >
								トイレットペーパー
							</label>
							<label for="checklist4" class="checklist js-delete-list">
								<input type="checkbox" id="checklist4" class="js-click-check">
								<input type="checkbox" id="delete-list4" class="js-click-delete" style="display: none;" >
								ランタン
							</label>
							<label for="checklist5" class="checklist js-delete-list">
								<input type="checkbox" id="checklist5" class="js-click-check">
								<input type="checkbox" id="delete-list5" class="js-click-delete" style="display: none;" >
								充電器
							</label>
							<label for="checklist6" class="checklist js-delete-list">
								<input type="checkbox" id="checklist6" class="js-click-check">
								<input type="checkbox" id="delete-list6" class="js-click-delete" style="display: none;" >
								軍手
							</label>
							<label for="checklist7" class="checklist js-delete-list">
								<input type="checkbox" id="checklist7" class="js-click-check">
								<input type="checkbox" id="delete-list7" class="js-click-delete" style="display: none;" >
								タオル
							</label>
							<label for="checklist8" class="checklist js-delete-list">
								<input type="checkbox" id="checklist8" class="js-click-check">
								<input type="checkbox" id="delete-list8" class="js-click-delete" style="display: none;" >
								衣類・下着
							</label>
							<label for="checklist9" class="checklist js-delete-list">
								<input type="checkbox" id="checklist9" class="js-click-check">
								<input type="checkbox" id="delete-list9" class="js-click-delete" style="display: none;" >
								救急用品
							</label>
								
						<?php elseif($_GET['sample_id'] == 2): ?>
							<label for="checklist1" class="checklist js-delete-list">
								<input type="checkbox" id="checklist1" class="js-click-check">
								<input type="checkbox" id="delete-list1" class="js-click-delete" style="display: none;" >
								物件を探す
							</label>
							<label for="checklist2" class="checklist js-delete-list">
								<input type="checkbox" id="checklist2" class="js-click-check">
								<input type="checkbox" id="delete-list2" class="js-click-delete" style="display: none;" >
								現住居の管理会社へ連絡
							</label>
							<label for="checklist3" class="checklist js-delete-list">
								<input type="checkbox" id="checklist3" class="js-click-check">
								<input type="checkbox" id="delete-list3" class="js-click-delete" style="display: none;" >
								電力会社へ連絡
							</label>
							<label for="checklist4" class="checklist js-delete-list">
								<input type="checkbox" id="checklist4" class="js-click-check">
								<input type="checkbox" id="delete-list4" class="js-click-delete" style="display: none;" >
								ガス会社へ連絡
							</label>
							<label for="checklist5" class="checklist js-delete-list">
								<input type="checkbox" id="checklist5" class="js-click-check">
								<input type="checkbox" id="delete-list5" class="js-click-delete" style="display: none;" >
								水道会社へ連絡
							</label>
							<label for="checklist6" class="checklist js-delete-list">
								<input type="checkbox" id="checklist6" class="js-click-check">
								<input type="checkbox" id="delete-list6" class="js-click-delete" style="display: none;" >
								引っ越し業者へ連絡
							</label>
							<label for="checklist7" class="checklist js-delete-list">
								<input type="checkbox" id="checklist7" class="js-click-check">
								<input type="checkbox" id="delete-list7" class="js-click-delete" style="display: none;" >
								荷造り
							</label>
							<label for="checklist8" class="checklist js-delete-list">
								<input type="checkbox" id="checklist8" class="js-click-check">
								<input type="checkbox" id="delete-list8" class="js-click-delete" style="display: none;" >
								清掃
							</label>
						<?php endif; ?>
						</div>
						<div class="btn-container">
							<span class="btn delete-list-btn js-delete-show" style="opacity: 0.5;display: none;">ご利用には<br>会員登録が必要です</span>
							<span class="btn delete-sheet-btn js-delete-show" style="opacity: 0.5;display: none;">ご利用には<br>会員登録が必要です</span>					
							
							<a href="sample.php?sample_id=1" class="js-delete-show" style="display: none;">キャンセル</a>

						</div>
					</div>					
				</form>
			</div>
			<div class="area-edit">
				<div class="area-add-checklist">
					<form action="" class="form" method="post">
						<input type="text" class="add-checklist" name="add_checklist"  placeholder="追加したいリストを入力">
						<span class="btn">会員登録が必要です</span>
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