<?php
	if(isset($user_id)){

		echo "
		<div class='dashboard'>";
			include "profilecard.php";
		
		echo "   
		</div>
		<div class='timelineFollow'>
				<div class='followHeader'>"
					.$title.
				"</div>";

		while($user = mysqli_fetch_array($users)){
			echo "<div class='followContainer'>
					<div class='followProfileCardTop'>
			        </div>
					<div class='followProfileCardBottom'>";
					echo "<div><img src='./default.jpg' class='followImage' alt='display picture'/></div>";
					echo "<div class='followButton'>";
					
					if($follow) {
						echo "<a href='follow.php?userid=$user_id&username=".$user[1]."' class='btn btn-info home-button'>Follow</a>";
					} else{
						echo "<a href='unfollow.php?userid=$user_id&username=".$user[1]."' class='btn btn-default home-button'>Unfollow</a>";
					}
					echo "</div>";
					
					echo "<div class='followName'><a href='./" . $user[1] . "'>" . $user[2] . "</div>";
					echo "<div class='followNick'><a href='./" . $user[1] . "'>@" . $user[1] . "</div>";
					
					echo "</div>";
			echo "</div>";
		}
		
		echo"</div>";
	}
	
?>