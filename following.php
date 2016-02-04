<?php 
session_start();
if(isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
}
?>
<?php
if(isset($_POST['login-btn']) && $_POST['login-btn']=="login-submit"){
  if($_POST['username']!="" && $_POST['password']!=""){
    $username = strtolower($_POST['username']);
    include "connect.php";
    $query = mysqli_query($conn, "SELECT id, password
                          FROM users 
                          WHERE username='$username'
                          ");
    mysqli_close($conn);
    if(mysqli_num_rows($query)>=1){
      $password = md5($_POST['password']);
      $row = mysqli_fetch_assoc($query);
      if($password==$row['password']){
        $_SESSION['user_id']=$row['id'];
        header('Location: .');
        exit;
      }
      else{
        $error_msg = "Incorrect username or password";
      }
    }
    else{
      $error_msg = "Incorrect username or password";
    }
  }
  else{
    $error_msg = "All fields must be filled out";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=425px, user-scalable=no">
  
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/twitter.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
   <meta charset="ISO-8859-1"> 
  <title>Twitter-like-system-PHP</title>
</head>
<body>
  <?php include "header.php"; ?>
  <?php
	if(isset($user_id)){
	  
		include "connect.php";
		$users = mysqli_query($conn, "SELECT *
							   FROM users
							   WHERE id IN (SELECT user2_id FROM following WHERE user1_id='$user_id')
							  ");
		if (!$users) {
			printf("Error: %s\n", mysqli_error($conn));
		    exit();
        }
		mysqli_close($conn);
		$title="Following";
		$follow=false;
		include "follow-template.php";
		
	}
  ?>
  <br>
  <?php include "footer.php"; ?>
</body>
</html>
