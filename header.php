<div class="header">
<a href='index.php' class='btn btn-info header-home-button'>Home</a>
<?php 
if(isset($user_id)){
	echo "<a href='logout.php' class='btn btn-info logout-button'>Logout</a>";
}
?>
</div>