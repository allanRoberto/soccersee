<?php
/*
  Template Name: Steps Signature Category
 */
?>
<?php get_header(); 

    $args = array( 
        'post_type' => 'product', 
        'posts_per_page' => 10, 
        'product_cat' => 'assinaturas',
        'orderby'   => 'meta_value_num',
        'meta_key'  => '_price',
        'order' => 'asc'
     );

    $loop = new WP_Query( $args );
?>

<div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">
    <nav class="site-navigation signature-steps-navigation">
    <?php
    if (has_nav_menu('signature-steps')) {
        wp_nav_menu(array(
            'theme_location' => 'signature-steps',
            'menu_class' => 'nav-menu container',
            'menu_id' => 'signature-steps-menu',
            'walker' => new Azexo_Walker_Nav_Menu(),
        ));
    }
    ?>
    </nav>

            <div id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
                <div class="entry-content content-signature container">
                    <div class="pricing-table-container container">
                        <div class="row">
                            <article class="pricing-table">
                                <?php     
                                while ( $loop->have_posts() ) : 
                                    $loop->the_post(); 
                                    global $product;  

                                    $price = get_post_meta( get_the_ID(), '_regular_price', true);     

                                 ?>
                                    <div id="layers-widget-pricing-table-4-1" class="pricing-plan pricing-plan-horizontal">
                                        <header class="pricing-plan-header column-flush span-3">
                                            <h2 class="pricing-plan-title"><?php echo get_the_title(); ?></h2>
                                            <h1 class="pricing-plan-price">
                                                <sup class="pricing-plan-currency">R$</sup><span class="pricing-plan-number">
                                                    <?php 
                                                    $price = $price / 12;
                                                    $valor = $price;
                                                    echo number_format($valor,2,",","."); 
                                                     ?>
                                                </span>
                                                <sup class="pricing-plan-period">/ Mês</sup>
                                            </h1>
                                        </header>
                                        <section class="pricing-plan-body column-flush span-6">
                                            <ul class="pricing-plan-items">
                                                <?php echo get_the_excerpt(); ?>   
                                            </ul>
                                        </section>
                                        <footer class="pricing-plan-footer column-flush span-3">
                                            <?php echo do_shortcode('[add_to_cart id="'.get_the_ID().'"]' );?>
                                        </footer>
                                    </div>        
                                <?php endwhile; 
                                    wp_reset_query(); 
                                ?>
                            </article>
                        </div>
                    </div>
                </div>        
            </div><!-- #post -->
    </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>
