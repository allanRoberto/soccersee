<?php
$options = get_option(AZEXO_THEME_NAME);
if (!isset($show_sidebar)) {
    $show_sidebar = isset($options['show_sidebar']) ? $options['show_sidebar'] : 'right';
}
get_header();
?>

<div class="container <?php print (is_active_sidebar('sidebar') && $show_sidebar ? 'active-sidebar ' . esc_attr($show_sidebar) : ''); ?>">
    <?php
    if ($show_sidebar == 'left') {
        get_sidebar();
    }
    ?>
    <div id="primary" class="content-area">
        <?php
        if ($options['show_page_title']) {
            get_template_part('template-parts/general', 'title');
        }
        ?>
        <div id="content" class="site-content" role="main">
            <?php while (have_posts()) : the_post(); ?>
               
                <?php get_template_part('content', get_post_format()); ?>                

                
                
               
                
            <?php endwhile; ?>
            <p class="message-post">Nós da SoccerSee não se responsabilizamos pelas avaliações publicadas nesse site, essa seção é reservada somente para a divulgação de avaliações pelo mundo e não possui nenhum tipo de ligação com a SoccerSee</p> 
        </div><!-- #content -->
    </div><!-- #primary -->

    <?php
    if ($show_sidebar == 'right') {
        get_sidebar();
    }
    ?>
</div>
<?php get_footer(); ?>