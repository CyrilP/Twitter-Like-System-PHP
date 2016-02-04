<?php
	if(isset($user_id)){
		include "connect.php";
		$query = mysqli_query($conn, "SELECT username, followers, following, tweets
                              FROM users 
                              WHERE id='$user_id'
                             ");
		mysqli_close($conn);
		$row = mysqli_fetch_assoc($query);
		$username = $row['username'];
		$tweets = $row['tweets'];
		$followers = $row['followers'];
		$following = $row['following'];
		echo "
		<div class='dashboard'>";
			include "profilecard.php";
		
		echo "   
		</div>

		<div class='timeline'>
			<div class='tweet'>
				<form action='tweet.php' method='POST'>
					<textarea class='form-control' placeholder='Type your tweet here' name='tweet'></textarea>
					<button type='submit' class='btn btn-info btn-xs tweetButton'>Tweet</button>
					<span class='tweetCharCount' id='characters'>140</span>
				</form>
			</div>
		<script>
			$('textarea').keyup(function() {
				var cs = $(this).val().length;
				$('#characters').text(140-cs);
			});
		</script>
		";
		include "connect.php";
		$tweets = mysqli_query($conn, "SELECT name, tweets.username, tweet, timestamp
							   FROM tweets, users
							   WHERE tweets.user_id = users.id 
							   AND (tweets.user_id = $user_id OR (tweets.user_id IN (SELECT user2_id FROM following WHERE user1_id='$user_id')))
							   ORDER BY timestamp DESC
							   LIMIT 0, 10
							  ");
		include "functions.php";
		while($tweet = mysqli_fetch_array($tweets)){
			display_tweet($tweet);
		}
		mysqli_close($conn);
	}
	?>
	</div>
	<?php include "footer.php"; ?>
