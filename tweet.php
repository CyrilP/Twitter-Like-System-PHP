<?php 
session_start();
if(isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
}
?>
<?php
if($user_id){
	if($_POST['tweet']!=""){
		$tweet = htmlentities($_POST['tweet']);
		$timestamp = time();
		include 'connect.php';
		$query = mysqli_query($conn, "SELECT username
					 		  FROM users 
				     		  WHERE id ='$user_id'
				    		");
		$row = mysqli_fetch_assoc($query);
		$username = $row['username'];
		mysqli_query($conn, "INSERT INTO tweets(username, user_id, tweet, timestamp) 
				     VALUES ('$username', '$user_id', '$tweet', $timestamp)
				    ");
		mysqli_query($conn, "UPDATE users
					 SET tweets = tweets + 1
					 WHERE id='$user_id'
					");
		mysqli_close($conn);
		header("Location: .");
	}
}
?>
