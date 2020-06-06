<?php
///共通変数・関数ファイルを読込み
require('function.php');


?>
<?php
$siteTitle = 'テンプレート';
require('head.php');
?>

<body class="page-addTemplate">
	<!-- メニュー -->
	<?php
	require('header.php');
	?>
	<!-- メインコンテンツ -->
	<div id="contents" class="site-width">		
		<h1 class="page-title">TEMPLATE</h1>
		<p>好きなシートを選んで追加ボタンを押すとマイチェックリストに追加されます</p>
		<section id="main">
			<div class="mynote-container">
				<form action="" class="form">
					<div class="mytabs">
						<a href="" class="tab"><div><p>引っ越し</p></div></a>
						<a href="" class="tab"><div><p>出張</p></div></a>
						<a href="" class="tab"><div><p>防災</p></div></a>
					</div>
					<div class="mysheet-container">
						<div class="mychecklist-container">	
							<div class="checklist"><input type="checkbox">電力会社に連絡</div>
							<div class="checklist"><input type="checkbox"></div>
							<div class="checklist"><input type="checkbox"></div>
							<div class="checklist"><input type="checkbox"></div>
						</div>
						
					</div>
					<div class="btn-container">
						<button type="submit" class="btn">追加</button>
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