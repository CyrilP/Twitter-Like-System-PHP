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
} else if(isset($_POST['btn']) && $_POST['btn']=="submit-register-form"){
  if($_POST['username']!="" && $_POST['password']!="" && $_POST['confirm-password']!="" && $_POST['name']!=""){
    if($_POST['password']==$_POST['confirm-password']){
      include 'connect.php';
      $username = strtolower($_POST['username']);
      $query = mysqli_query($conn, "SELECT username 
                            FROM users 
                            WHERE username='$username'
                            ");
      mysqli_close($conn);
      if(!(mysqli_num_rows($query)>=1)){
          $password = md5($_POST['password']);
          include 'connect.php';
          mysqli_query($conn, "INSERT INTO users(username, password, name) 
                       VALUES ('$username', '$password', '".mysqli_real_escape_string($conn, $_POST['name'])."')
                      ");
          mysqli_close($conn);
		  $register_ok = "OK";
      } else {
        $register_error_msg="Username already exists please try again";
      }
    }
    else{
      $register_error_msg="Passwords did not match";
    }
  }
  else{
      $register_error_msg="All fields must be filled out";
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
    include "dashboard.php";
    exit;
  }
  ?>
  <div class="description">
		<h1>Welcome on Twitter-like-system-PHP</h1>
		<p>
		Connect with your friends - and other fascinating people. Get in-the-moment updates on the things that interest you. And watch events unfold, in real time, from every angle.
		</p>
  </div>
  <div class="form">
	  <form role="form" action="index.php" method="POST" class="login-form">
		<div class="input-group login-input-panel">
		  <span class="input-group-addon">@</span>
		  <input type="text" class="form-control" placeholder="Username" name="username">
		</div>
		<input type="password" class="form-control login-input-panel" placeholder="Password" name="password">
		<?php
		if(isset($error_msg)){
			echo "<div class='alert alert-danger'>".$error_msg."</div>";
		}
		?>
		<div class="btn-group">
		  <button type="submit" class="btn btn-info login-input-panel-button" name="login-btn" value="login-submit">Log In</button>
		</div>
	  </form>
	  
		<form action="index.php" method="POST" role="form" class="login-form">
		<h4>Register For An Account</h4>

		<div class="input-group login-input-panel">
		  <span class="input-group-addon">@</span>
		  <input type="text" class="form-control" placeholder="Username" name="username" value="<?php if (isset($_POST['username'])) { echo $_POST['username']; } ?>">
		</div>
		<input type="text" class="form-control login-input-panel" placeholder="Full name" name="name">
		<input type="password" class="form-control login-input-panel" placeholder="Password" name="password">
		<input type="password" class="form-control login-input-panel" placeholder="Confirm Password" name="confirm-password">
		<?php
		if(isset($register_error_msg)){
			echo "<div class='alert alert-danger'>".$register_error_msg."</div>";
			?>
			<button type="submit" class="btn btn-success register-input-panel-button" name="btn" value="submit-register-form">Register</button>
			<?php
		} else if (isset($register_ok)) {
			  echo "<div class='alert alert-success'>Your account has been created!</div>";
			  echo "<a href='.' style='width:300px;' class='btn btn-info'>Go Home</a>";
		} else {
		?>
			<button type="submit" class="btn btn-success register-input-panel-button" name="btn" value="submit-register-form">Register</button>
		<?php
		}
		?>
	  </form>
	</div>
  <br>
  <?php include "footer.php"; ?>
</body>
</html>
