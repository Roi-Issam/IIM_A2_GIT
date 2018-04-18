	<!-- Javascript Libs -->
	<script src="view/js/libs/jquery-2.1.0.min.js"></script>
	<script src="view/js/libs/bootstrap.min.js"></script>
	<script src="view/js/libs/midway.min.js"></script>

	<script src="view/js/main.js"></script>

	<?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php'){ ?>
	<audio preload></audio>

	<script src="view/js/libs/audiojs/audio.min.js"></script>
	<script>
		$(function() {
			// Setup the player to autoplay the next track
			var a = audiojs.createAll({
				trackEnded: function() {
					var next = $('.playing').next();
					if (!next.length) next = $('#musicfeed .music').first();
					next.addClass('playing').siblings().removeClass('playing');
					audio.load(next.attr('data-src'));
					audio.play();
				}
			});

			// Load in the first track
			var audio = a[0];

			// Load in a track on click
			$('#musicfeed .music').click(function(e) {
				$(this).addClass('playing').siblings().removeClass('playing');
				audio.load($(this).attr('data-src'));
				audio.play();
			})
		});
	</script>
	<?php } ?>

</body>
</html>