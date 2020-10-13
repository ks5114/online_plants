<?php
Assets::add_css(array(    
    'assets/global/plugins/simple-line-icons/simple-line-icons.min.css'
));

if (isset($shortcut_data) && is_array($shortcut_data['shortcut_keys'])) {
    //Assets::add_js($this->load->view('ui/shortcut_keys', $shortcut_data, true), 'inline');
}
?>
<!DOCTYPE html>
<html lang="en">
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
        <script type="text/javascript">
            window.loaderImage = "<?php echo Template::theme_url("images/ajax_loader.gif"); ?>";
            window.base_url = "<?php echo base_url(); ?>";
            window.site_url = "<?php echo site_url(); ?>";
        </script>
        <title><?php
            echo isset($toolbar_title) ? "{$toolbar_title} : " : '';
            e($this->settings_lib->item('site.title'));
        ?></title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <meta name="robots" content="noindex" />
		<script src="<?php echo Template::theme_url('assets/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>

		<!--end::Web font -->

		<!--begin::Global Theme Styles -->
		<link href="<?php echo Template::theme_url(); ?>assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link href="<?php echo Template::theme_url(); ?>assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<!--end::Global Theme Styles -->

		<!--begin::Page Vendors Styles -->
		<link href="<?php echo Template::theme_url(); ?>assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<!--end::Page Vendors Styles -->
		<link rel="shortcut icon" href="<?php echo Template::theme_url(); ?>assets/demo/default/media/img/logo/favicon.ico" />
		<?php echo Assets::css(null, true); ?>
	</head>

	<!-- end::Head -->