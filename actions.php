<?php

	include("functions.php");

	if($_GET['action'] == 'loginSignup')
	{
		$error = "";
		$password = $_POST['password'];
		
		if (!$_POST['email'])
		{
			$error = "An email address is required.";
		}
		else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			$error = "Please enter a valid email address.";
		}
		else if (!$_POST['password'])
		{
			$error = "A password is required.";
		}
		else
		{
			if($_POST['loginActive'] == '0')
			{
				$query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
				$result = mysqli_query($link, $query);
				if (mysqli_num_rows($result) > 0)
				{
					$error =  "That email address is already taken. Please, try another one.";
				}
				else
				{
					$query = "INSERT INTO users (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";
					
					if (mysqli_query($link, $query))
					{
						
						$_SESSION['id'] = mysqli_insert_id($link);

						$hash = password_hash($password, PASSWORD_BCRYPT);
						$query = "UPDATE users SET password = '".$hash."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
						mysqli_query($link, $query);
						echo 1;

					}
					else
					{
						$error = "Couldn't create user - please try again later.";
					}
					
				}
			}
			else if ($_POST['loginActive'] == '1')
			{
				$query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_assoc($result);
				
				if (isset($row))
				{
					$hashedpassword = $row['password'];
						
					if (password_verify($password, $hashedpassword))
					{
						$_SESSION['id'] = $row['id'];
						echo 1;
						
					}
					else
					{
						$error = "Couldn't find that username/password combination. Please try again.";
					}	
				}
				else
				{
					$error = "Couldn't find that username/password combination. Please try again.";
				}
			}
		}
		
		if ($error != "")
		{
			echo $error;
			exit();
		}
	}
	
	if($_GET['action'] == 'toggleFollow')
	{
		$query = "SELECT * FROM isFollowing WHERE follower = ".mysqli_real_escape_string($link, $_SESSION['id'])." AND isFollowing = ".mysqli_real_escape_string($link, $_POST['userId'])." LIMIT 1";
		$result = mysqli_query($link, $query);
		if (mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_assoc($result);
			
			mysqli_query($link, "DELETE FROM isFollowing WHERE id = ".mysqli_real_escape_string($link, $row['id'])." LIMIT 1");
				
			echo '1';
			
		}
		else
		{
			$query = "INSERT INTO isFollowing (`follower`, `isFollowing`) VALUES ('".mysqli_real_escape_string($link, $_SESSION['id'])."', '".mysqli_real_escape_string($link, $_POST['userId'])."')";
			$result = mysqli_query($link, $query);
			echo "2";
			
		}
	}
	
	if($_GET['action'] == 'postTweet')
	{
		if(!$_POST['tweetContent'])
		{
			echo "Your tweet is empty!";
		}
		else if (strlen($_POST['tweetContent']) > 140)
		{
			echo "Your tweet is too long! Max 140 characters.";
		}
		else
		{
			$query = "INSERT INTO tweets (`tweet`, `userid`, `datetime`) VALUES ('".mysqli_real_escape_string($link, $_POST['tweetContent'])."', ".mysqli_real_escape_string($link, $_SESSION['id']).", NOW())";
			$result = mysqli_query($link, $query);

			echo "1";
		}
	}

?>