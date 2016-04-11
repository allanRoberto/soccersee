<?php

/*
  Plugin Name: AZEXO Sport Club
  Plugin URI: http://azexo.com
  Description: AZEXO Sport Club
  Author: azexo
  Author URI: http://azexo.com
  Version: 1.18
  Text Domain: azsc
  Domain Path: /lang
 */


include_once( 'cmb-field-map.php' );

add_action('plugins_loaded', 'azsc_plugins_loaded');

function azsc_plugins_loaded() {
    load_plugin_textdomain('azsc', FALSE, basename(dirname(__FILE__)) . '/lang/');
}

add_action('init', 'azsc_init');

function azsc_init() {
    register_post_type('azsc_match', array(
        'labels' => array(
            'name' => __('Match', 'azsc'),
            'singular_name' => __('Match', 'azsc'),
            'add_new' => _x('Add Match', 'azsc'),
            'add_new_item' => _x('Add New Match', 'azsc'),
            'edit_item' => _x('Edit Match', 'azsc'),
            'new_item' => _x('New Match', 'azsc'),
            'view_item' => _x('View Match', 'azsc'),
            'search_items' => _x('Search Matches', 'azsc'),
            'not_found' => _x('No Match found', 'azsc'),
            'not_found_in_trash' => _x('No Match found in Trash', 'azsc'),
            'parent_item_colon' => _x('Parent Match:', 'azsc'),
            'menu_name' => _x('Matches', 'azsc'),
        ),
        'supports' => array('title', 'editor', 'custom-fields', 'revisions', 'thumbnail', 'comments'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'rewrite' => array('slug' => 'match'),
        'query_var' => true,
        'hierarchical' => true,
            )
    );
    register_post_type('azsc_player', array(
        'labels' => array(
            'name' => __('Player', 'azsc'),
            'singular_name' => __('Player', 'azsc'),
            'add_new' => _x('Add Player', 'azsc'),
            'add_new_item' => _x('Add New Player', 'azsc'),
            'edit_item' => _x('Edit Player', 'azsc'),
            'new_item' => _x('New Player', 'azsc'),
            'view_item' => _x('View Player', 'azsc'),
            'search_items' => _x('Search Players', 'azsc'),
            'not_found' => _x('No Player found', 'azsc'),
            'not_found_in_trash' => _x('No Player found in Trash', 'azsc'),
            'parent_item_colon' => _x('Parent Player:', 'azsc'),
            'menu_name' => _x('Players', 'azsc'),
        ),
        'supports' => array('title', 'editor', 'custom-fields', 'revisions', 'thumbnail'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'rewrite' => array('slug' => 'player'),
        'query_var' => true,
        'hierarchical' => true,
            )
    );
    register_taxonomy('position', array('azsc_player'), array(
        'label' => __('Position', 'azsc'),
        'hierarchical' => false,
        'labels' => array(
            'name' => __('Position', 'azsc'),
            'singular_name' => __('Position', 'azsc'),
            'menu_name' => __('Position', 'azsc'),
            'all_items' => __('All Positions', 'azsc'),
            'edit_item' => __('Edit Position', 'azsc'),
            'view_item' => __('View Position', 'azsc'),
            'update_item' => __('Update Position', 'azsc'),
            'add_new_item' => __('Add New Position', 'azsc'),
            'new_item_name' => __('New Position Name', 'azsc'),
            'parent_item' => __('Parent Position', 'azsc'),
            'parent_item_colon' => __('Parent Position:', 'azsc'),
            'search_items' => __('Search Positions', 'azsc'),
            'popular_items' => __('Popular Positions', 'azsc'),
            'separate_items_with_commas' => __('Separate Positions with commas', 'azsc'),
            'add_or_remove_items' => __('Add or remove Positions', 'azsc'),
            'choose_from_most_used' => __('Choose from the most used Positions', 'azsc'),
            'not_found' => __('No Positions found', 'azsc'),
        )
    ));

    wp_register_script('richmarker', plugins_url('js/richmarker.js', __FILE__));
    wp_register_script('azsc', plugins_url('js/azsc.js', __FILE__));
}

add_action('tgmpa_register', 'azsc_tgmpa_register');

function azsc_tgmpa_register() {

    $plugins = array(
        array(
            'name' => 'CMB2',
            'slug' => 'cmb2',
            'required' => true,
        ),
    );
    tgmpa($plugins, array());
}

add_filter('azexo_templates', 'azsc_templates');

function azsc_templates($azexo_templates) {
    $azexo_templates['azsc_match'] = __('Match', 'azsc');
    $azexo_templates['azsc_player'] = __('Player', 'azsc');
    return $azexo_templates;
}

add_filter('azexo_template_name', 'azsc_template_name');

function azsc_template_name($template_name) {
    if (in_array(get_post_type(), array('azsc_match', 'azsc_player'))) {
        return get_post_type();
    }
    return $template_name;
}

add_action('cmb2_init', 'azsc_match_metabox');

function azsc_match_metabox() {
    if (function_exists('new_cmb2_box')) {
        $prefix = '_az_';

        $match_cmb = new_cmb2_box(array(
            'id' => 'match_data',
            'title' => __('Match data', 'azsc'),
            'object_types' => array('azsc_match'),
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true,
        ));

        $match_cmb->add_field(array(
            'name' => __('Date and time', 'azsc'),
            'id' => $prefix . 'date_time',
            'type' => 'text_datetime_timestamp',
        ));
        $match_cmb->add_field(array(
            'name' => __('Location', 'azsc'),
            'id' => $prefix . 'location',
            'type' => 'pw_map',
        ));
        $match_cmb->add_field(array(
            'name' => __('Address', 'azsc'),
            'id' => $prefix . 'address',
            'type' => 'text',
        ));
        $match_cmb->add_field(array(
            'name' => __('Team 1', 'azsc'),
            'id' => $prefix . 'team1',
            'type' => 'text',
        ));
        $match_cmb->add_field(array(
            'name' => __('Team 1 image', 'azsc'),
            'id' => $prefix . 'team1_image',
            'type' => 'file',
        ));
        $match_cmb->add_field(array(
            'name' => __('Team 1 score', 'azsc'),
            'id' => $prefix . 'team1_score',
            'type' => 'text',
        ));
        $match_cmb->add_field(array(
            'name' => __('Team 2', 'azsc'),
            'id' => $prefix . 'team2',
            'type' => 'text',
        ));
        $match_cmb->add_field(array(
            'name' => __('Team 2 image', 'azsc'),
            'id' => $prefix . 'team2_image',
            'type' => 'file',
        ));
        $match_cmb->add_field(array(
            'name' => __('Team 2 score', 'azsc'),
            'id' => $prefix . 'team2_score',
            'type' => 'text',
        ));
    }
}

add_action('cmb2_init', 'azsc_player_metabox');

function azsc_player_metabox() {
    if (function_exists('new_cmb2_box')) {
        $prefix = '_az_';

        $player_cmb = new_cmb2_box(array(
            'id' => 'player_data',
            'title' => __('Player data', 'azsc'),
            'object_types' => array('azsc_player'),
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true,
        ));

        $player_cmb->add_field(array(
            'name' => __('Number', 'azsc'),
            'id' => $prefix . 'number',
            'type' => 'text',
        ));
        $player_cmb->add_field(array(
            'name' => __('Appearances', 'azsc'),
            'id' => $prefix . 'appearances',
            'type' => 'text',
        ));
        $player_cmb->add_field(array(
            'name' => __('Goals', 'azsc'),
            'id' => $prefix . 'goals',
            'type' => 'text',
        ));
        $player_cmb->add_field(array(
            'name' => __('Yellow cards', 'azsc'),
            'id' => $prefix . 'yellow_cards',
            'type' => 'text',
        ));
        $player_cmb->add_field(array(
            'name' => __('Red cards', 'azsc'),
            'id' => $prefix . 'red_cards',
            'type' => 'text',
        ));
        $player_cmb->add_field(array(
            'name' => __('Date of birth', 'azsc'),
            'id' => $prefix . 'date_of_birth',
            'type' => 'text_date_timestamp',
        ));
        $player_cmb->add_field(array(
            'name' => __('Nationality', 'azsc'),
            'id' => $prefix . 'nationality',
            'type' => 'text',
        ));
        $player_cmb->add_field(array(
            'name' => __('Height', 'azsc'),
            'id' => $prefix . 'height',
            'type' => 'text',
        ));
        $player_cmb->add_field(array(
            'name' => __('Weight', 'azsc'),
            'id' => $prefix . 'weight',
            'type' => 'text',
        ));


        $player_social = new_cmb2_box(array(
            'id' => 'player_social',
            'title' => __('Player social', 'azsc'),
            'object_types' => array('azsc_player'),
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => true,
        ));

        $player_social->add_field(array(
            'name' => __('Facebook', 'azsc'),
            'id' => $prefix . 'facebook',
            'type' => 'text_url',
        ));
        $player_social->add_field(array(
            'name' => __('Twitter', 'azsc'),
            'id' => $prefix . 'twitter',
            'type' => 'text_url',
        ));
        $player_social->add_field(array(
            'name' => __('Instagram', 'azsc'),
            'id' => $prefix . 'instagram',
            'type' => 'text_url',
        ));
    }
}

add_filter('azexo_fields', 'azsc_fields');

function azsc_fields($azexo_fields) {
    $azexo_fields['match_date'] = __('Match date', 'azsc');
    $azexo_fields['match_date_time'] = __('Match date/time', 'azsc');
    $azexo_fields['match_address'] = __('Match address', 'azsc');
    $azexo_fields['match_info'] = __('Match info', 'azsc');
    $azexo_fields['match_time_left'] = __('Match time left', 'azsc');
    $azexo_fields['match_location'] = __('Match location', 'azsc');
    $azexo_fields['player_position'] = __('Player position', 'azsc');
    $azexo_fields['player_social'] = __('Player social links', 'azsc');
    $azexo_fields['player_dob'] = __('Player date of birth', 'azsc');
    return $azexo_fields;
}

add_filter('azexo_fields_post_types', 'azsc_fields_post_types');

function azsc_fields_post_types($azexo_fields_post_types) {
    $azexo_fields_post_types['match_date'] = 'azsc_match';
    $azexo_fields_post_types['match_date_time'] = 'azsc_match';
    $azexo_fields_post_types['match_address'] = 'azsc_match';
    $azexo_fields_post_types['match_info'] = 'azsc_match';
    $azexo_fields_post_types['match_time_left'] = 'azsc_match';
    $azexo_fields_post_types['match_location'] = 'azsc_match';
    $azexo_fields_post_types['player_position'] = 'azsc_player';
    $azexo_fields_post_types['player_social'] = 'azsc_player';
    $azexo_fields_post_types['player_dob'] = 'azsc_player';
    return $azexo_fields_post_types;
}

add_filter('azexo_entry_field', 'azsc_entry_field', 10, 2);

function azsc_entry_field($output, $name) {
    global $post;
    $options = get_option(AZEXO_THEME_NAME);
    $prefix = '_az_';
    switch ($name) {
        case 'match_location':
            $location = get_post_meta($post->ID, $prefix . 'location', true);
            if (isset($location['latitude']) && !empty($location['latitude']) && isset($location['longitude']) && !empty($location['longitude'])) {
                wp_enqueue_script('google-maps', 'http://maps.google.com/maps/api/js?sensor=false');
                wp_enqueue_script('richmarker');
                wp_enqueue_script('azsc');
                $output = '<div class="match-location"></div>';
                $output .= '<script type="text/javascript">';
                $output .= 'window.azsc = {};';
                $output .= 'azsc.directory = "' . plugins_url('', __FILE__) . '";';
                $output .= 'azsc.location = ' . json_encode($location) . ';';
                $output .= '</script>';
                return $output;
            }
            break;
        case 'match_date':
            $date_time = get_post_meta($post->ID, $prefix . 'date_time', true);
            return '<div class="match-date"><div class="day">' . esc_html(date('d', $date_time)) . '</div><div class="month">' . esc_html(date('M', $date_time)) . '</div><div class="year">' . esc_html(date('Y', $date_time)) . '</div></div>';
            break;
        case 'match_date_time':
            $date_time = get_post_meta($post->ID, $prefix . 'date_time', true);
            return '<div class="match-date-time"><span class="date">' . esc_html(date(get_option('date_format'), $date_time)) . '</span><span class="time">' . esc_html(date(get_option('time_format'), $date_time)) . '</span></div>';
            break;
        case 'match_address':
            return '<div class="match-address">' . esc_html(get_post_meta($post->ID, $prefix . 'address', true)) . '</div>';
            break;
        case 'match_info':
            $date_time = get_post_meta($post->ID, $prefix . 'date_time', true);
            $team1_status = '';
            $team2_status = '';
            $winner = '';
            if (time() > $date_time) {
                $team1_score = get_post_meta($post->ID, $prefix . 'team1_score', true);
                $team2_score = get_post_meta($post->ID, $prefix . 'team2_score', true);
                if ($team1_score > $team2_score) {
                    $team1_status = 'win';
                    $team2_status = 'loss';
                    $winner = 'team1';
                } else {
                    $team1_status = 'loss';
                    $team2_status = 'win';
                    $winner = 'team2';
                }
            }
            $team1 = '<div class="team1 ' . esc_attr($team1_status) . '"><div class="logo" style="background-image: url(' . esc_attr(get_post_meta($post->ID, $prefix . 'team1_image', true)) . ');"></div><div class="name">' . esc_html(get_post_meta($post->ID, $prefix . 'team1', true)) . '</div></div>';
            $team2 = '<div class="team2 ' . esc_attr($team2_status) . '"><div class="logo" style="background-image: url(' . esc_attr(get_post_meta($post->ID, $prefix . 'team2_image', true)) . ');"></div><div class="name">' . esc_html(get_post_meta($post->ID, $prefix . 'team2', true)) . '</div></div>';
            if (time() > $date_time) {
                $score = '<div class="match-score"><div class="score">' . __('Score', 'azsc') . '</div><div class="data ' . $winner . '"><div class="team1 ' . esc_attr($team1_status) . '">' . esc_html($team1_score) . '</div><div class="vs">' . __('VS', 'azsc') . '</div><div class="team2 ' . esc_attr($team2_status) . '">' . esc_html($team2_score) . '</div></div></div>';
            } else {
                $score = '<div class="vs">' . __('VS', 'azsc') . '</div>';
            }
            return '<div class="match-info">' . $team1 . $score . $team2 . '</div>';
            break;
        case 'match_time_left':
            if (function_exists('azexo_time_left')) {
                $date_time = get_post_meta($post->ID, $prefix . 'date_time', true);
                ob_start();
                azexo_time_left($date_time);
                return '<div class="match-time-left">' . ob_get_clean() . '</div>';
            }
            break;
        case 'player_dob':
            return '<span class="player-position">' . (isset($options[$name . '_prefix']) ? '<label>' . esc_html($options[$name . '_prefix']) . '</label>' : '') . date(get_option('date_format'), get_post_meta($post->ID, $prefix . 'date_of_birth', true)) . '</span>';
            break;
        case 'player_position':
            $terms = array_map(function($term) {
                return $term->name;
            }, wp_get_post_terms($post->ID, 'position'));
            return '<span class="player-position">' . (isset($options[$name . '_prefix']) ? '<label>' . esc_html($options[$name . '_prefix']) . '</label>' : '') . implode(', ', $terms) . '</span>';
            break;
        case 'player_social':
            $output = '<span class="player-social">';
            $meta = get_post_meta($post->ID, $prefix . 'facebook', true);
            if (!empty($meta)) {
                $output .= '<a target="_blank" href="' . esc_attr($meta) . '"><span class="fa fa-facebook"></span></a>';
            }
            $meta = get_post_meta($post->ID, $prefix . 'twitter', true);
            if (!empty($meta)) {
                $output .= '<a target="_blank" href="' . esc_attr($meta) . '"><span class="fa fa-twitter"></span></a>';
            }
            $meta = get_post_meta($post->ID, $prefix . 'instagram', true);
            if (!empty($meta)) {
                $output .= '<a target="_blank" href="' . esc_attr($meta) . '"><span class="fa fa-instagram"></span></a>';
            }
            $output .= '</span>';
            return $output;
            break;
    }
    return $output;
}

add_filter('body_class', 'azsc_body_class');

function azsc_body_class($classes) {
    if (is_single()) {
        global $post;
        if ($post->post_type == 'azsc_match') {
            $prefix = '_az_';
            $date_time = get_post_meta($post->ID, $prefix . 'date_time', true);
            if (time() > $date_time) {
                $classes[] = 'overpast-match';
            } else {
                $classes[] = 'future-match';
            }
        }
    }
    return $classes;
}
