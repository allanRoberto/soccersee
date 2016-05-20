<?php
/*
  Template Name: Page search users
 */

if($_REQUEST['user_search_form_submitted']) {
  $user_name = $_REQUEST['name_user']; 
    $position_user = $_REQUEST['position_user'];
    $user_nationality = $_REQUEST['user-nationality'];


    if($position_user != '') {
        $position_user_array = 
                    array(
                        'key'     => 'user-first-position',
                        'value'   => $position_user,
                        'compare' => '='    
                    );
                    array(
                        'key'     => 'user-second-position',
                        'value'   => $position_user,
                        'compare' => '='    
                    );
    }else {
        $position_user_array = '';
    }

    if($user_nationality != '') {
        $position_user_array = 
                    array(
                        'key'     => 'user-nationality',
                        'value'   => $user_nationality,
                        'compare' => '='    
                    );
    }else {
        $user_nationality_array = '';
    }


    $args = array(
            'role' => 'customer',
            'meta_key' => 'pw_user_status', 
            'meta_value' => 'approved',
            'search' => '*'.esc_attr( $user_name ).'*',
            'meta_query' => 
            array(
                'relation' => 'OR',
                $position_user_array,
                ), 
            'fields' => 'all',
            );
            

    $user_query = new WP_User_Query($args);

    $users = $user_query->get_results();

    if(!empty($users)) {
        
        $total_users = $user_query->get_total();

        $content = "Pesquisa realizada ".$total_users." resultado(s) encontrado(s)";

        foreach ($users as $key => $user) { 
            $user_meta[$key]['id'] = $user->ID;
            $user_meta[$key]['first_name'] = $user->first_name." ".$user->last_name;
            $user_meta[$key]['position_user'] = get_user_meta($user->ID, 'user-first-position', true);
            $user_meta[$key]['avatar_user'] = site_url('wp-content'.get_user_meta($user->ID, 'user_avatar', true));
            $user_meta[$key]['link_user'] = get_permalink(1139).'?user_id='.$user->ID;
                ob_start();
            ?>

                        <div class="filtered">
                            <div class="entry player-mini azsc_player type-azsc_player has-post-thumbnail hentry position-defender">
                                <div class="entry-thumbnail">
                                     <a href="<?php echo $user_meta[$key]['link_user']; ?>">
                                         <div class="image" style="background-image: url('<?php echo $user_meta[$key]['avatar_user']?>'); height:300px;" data-width="300" data-height="300">
                                         </div>
                                     </a>
                                </div>
                                <div class="entry-data">
                                    <div class="entry-header">
                                        <h2 class="entry-title">
                                            <a href="<?php echo $user_meta[$key]['link_user'];?>"><?php echo $user_meta[$key]['first_name'];?></a>
                                        </h2>
                                        <div class="entry-meta">
                                            <div class="player-position"><?php echo $user_meta[$key]['position_user'] ?></div>
                                        </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
        <?php }
        $content .= ob_get_contents();
        ob_end_clean();
    } else {
        $content = '<h1 class="title-search">Nenhum jogador encontrado</h1>';
    }
}

 get_header(); ?>
<div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">
        <div class="position-static wpb_column vc_column_container col-sm-12">
            <div class="wpb_wrapper">
                <?php while (have_posts()) : the_post(); ?>
                        <?php echo do_shortcode('[user_search]'); ?>
                        <div class="result-header">
                            <h1 class="title-search"></h1>
                        </div>
                        <div class="posts-list player-mini our-team horizontal-list-4 result-search">
                            <?php  
                                if($_REQUEST['user_search_form_submitted']) {
                                    echo $content;
                                }else {
                                    echo do_shortcode('[user_search_list]');
                                }
                            ?>
                        </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>