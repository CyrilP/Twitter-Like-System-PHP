<div class="jumbotron footer">
	<div class="container">
		<h5>Made by <a href="http://simarsingh.ca">Simar</a></h5>  
		<h5>This is Open Source - Fork it on <i class="fa fa-github"></i> <a href="https://github.com/iSimar/Twitter-Like-System-PHP">GitHub</a></h5>
	</div>
</div>
<script>
	var elts = document.getElementsByClassName('tweetText');
	for(var i = 0; i < elts.length; i++) {
		var elt = elts[i];
		//alert(twemoji.parse(elt.textContent))
		elt.innerHTML = twemoji.parse(elt.textContent);
	}
</script>