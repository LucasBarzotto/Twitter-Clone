<main role="main" class="flex-shrink-0">
	<div class="container">
		<h1 class="mt-5" id="mainTitle">Twitter</h1>
	</div>
	<div class="container">
	  <div class="row" id="subTitles">
		<div class="col-8">
			<h3>Public Profiles</h3>
			<hr>
			<?php
			if ($_GET['userid'])
			{?>
				<?php displayTweets($_GET['userid'], $link); ?>
			<?php }
			else
			{?>
				<h4>Active Users</h4>
				<?php displayUsers($link); ?>
			<?php }
			?>
		</div>
		<div class="col-4">
			<h3>Search tweets</h3>
			<?php displaySearch(); ?>
			<hr>
			<h3>Post tweets</h3>
			<?php displayTweetBox(); ?>
		</div>
	  </div>
	</div>
</main>