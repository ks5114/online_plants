
<?php echo theme_view('header'); 
$sgm = $this->uri->segment(2);
?>
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <?php echo theme_view('header_login'); ?>
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                <?php  echo theme_view('sidebar');?>
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <div class="m-subheader ">
						<div class="top-sub-nav">
							<div class="float-left">
                            <?php if (isset($toolbar_title)) : ?>
                                    <h3 class="page-title"><?php echo $toolbar_title; ?></h3>
                                <?php endif; ?>
							</div>
                            <div class="float-right right-sb-menu">
								<!-- <span class="m-subheader__daterange" id="m_dashboard_daterangepicker"> -->
									<span class="m-subheader__daterange-label">
										<span class="m-subheader__daterange-title"> <?php Template::block('sub_nav', ''); ?></span>
									</span>
								<!-- </span> -->
							</div>
						</div>
                        <div class="clearfix"></div>
			        </div>
                
                    <div class="m-content">
                    <?php if($sgm == 'dashboard'){ ?>
                        <div class="row">    
                    <?php } else { ?>   
                        <div class="m-portlet m-portlet--mobile">    
                    <?php }
                                echo Template::message();
                                echo isset($content) ? $content : Template::content();
                            ?>
                         </div>
                    </div>
                </div>
            </div>

<?php echo theme_view('footer'); ?>
</div>
