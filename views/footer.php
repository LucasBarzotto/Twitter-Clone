<footer class="footer mt-auto py-3 bg-light">
  <div class="container">
    <span class="text-muted">&copy; My Website 2020.</span>
  </div>
</footer>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Login</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="alert alert-danger" id="loginAlert" >asdasd</div>
		  <div class="modal-body">
			<form method="POST" id="myform" action="">
			<input type="hidden" name="loginActive" id="loginActive" value="1">
			  <div class="form-group">
				<label for="email">Email address</label>
				<input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
				<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			  </div>
			  <div class="form-group">
				<label for="password">Password</label>
				<input name="password" type="password" class="form-control" id="password">
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" id="toggleLogin" class="btn btn-info">Sign Up</button>
			<button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-primary" id="loginSignupButton">Login</button>
			</form>
		  </div>
		</div>
	  </div>
	</div>
  </body>
</html>

<script>

	$("#toggleLogin").click(function()
	{
		if ($("#loginActive").val() == "1") {
			
			$("#loginActive").val("0");
			$("#toggleLogin").html("Login");
			$("#exampleModalLabel").html("Sign Up");
			$("#loginSignupButton").html("Sign Up");
		}
		else {

			$("#loginActive").val("1");
			$("#toggleLogin").html("Sign Up");
			$("#exampleModalLabel").html("Login");
			$("#loginSignupButton").html("Login");
			
		}
	});

	$("#loginSignupButton").click(function()
	{	
	
		var loginActive = $("#loginActive").val();
	
		$.ajax({
			url: "actions.php?action=loginSignup",
			type: "POST",
			data: "email="+$("#email").val()+"&password="+$("#password").val()+"&loginActive="+loginActive,
			dataType: "html"

		}).done(function(resposta) {
			if (resposta == '1')
			{
				window.location.assign("http://pythonexercise123-com.stackstaging.com");
			}
			else
			{
				$("#loginAlert").html(resposta).show();
			}

		}).fail(function(jqXHR, textStatus ) {
			console.log("Request failed: " + textStatus);

		});
	});
	
	$(".toggleFollow").click(function()
	{	
	
		var id = $(this).attr("data-userId");
	
		$.ajax({
			url: "actions.php?action=toggleFollow",
			type: "POST",
			data: "userId="+id,
			dataType: "html"

		}).done(function(resposta) {

			if (resposta == '1')
			{
				$("a[data-userId='" + id + "']").html("Follow");
			}
			else if (resposta == '2')
			{
				$("a[data-userId='" + id + "']").html("Unfollow");	
			}

		}).fail(function(jqXHR, textStatus ) {
			console.log("Request failed: " + textStatus);

		});
	});
	
	$("#postTweetButton").click(function()
	{	
		$.ajax({
			url: "actions.php?action=postTweet",
			type: "POST",
			data: "tweetContent="+$("#tweetContent").val(),
			dataType: "html"

		}).done(function(resposta) {

			if(resposta == '1')
			{
				$("#tweetFail").hide();
				$("#tweetSuccess").show();
			}
			else if (resposta != '')
			{
				$("#tweetSuccess").hide();
				$("#tweetFail").html(resposta).show();
			}
			
		}).fail(function(jqXHR, textStatus ) {
			console.log("Request failed: " + textStatus);

		});
	});

</script>