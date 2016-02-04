<?php 
session_start();
if (isset($_SESSION['user_id'])) {
$user_id = $_SESSION['user_id'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=425px, user-scalable=no">

	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
	<link rel="stylesheet" href="css/twitter.css">
	<meta charset="ISO-8859-1"> 
	<title>Twitter-like-system-PHP</title>
</head>
<body>
	<?php include "header.php"; ?>
	<a href='.' class='btn btn-info home-button'>Go Home</a>
	<?php
	function getTime($t_time){
		$pt = time() - $t_time;
		if ($pt>=86400)
			$p = date("F j, Y",$t_time);
		elseif ($pt>=3600)
			$p = (floor($pt/3600))."h";
		elseif ($pt>=60)
			$p = (floor($pt/60))."m";
		else 
			$p = $pt."s";
		return $p;
	}
	if($_GET['username']){
		include 'connect.php';
		$username = strtolower($_GET['username']);
		$query = mysqli_query($conn, "SELECT id, username, followers, following, tweets 
			FROM users 
			WHERE username='$username'
			");
		mysqli_close($conn);
		if(mysqli_num_rows($query)>=1){
			$row = mysqli_fetch_assoc($query);
			$id = $row['id'];
			$username = $row['username'];
			$tweets = $row['tweets'];
			$followers = $row['followers'];
			$following = $row['following'];
			if(isset($user_id)){
				if($user_id!=$id){
					include 'connect.php';
					$query2 = mysqli_query($conn, "SELECT id
										   FROM following 
										   WHERE user1_id='$user_id' AND user2_id='$id'
										  ");
					mysqli_close($conn);
					if(mysqli_num_rows($query2)>=1){
						echo "<a href='unfollow.php?userid=$id&username=$username' class='btn btn-default home-button'>Unfollow</a>";
					}
					else{
						echo "<a href='follow.php?userid=$id&username=$username' class='btn btn-info home-button'>Follow</a>";
					}
				}
			}
			else{
				echo "<a href='./register.php' class='btn btn-info home-button'>Signup</a>";
			}
			echo "
			<div class='dashboard'>";
		
			include 'connect.php';
			if (isset($user_id)) {
				$query3 = mysqli_query($conn, "SELECT id
								   FROM following 
								   WHERE user1_id='$id' AND user2_id='$user_id'
								  ");
				mysqli_close($conn);
			} else {
				$query3 = mysqli_query($conn, "SELECT id
								   FROM following 
								   WHERE user1_id='$id'
								  ");
				mysqli_close($conn);
			}
			if(mysqli_num_rows($query3)>=1){
				$follows_you=true;
			}
			include "profilecard.php";
			echo "</div>
			<div class='timeline'>
				<div class='tweetsHeader'>
				Tweets
				</div>
			";
			include "connect.php";
			$tweets = mysqli_query($conn, "SELECT username, tweet, timestamp
				FROM tweets
				WHERE user_id = $id
				ORDER BY timestamp DESC
				LIMIT 0, 10
				");
			include "functions.php";
			while($tweet = mysqli_fetch_array($tweets)){
				display_tweet($tweet);
			}
			mysqli_close($conn);
		}
		else{
			echo "<div class='alert alert-danger'>Sorry, this profile doesn't exist.</div>";
			echo "<a href='.' style='width:300px;' class='btn btn-info'>Go Home</a>";
		}
	}
	?>
	</div>
	<br>
<?php include "footer.php"; ?>
</body>
</html>
