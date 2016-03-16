<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">

		<?php wp_head(); ?>
		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
        </script>

	</head>
	<body <?php body_class(); ?>>

	<header id="masthead" class="site-header clearfix">
        <div id="secondary" class="sidebar-container container" role="complementary">
        	<div class="sidebar-inner">
		        <div class="widget-area clearfix">
		            <div id="vc_widget-2" class="widget-1 widget-first widget-last widget-odd widget widget_vc_widget">
		            	<div class="scoped-style">
		            		<style type="text/css" data-type="vc_shortcodes-custom-css" scoped="">
		            			.vc_custom_1444144697786{margin-bottom: 0px !important;}
		            		</style>
		            		<div class="vc_row wpb_row vc_row-fluid vc_custom_1444144697786">
		            			<div class="row">
		            				<div class="h-padding-0 wpb_column vc_column_container vc_col-sm-12">
		            					<div class="wpb_wrapper">
		            						<div class="panel  social">
		            							<div class="panel-content">
		            								<div class="entry ">
		            									<div class="entry-icon">
		            										<a class="" href="#">
		            											<span class="fa fa-facebook"></span>
		            										</a>
		            									</div>
														<div class="entry-data">
															<div class="entry-header"></div><!-- header -->
														</div><!-- data -->
													</div><!-- entry -->
													<div class="entry ">
		            									<div class="entry-icon">
		            										<a class="" href="#">
		            											<span class="fa fa-twitter"></span>
		            										</a>
		            									</div>
														<div class="entry-data">
															<div class="entry-header"></div><!-- header -->
														</div><!-- data -->
													</div><!-- entry -->
													<div class="entry ">
		            									<div class="entry-icon">
		            										<a class="" href="#">
		            											<span class="fa fa-youtube"></span>
		            										</a>
		            									</div>
														<div class="entry-data">
															<div class="entry-header"></div><!-- header -->
														</div><!-- data -->
													</div><!-- entry -->
													<div class="entry ">
		            									<div class="entry-icon">
		            										<a class="" href="#">
		            											<span class="fa fa-google"></span>
		            										</a>
		            									</div>
														<div class="entry-data">
															<div class="entry-header"></div><!-- header -->
														</div><!-- data -->
													</div><!-- entry -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- .widget-area -->
		    </div>
    	</div><!-- #secondary -->
         <div class="header-main clearfix">
            <div class="container">
                <a class="site-title" href="<?php echo home_url(); ?>" rel="home">
					<img src="<?php echo get_template_directory_uri(); ?>/img/logotipo.jpg" alt="Logo" class="logo-img">
                </a>
                <div class="mobile-menu-button"><span><i class="fa fa-bars"></i></span></div>    

                <nav class="site-navigation mobile-menu">
                	<div class="menu-primary-container">
					 	<?php wp_nav_menu(
							array(
								'theme_location'  => 'header-menu',
								'menu'            => '',
								'container'       => 'ul',
								'container_class' => 'menu-{menu slug}-container',
								'container_id'    => '',
								'menu_class'      => 'nav-menu',
								'menu_id'         => 'primary-menu-mobile',
								'echo'            => true,
								'fallback_cb'     => 'wp_page_menu',
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
								'depth'           => 0,
								'walker'          => '',
						        'items_wrap'       => '<ul>%3$s</ul>'
								)
							);
					  	?>
					 </div>
                </nav>
                <nav class="site-navigation primary-navigation">
					<div class="menu-primary-container">
					 	<?php wp_nav_menu(
							array(
								'theme_location'  => 'header-menu',
								'menu'            => '',
								'container'       => 'ul',
								'container_class' => 'menu-{menu slug}-container',
								'container_id'    => '',
								'menu_class'      => 'nav-menu',
								'menu_id'         => 'primary-menu',
								'echo'            => true,
								'fallback_cb'     => 'wp_page_menu',
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
								'depth'           => 0,
								'walker'          => '',
						        'items_wrap'       => '<ul id="primary-menu" class="nav-menu">%3$s</ul>',
						        'walker' => new description_walker()
								)
							);
					  	?>
					 </div>
                </nav>
            </div>               
         </div>
         <div id="middle" class="sidebar-container" role="complementary" style="top: -101px; position: relative;">
			<?php echo do_shortcode('[rev_slider alias="homepage"]'); ?>         
         </div>
     </header>

		<!-- wrapper -->
		<div class="wrapper">

			
