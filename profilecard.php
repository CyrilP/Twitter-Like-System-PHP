<?php
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
?>

		<div class='dashboardProfileCard'>
			<div class='dashboardProfileCardTop'>
			</div>
			<div class='dashboardProfileCardBottom'>
				<table>
					<tr>
						<td>
							<img src='./default.jpg' class='profileImage' alt='display picture'/>
						</td>
						<td valign='top' style='padding-left:8px;'>
							<h6><a href='./<?php echo "$username";?>'>@<?php echo "$username";?></a>
	<?php
	if(isset($follows_you)){
		echo " - <i>Follows You</i>";
	}
	?>
							</h6>
							<div class="profileStats">
								<ul class="profileStats-list">
									<li class="profileStats-li">
										<a href='/<?php echo "$username"; ?>'>
											<span class="profileStats-label">Tweets</span>
											<span class="profileStats-value"><?php echo "$tweets";?></span>
										</a>
									</li>
									<li class="profileStats-li">
										<a href='/followers.php'>
										<span class="profileStats-label">Followers</span>
										<span class="profileStats-value"><?php echo "$followers";?></span>
										</a>
									</li>
									<li class="profileStats-li">
										<a href='/following.php'>
											<span class="profileStats-label">Following</span>
											<span class="profileStats-value"><?php echo "$following";?></span>
										</a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
