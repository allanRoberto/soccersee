<?php
/*
  Template Name: Blog background image post
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
    <!--<![endif]-->
    <head>
        <?php $options = get_option(AZEXO_THEME_NAME); ?>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>">        
        <?php
        if (!function_exists('has_site_icon') || !has_site_icon()) {
            if (isset($options['favicon']['url']) && !empty($options['favicon']['url'])) {
                print '<link rel="shortcut icon" href="' . esc_url($options['favicon']['url']) . '" />';
            }
        } else {
            if (function_exists('wp_site_icon')) {
                wp_site_icon();
            }
        }
        ?>
        <?php wp_head(); ?>
    </head>
    <body>
     <?php the_content(); ?>
    <?php wp_footer(); ?>
</body>
</html>
<div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">
        <?php while (have_posts()) : the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
                <div class="entry-content">
                    <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'sport-ak') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
                </div><!-- .entry-content -->
            </div><!-- #post -->
            <?php
            $options = get_option(AZEXO_THEME_NAME);
            if (isset($options['comments']) && $options['comments']) {
                if (comments_open()) {
                    comments_template();
                }
            }
            ?>
        <?php endwhile; ?>
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>