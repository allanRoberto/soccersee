<?php
/*
  Template Name: Page search users
 */

function objectToArray($d) {
 if (is_object($d)) {
 // Gets the properties of the given object
 // with get_object_vars function
 $d = get_object_vars($d);
 }
 
 if (is_array($d)) {
 /*
 * Return array converted to object
 * Using __FUNCTION__ (Magic constant)
 * for recursive call
 */
 return array_map(__FUNCTION__, $d);
 }
 else {
 // Return array
 return $d;
 }
 }
 
if(isset( $_GET['user_search_form_submitted'] ) && wp_verify_nonce($_GET['user_search_form_submitted'], 'user_search_form') ){ 

    global $wpdb;
    //some cleanup to the search term, as well as caching it to $usersearch
    
    $usersearch = $_GET['name_user'];
    $position = $_GET['position_user'];
    $state = $_GET['state_user'];
    $min_date = $_GET['date_of_birth_min_user'];
    $max_date = $_GET['date_of_birth_max_user'];
    //$wpdb->prepare() is a fast and safe method for performing a MySQL query

    $args = array(
    'blog_id'      => $GLOBALS['blog_id'],
    'role'         => '',
    'meta_query'   => array(),
    'date_query'   => array(),        
    'include'      => array(),
    'exclude'      => array(),
    'orderby'      => 'login',
    'order'        => 'ASC',
    'offset'       => '',
    'search'       => $usersearch,
    'number'       => '',
    'count_total'  => false,
    'fields'       => 'all',
    'who'          => ''
 ); 
 $user_query = get_users( $args );



    if(!empty($user_query)) {
        $title = '<h2 class="text-center"> Resultados da pesquisa</h2>';

    }  else {
        $title = '';
    }
    
  
}else {
   $args = array(
    'blog_id'      => $GLOBALS['blog_id'],
    'role'         => '',
    'meta_query'   => array(),
    'date_query'   => array(),        
    'include'      => array(),
    'exclude'      => array(),
    'orderby'      => 'login',
    'order'        => 'ASC',
    'offset'       => '',
    'search'       => '',
    'number'       => '',
    'count_total'  => false,
    'fields'       => 'all',
    'who'          => ''
 ); 
 $user_query = get_users( $args );
}

?>

<?php get_header(); ?>
<div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">
        <div class="position-static wpb_column vc_column_container col-sm-12">
            <div class="wpb_wrapper">
                <?php while (have_posts()) : the_post(); ?>
                        <?php echo do_shortcode('[user_search]'); ?>
                        <?php echo $title; ?>
                        <div class="posts-list player-mini   our-team horizontal-list-4">
                            <?php 
                                
                                foreach ($user_query as $info_user) :
                                    $info_user = objectToArray($info_user);
                                var_dump($info_user);
                                    $info_user = get_user_meta($info_user['ID']);
                                    var_dump($info_user);
                            ?>
                                    <div class="filtered">
                                        <div class="entry player-mini azsc_player type-azsc_player has-post-thumbnail hentry position-defender">
                                            <div class="entry-thumbnail">
                                                <a href="<?php echo get_permalink(1139) ?>/?user_id=<?php echo $info_user['ID'] ?>">
                                                    <div class="image" 
                                                        style="background-image: url(<?php echo $info_user['user_avatar']; ?>); height:300px;"
                                                        data-width="300" data-height="300">
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="entry-data">
                                                <div class="entry-header">
                                                    <h2 class="entry-title">
                                                        <a href="<?php echo get_permalink(1139) ?>/?user_id=<?php echo $info_user['data']['ID'] ?>">
                                                            <?php echo $info_user['first_name'][0]; ?>
                                                            <?php echo $info_user['last_name'][0]; ?>          
                                                        </a>
                                                    </h2>
                                                    <div class="entry-meta">
                                                        <div class="player-position">
                                                            <?php echo $info_user['user-state-address'][0];?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               <?php endforeach; 
                               ?>
                        </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
