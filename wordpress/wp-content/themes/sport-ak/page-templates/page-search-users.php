<?php
/*
  Template Name: Page search users
 */

if(isset( $_GET['user_search_form_submitted'] ) && wp_verify_nonce($_GET['user_search_form_submitted'], 'user_search_form') ){ 

    global $wpdb;
    //some cleanup to the search term, as well as caching it to $usersearch
    
    $usersearch = $_GET['name_user'];
    //$wpdb->prepare() is a fast and safe method for performing a MySQL query
    
    $stmt = $wpdb->prepare("SELECT user_id FROM $wpdb->usermeta AS um
        WHERE ( um.meta_key='first_name' AND um.meta_value LIKE '%%%s%%') OR
        (um.meta_key='last_name' AND um.meta_value LIKE '%%%s%%')
        ORDER BY um.meta_value 
        LIMIT 150",
        $usersearch, $usersearch );
    
    //results are cached in the variable $results using get_col()
    $results = $wpdb->get_col( $stmt );
    }

?>

<?php get_header(); ?>
<div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">
        <div class="position-static wpb_column vc_column_container col-sm-12">
            <div class="wpb_wrapper">
                <?php while (have_posts()) : the_post(); ?>
                        <?php echo do_shortcode('[user_search]'); ?>
                        <div class="posts-list player-mini our-team horizontal-list-4">
                            <?php 
                                foreach ($results as $result) :
                                         $info_user = get_user_meta( $result );

                                    ?>
                                    <div class="filtered">
                                        <div class="entry player-mini azsc_player type-azsc_player has-post-thumbnail hentry position-defender">
                                            <div class="entry-thumbnail">
                                                <a href="#">
                                                    <div class="image" 
                                                        style="background-image: url(<?php 
                                                        if(isset($info_user['user_avatar'][0]) || $info_user['user_avatar'][0] == " " ) {
                                                            echo content_url().$info_user['user_avatar'][0]; 
                                                        } else{
                                                            echo get_template_directory_uri()."-child/img/default-avatar.png";
                                                        }
                                                         ?>); height:300px;"
                                                        }
                                                        data-width="300" data-height="300">
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="entry-data">
                                                <div class="entry-header">
                                                    <h2 class="entry-title">
                                                        <a href="#">
                                                            <?php echo $info_user['first_name'][0]; ?>
                                                            <?php echo $info_user['last_name'][0]; ?>          
                                                        </a>
                                                    </h2>
                                                    <div class="entry-meta">
                                                        <div class="player-position">
                                                            <?php echo $info_user['user-first-position'][0]; ?>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               <?php endforeach; ?>
                        </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
