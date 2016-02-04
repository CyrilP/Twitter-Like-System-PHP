<?php

function getTime($t_time){
	$pt = time() - $t_time;
	if ($pt>=86400)
		$p = date("M j, Y",$t_time);
	elseif ($pt>=3600)
		$p = (floor($pt/3600))."h";
	elseif ($pt>=60)
		$p = (floor($pt/60))."m";
	else 
		$p = $pt."s";
	return $p;
}

// from http://zenverse.net/php-function-to-auto-convert-url-into-hyperlink/
function _make_url_clickable_cb($matches) {
	$ret = '';
	$url = $matches[2];
 
	if ( empty($url) )
		return $matches[0];
	// removed trailing [.,;:] from URL
	if ( in_array(substr($url, -1), array('.', ',', ';', ':')) === true ) {
		$ret = substr($url, -1);
		$url = substr($url, 0, strlen($url)-1);
	}
	
	if(strpos($url,'pbs.twimg.com') !== false) {
		return $matches[1] . "<img src=\"$url\" alt=\"$url\" />" . $ret;
	}
	return $matches[1] . "<a href=\"$url\" rel=\"nofollow\">".truncateString($url)."</a>" . $ret;
}
 
function _make_web_ftp_clickable_cb($matches) {
	$ret = '';
	$dest = $matches[2];
	$dest = 'http://' . $dest;
 
	if ( empty($dest) )
		return $matches[0];
	// removed trailing [,;:] from URL
	if ( in_array(substr($dest, -1), array('.', ',', ';', ':')) === true ) {
		$ret = substr($dest, -1);
		$dest = substr($dest, 0, strlen($dest)-1);
	}
	return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\">$dest</a>" . $ret;
}
 
function _make_email_clickable_cb($matches) {
	$email = $matches[2] . '@' . $matches[3];
	return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
}

function truncateString($string) {
    if (strlen($string) > 40) {
        $string = substr($string, 0, 40) . "...";
    }
    return $string;
}
 
function make_clickable($ret) {
	$ret = ' ' . $ret;
	// in testing, using arrays here was found to be faster
	$ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_url_clickable_cb', $ret);
	$ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_web_ftp_clickable_cb', $ret);
	$ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', '_make_email_clickable_cb', $ret);
	
	// this one is not in an array because we need it to run last, for cleanup of accidental links within links
	$ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
	$ret = trim($ret);
	return $ret;
}

function display_tweet($tweet) {
			echo "<div class='tweetContainer'>";
			echo "<table>";
			echo "<tr>";
			echo "<td class='tweetImage'>";
			echo "<img src='./default.jpg' class='tweetPicture' alt='display picture'/>";
			echo "</td>";
			echo "<td class='tweetContent'>";
			echo "<a class='tweetUser' href='./".$tweet['username']."'><strong class='username'>".$tweet['name'] . "</strong> <span class='useralias'> @". $tweet['username']."</span></a><span class='tweetTime'> - ".getTime($tweet['timestamp'])."</span>";
			$new_tweet = preg_replace('/@(\\w+)/','<a href=./$1>$0</a>',$tweet['tweet']);
			$new_tweet = preg_replace('/#(\\w+)/','<a href=./hashtag/$1>$0</a>',$new_tweet);
			echo "<div class='tweetText'>".make_clickable($new_tweet)."</div>";
			echo "</td>";
			echo "</tr>";
			echo "</table>";
			echo "</div>";
}
?>

