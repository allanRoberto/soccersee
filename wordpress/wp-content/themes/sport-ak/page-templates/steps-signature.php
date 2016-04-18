<?php
/*
  Template Name: Steps Signature
 */
?>
<?php get_header(); ?>

<div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">
    <nav class="site-navigation signature-steps-navigation">
    <?php
    if (has_nav_menu('signature-steps')) {
        wp_nav_menu(array(
            'theme_location' => 'signature-steps',
            'menu_class' => 'nav-menu',
            'menu_id' => 'signature-steps-menu',
            'walker' => new Azexo_Walker_Nav_Menu(),
        ));
    }
    ?>
    </nav>
        <?php while (have_posts()) : the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
                <div class="entry-content content-signature">
                    <?php the_content(); ?>
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
