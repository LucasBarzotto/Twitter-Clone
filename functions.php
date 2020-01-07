<?php

	session_start();

	$link = mysqli_connect("");
	
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		exit();
	}
	
	if($_GET['function'] == 'logout')
	{
		session_unset();
	}
	
	function humanTiming ($time)
	{
		$time = time() - $time; // to get the time since that moment
		$time = ($time<1)? 1 : $time;
		$tokens = array 
		(
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);

		foreach ($tokens as $unit => $text)
		{
		if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}
	}

	function displayTweets($type, $link)
	{
		if($type == 'public')
		{
			
			$whereClause = "";
			
		}
		else if ($type == 'isFollowing')
		{
			
			$whereClause = "";
			
			$query = "SELECT * FROM isFollowing WHERE follower = ".mysqli_real_escape_string($link, $_SESSION['id']);
			$result = mysqli_query($link, $query);
			
			if (mysqli_num_rows($result) > 0)
			{
				while ($row = mysqli_fetch_assoc($result))
				{
					
					if ($whereClause == "")
					{
						$whereClause = "WHERE";
					}
					else
					{
						$whereClause.= " OR";
					}
					
					$whereClause.= " userid = ".$row['isFollowing'];					
				}				
			}
			else
			{
				$whereClause.= "WHERE userid = '-1'";
			}	
		}
		
		else if ($type == 'yourtweets')
		{
			
			$whereClause = "";
			
			$query = "SELECT * FROM tweets WHERE userid = ".mysqli_real_escape_string($link, $_SESSION['id']);
			$result = mysqli_query($link, $query);
			
			if (mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_assoc($result);
				$whereClause.= "WHERE userid = ".$row['userid'];		
			}
			else
			{
				$whereClause.= "WHERE userid = '-1'";
			}	
		}
		
		else if ($type == 'search')
		{
			
			$whereClause = "";
			
			$query = "SELECT * FROM tweets WHERE `tweet` LIKE '%".mysqli_real_escape_string($link, $_GET['q'])."%'";
			$result = mysqli_query($link, $query);
			
			echo '<p>Showing results for "'.mysqli_real_escape_string($link, $_GET['q']).'":</p>';
			
			if (mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_assoc($result);
				$whereClause.= "WHERE `tweet` LIKE '%".mysqli_real_escape_string($link, $_GET['q'])."%'";	
			}
			else
			{
				$whereClause.= "WHERE userid = '-1'";
			}	
		}
		
		else if (is_numeric($type))
		{
			$whereClause = "";
			
			$query = "SELECT * FROM users WHERE `id` = ".mysqli_real_escape_string($link, $type);
			$result = mysqli_query($link, $query);
			$user = mysqli_fetch_assoc($result);
			echo "<h4>".mysqli_real_escape_string($link, $user['email'])."'s Tweets:</h4>";
			
			$query = "SELECT * FROM tweets WHERE `userid` = ".mysqli_real_escape_string($link, $type);
			$result = mysqli_query($link, $query);
			
			if (mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_assoc($result);
				$whereClause.= "WHERE `userid` = ".mysqli_real_escape_string($link, $type);	
			}
			else
			{
				$whereClause.= "WHERE userid = '-1'";
			}	
		}
		
		$query = "SELECT * FROM tweets ".$whereClause." ORDER BY `datetime` DESC LIMIT 10";
		
		$result = mysqli_query($link, $query);
		
		if (mysqli_num_rows($result) == 0)
		{
			echo "<p>There are no tweets to display</p>";
		}
		else
		{
			while ($row = mysqli_fetch_assoc($result))
			{
				$userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
				$userQueryResult = mysqli_query($link, $userQuery);
				$user = mysqli_fetch_assoc($userQueryResult);
				
				echo "<div class='tweet'><p><a href=?page=publicprofiles&userid=".$user['id'].">".$user['email']."</a>";
				
				$time = strtotime($row['datetime']);

				echo '<span class="time"> '.humanTiming($time).' ago:</span></p>';
				
				echo "<p>".htmlspecialchars($row['tweet'])."</p>";
				
				if($_SESSION['id'] > 0)
				{
					echo "<p><a class='toggleFollow' href='#' onClick='return false;' data-userId='".$row['userid']."'>";
					
					$isFollowingQuery = "SELECT * FROM isFollowing WHERE follower = ".mysqli_real_escape_string($link, $_SESSION['id'])." AND isFollowing = ".mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
					$isFollowingQueryResult = mysqli_query($link, $isFollowingQuery);
					if (mysqli_num_rows($isFollowingQueryResult) > 0)
					{
						$row = mysqli_fetch_assoc($isFollowingQueryResult);
						echo "Unfollow";
					}
					else
					{
						echo "Follow";
					}
					
					echo "</a></p></div>";
				}
				else
				{
					echo "<p><a href='#' onClick='return false;' data-toggle='modal' data-target='#exampleModal'>";
					echo "Follow";
					echo "</a></p></div>";
				}
			}
		}
	}
	
	function displaySearch()
	{
		echo 
		'
		<form id="searchBox">
		  <div class="row">
		    <input type="hidden" name="page" value="search">
			<div class="col">
			  <input type="text" name = "q" class="form-control" id="search" placeholder="Search">
			</div>
			<button class="btn btn-success">Search Tweet</button>
		  </div>
		</form>
		';
	}
	
	function displayTweetBox()
	{
		if($_SESSION['id'] > 0)
		{
			echo 
			'
			<div id="searchBox">
			  <div id="tweetSuccess" class="alert alert-success">Your tweet was posted successfully!</div>
			  <div id="tweetFail" class="alert alert-danger"></div>
			  <div class="row">
				<div class="col">
					<textarea class="form-control" id="tweetContent" rows="3"></textarea>
				</div>
				<div>
					<button type="button" class="btn btn-success" id="postTweetButton">Post Tweet</button>
				</div>
			  </div>
			</div>
			';
		}
	}
	
	function displayUsers($link)
	{
		$query = "SELECT * FROM users";
		$result = mysqli_query($link, $query);
		while ($row = mysqli_fetch_assoc($result))
		{
			echo "<p><a href='?page=publicprofiles&userid=".$row['id']."'>".$row['email']."</a></p>";
		}
	}
?>