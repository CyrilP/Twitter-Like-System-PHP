<?php 
session_start();
if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
}
?>
<?php
if($_GET['userid']  && $_GET['username']){
	if($_GET['userid']!=$user_id){
		$follow_userid = $_GET['userid'];
		$follow_username = $_GET['username'];
		include 'connect.php';
		$query = mysqli_query($conn, "SELECT id
							   FROM following 
							   WHERE user1_id='$user_id' AND user2_id='$follow_userid'
							  ");
		mysqli_close($conn);
		if(!(mysqli_num_rows($query)>=1)){
			include 'connect.php';
			mysqli_query($conn, "INSERT INTO following(user1_id, user2_id) 
						 VALUES ('$user_id', '$follow_userid')
						");
			mysqli_query($conn, "UPDATE users
						 SET following = following + 1
						 WHERE id='$user_id'
						");
			mysqli_query($conn, "UPDATE users
						 SET followers = followers + 1
						 WHERE id='$follow_userid'
						");
			mysqli_close($conn);
		}
		header("Location: ./".$follow_username);
	}
}
?>