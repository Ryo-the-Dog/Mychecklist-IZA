<footer id="footer">
	<div class="site-width">
		<small class="copy">&copy;2019 <a href="https://ryonexta.com/" target="_blank">NextStandard</a></small>
		 <small><i class="fab fa-twitter"></i>Twitter:<a class="author" href="https://twitter.com/ryonextStandard" target="_blank">@ryonextStandard</a></small>
	</div>
</footer>

<script src="js/vendor/jquery-3.4.1.min.js"></script>
<script>
$(function(){
	//================================
	// フッターの位置調整
	//================================
	var $ftr = $('#footer');
	if(window.innerHeight > $ftr.offset().top + $ftr.outerHeight() ){
		$ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) + 'px;' });
	};

	//================================
	// ハンバーガーメニュー
	//================================
	// メニューボタン
	var $navToggle = $('#nav-toggle');
	var $navToggleOpen = $('#nav-toggle,#top-nav');
	$navToggle.on('click',function(){
		
		$navToggleOpen.toggleClass('nav-toggle-open');

		// ハンバーガーメニューを閉じるための処理
		//================================
		$(document).on('click',function(event){
			// メニューボタンとリスト要素
			var $clickTarget = $('#nav-toggle,#nav-list');
			// メニューボタンとリスト要素以外がクリックされた場合
			if(!$(event.target).closest($clickTarget).length){
				$navToggleOpen.removeClass('nav-toggle-open');
			}
		})
	})

	//================================
	// 処理を実行した時にメッセージを表示させる
	//================================
	var $jsAreaMsg = $('#js-area-msg');
	var msg = $jsAreaMsg.text();
	// 文字が入っていた場合
	if(msg.replace(/^[\s　]+|[\s　]+$/g,"").length){ //スペースが入ってしまうので空欄にする
		$jsAreaMsg.slideToggle('slow');
		setTimeout(function(){
			$jsAreaMsg.slideToggle('slow');
		},5000);
	}

	//================================
	// Ajax チェック状況の保存
	//================================
	// 使用する変数の宣言
	var $clickCheck,
		clickCheckId;
	// チェックボックスをDOMに格納
	$clickCheck = $('.js-click-check') || null ;
	// チェックリストのIDを格納
	checkId = $clickCheck.data('clickcheckid') || null ;
	　
	// IDが０の場合もあるのでundefinedとnullの時のみfalseと判定する
	if(checkId !== undefined && clickCheckId !== null){
		// チェックボックスがクリックされた時の処理
		$clickCheck.on('click',function(){
			var $this = $(this);	
			// クリックされたチェックリストのIDを格納
			clickCheckId = $this.data('clickcheckid') || null ;
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

	//================================
	// カラーパレットのモーダル
	//================================
	// カラーパレット表示ボタンをDOMに格納
	var $jsModalOpen = $('.js-color-palette-btn');
	var $jsModalClose = $('.js-color-palette,.js-modal-close');
	var jsModal = $('.js-modal');
	$jsModalOpen.on('click',function(){
		jsModal.fadeIn();
	})
	$jsModalClose.on('click',function(){
		jsModal.fadeOut();
	})
	// カラーパレットが選択された時の処理
	var $jsColorPaletteBtn = $('.js-color-palette-btn');
	var $jsColorPalette = $('.js-color-palette');
	$jsColorPalette.on('click',function(){
		var $this = $(this);
		var selectColor = $this.css('background-color');
		$jsColorPaletteBtn.css('background-color',selectColor);
	})

	//================================
	// 削除モード
	//================================
	// 削除モード開始のボタン
	var $jsDeleteMode = $('.js-delete-mode');
	// チェックリストラベル
	var $deleteList = $('.js-delete-list');
	// チェックリストの削除用チェックボックス
	var $deleteCheck = $('.js-click-delete');
	// チェックリストの削除ボタン
	var $jsDeleteShow = $('.js-delete-show');

	$jsDeleteMode.on('click',function(){
		// 各ラベルを変更して削除用のチェックボックスと連動させる
		$deleteList.each(function(index,element){
			var str = $(element).attr('for');
			str = str.replace('checklist','delete-list');
			$(element).attr('for',str);
		});
		// チェックリストの削除ボタンを表示させる
		$jsDeleteShow.show();
		// チェックリストとタブを透過させる
		$deleteList.addClass('delete-mode');
		// クリックされた要素は透過を元に戻す
		$deleteCheck.on('click',function(){
			var $this = $(this);
			$this.closest('.js-delete-list').toggleClass('delete-mode');
		})	
	})
	// 削除ボタン押下後のアラート
	//================================
	// 削除ボタン
	$deleteBtns = $('.delete-list-btn,.delete-sheet-btn');
	
	$deleteBtns.on('click',function(){
		// アラートのメッセージ
		var alertMsg = '一度削除すると元に戻せません。削除してよろしいですか？';
		// アラートの結果
		var resultConfirm = confirm(alertMsg);
		// はいが選択された場合
		if(resultConfirm){
			return true;
		}else{
			return false;
		}		
	})




})
</script>