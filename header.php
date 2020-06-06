

<header>
	<div class="site-width">
		<h1><a href="index.php">
			<p class="title-small">My Checklist</p>
			<p class="title-large">IZA</p>
		</a></h1>
		<div id="nav-toggle">
			<div>
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
		<nav id="top-nav">
			<ul id="nav-list"><!--ログインされていない場合のナビ-->
				<?php if(empty($_SESSION['user_id'])){ ?>
					<li><a href="sample.php?sample_id=1"><i class="fas fa-tasks fa-lg"></i>サンプル</a></li>
					<li><a href="login.php"><i class="fas fa-sign-in-alt fa-lg"></i>ログイン</a></li>
					<li><a href="signup.php"><i class="fas fa-user-plus fa-lg"></i>会員登録</a></li>
				<!--ログインされている場合のナビ-->
				<?php }else{ ?>	
					<li><a href="index.php"><i class="fas fa-user-check fa-lg"></i>マイチェックリスト</a></li>				
					<!-- <li><a href="addTemplate.php"><i class="fas fa-tasks fa-lg"></i>テンプレート</a></li> -->
					<li><a href="profEdit.php"><i class="fas fa-edit fa-lg"></i>登録内容変更</a></li>
					<li><a href="withdraw.php"><i class="fas fa-user-slash fa-lg"></i></i>退会</a></li>
					<li><a href="logout.php"><i class="fas fa-sign-out-alt fa-lg"></i>ログアウト</a></li>
				<?php } ?>
			</ul>
		</nav>
	</div>
</header>