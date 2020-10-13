	<!-- <div class="page-footer">
		<div class="page-footer-inner"> <?php //echo date('Y');?> &copy; Powered by
			<a target="_blank" href="https://www.webcluesinfotech.com/">Webclues</a>
		</div>
		<div class="scroll-to-top">
			<i class="icon-arrow-up"></i>
		</div>
	</div>
	</div>
	<script>
		$(document).ready(function()
		{
			$('#clickmewow').click(function()
			{
				$('#radio1003').attr('checked', 'checked');
			});
		})
	</script> -->

<!-- begin::Footer -->
<footer class="m-grid__item	m-footer ">
<div class="m-container m-container--fluid m-container--full-height m-page__container">
	<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
		<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
			<span class="m-footer__copyright">
				<?php echo date('Y');?> &copy; Powered by <a target="_blank" href="https://www.webcluesinfotech.com" class="m-link">Webclues</a>
			</span>
		</div>
	</div>
</div>
</footer>

			<?php echo Assets::js(
			array(
				'assets/vendors/base/vendors.bundle.js',
				'assets/demo/default/base/scripts.bundle.js',
				//'assets/vendors/custom/fullcalendar/fullcalendar.bundle.js',
				//'assets/app/js/dashboard.js'
			)); ?>
			<!-- end::Footer -->
</body>
</html>