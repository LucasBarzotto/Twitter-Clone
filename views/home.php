<main role="main" class="flex-shrink-0">
	<div class="container">
		<h1 class="mt-5" id="mainTitle">Twitter</h1>
	</div>
	<div class="container">
	  <div class="row" id="subTitles">
		<div class="col-8">
			<h3>Recent tweets</h3>
			<?php displayTweets('public', $link); ?>
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