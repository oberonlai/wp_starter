			<footer class="footer" role="contentinfo">
				<p class="copyright">
					Proudly powered by <a href="https://tw.wordpress.org" target="_blank">WordPress</a> | &copy; <?php echo date('Y'); ?> Copyright <?php bloginfo('name'); ?>
				</p>
			</footer>
		</div>
		<?php wp_footer(); ?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.7&appId=XXXXXXXX";
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>
		<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-XXXXXXXX-X', 'auto');
		ga('send', 'pageview');
		</script>
	</body>
</html>
