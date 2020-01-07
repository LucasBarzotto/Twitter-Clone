<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="http://pythonexercise123-com.stackstaging.com/styles.css">
    <title>Twitter</title>
	<link rel="shortcut icon" href="http://pythonexercise123-com.stackstaging.com/views/favicon.png" type="image/vnd.microsoft.icon">
	<link href="https://fonts.googleapis.com/css?family=Indie+Flower&display=swap" rel="stylesheet">
  </head>
  
  <body class="d-flex flex-column h-100">
    <header>

	<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light">
	  <a class="navbar-brand" href="http://pythonexercise123-com.stackstaging.com/" style="	color: #059936; /*font-family: 'Indie Flower', cursive;*/">Twitter</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
		  <li class="nav-item">
			<a class="nav-link" href="?page=timeline">Your timeline</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="?page=yourtweets">Your tweets</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="?page=publicprofiles">Public Profiles</a>
		  </li>
		</ul>
		<div class="form-inline my-2 my-lg-0">
		
		<?php
		
			if ($_SESSION['id'])
			{?>
				<a class="btn btn-outline-success my-2 my-sm-0" href="?function=logout">Logout</a>				
			<?php;}
			else
			{?>
				<button class="btn btn-outline-success my-2 my-sm-0" data-toggle="modal" data-target="#exampleModal">Login/Sign up</button>				
			<?php;}			
		?>
		</div>
	  </div>
	</nav>

	</header>