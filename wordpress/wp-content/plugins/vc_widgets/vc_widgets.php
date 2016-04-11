<?php
/*
  Plugin Name: Visual Composer widgets
  Plugin URI: http://azexo.com
  Description: Visual Composer widgets
  Author: azexo
  Author URI: http://azexo.com
  Version: 1.18
  Text Domain: vc_widgets
 */

add_action('widgets_init', 'vc_widgets_register_widgets');

function vc_widgets_register_widgets() {
    register_widget('VC_Widget');
}

class VC_Widget extends WP_Widget {

    function VC_Widget() {
        parent::__construct('vc_widget', 'AZEXO - VC Widget');
    }

    function widget($args, $instance) {

        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        print $args['before_widget'];
        if ($title) {
            print$args['before_title'] . $title . $args['after_title'];
        }

        if (!empty($instance['post'])) {
            $wpautop = false;
            if (has_filter('the_content', 'wpautop')) {
                remove_filter('the_content', 'wpautop');
                $wpautop = true;
            }
            print azexo_get_post_content($instance['post']);
            if ($wpautop) {
                add_filter('the_content', 'wpautop');
            }
        }

        print $args['after_widget'];
    }

    function form($instance) {
        $defaults = array('post' => '', 'title' => '');
        $instance = wp_parse_args((array) $instance, $defaults);


        $vc_widgets = array();
        $loop = new WP_Query(array(
            'post_type' => 'vc_widget',
            'post_status' => 'publish',
            'showposts' => 100,
            'orderby' => 'title',
            'order' => 'ASC',
        ));
        if ($loop->have_posts()) {
            global $post;
            $original = $post;
            while ($loop->have_posts()) {
                $loop->the_post();
                $vc_widgets[] = $post;
            }
            wp_reset_postdata();
            $post = $original;
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'vc_widgets'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('post'); ?>"><?php _e('VC Widget:', 'vc_widgets'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('post'); ?>" name="<?php echo $this->get_field_name('post'); ?>">
                <?php
                foreach ($vc_widgets as $vc_widget) :
                    ?>
                    <option value="<?php echo $vc_widget->ID ?>" <?php selected($vc_widget->ID, $instance['post']) ?>><?php echo $vc_widget->post_title; ?></option>
                <?php endforeach; ?>
            </select>
        </p>        
        <?php
    }

}

add_action('init', 'vc_widgets_register');

function vc_widgets_register() {
    register_post_type('vc_widget', array(
        'labels' => array(
            'name' => __('VC Widget', 'vc_widgets'),
            'singular_name' => __('VC Widget', 'vc_widgets'),
            'add_new' => _x('Add VC Widget', 'vc_widgets'),
            'add_new_item' => _x('Add New VC Widget', 'vc_widgets'),
            'edit_item' => _x('Edit VC Widget', 'vc_widgets'),
            'new_item' => _x('New VC Widget', 'vc_widgets'),
            'view_item' => _x('View VC Widget', 'vc_widgets'),
            'search_items' => _x('Search VC Widgets', 'vc_widgets'),
            'not_found' => _x('No VC Widget found', 'vc_widgets'),
            'not_found_in_trash' => _x('No VC Widget found in Trash', 'vc_widgets'),
            'parent_item_colon' => _x('Parent VC Widget:', 'vc_widgets'),
            'menu_name' => _x('VC Widgets', 'vc_widgets'),
        ),
        'query_var' => false,
        'rewrite' => true,
        'hierarchical' => true,
        'supports' => array('title', 'editor', 'revisions', 'thumbnail', 'custom-fields'),
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_menu' => true,
        'public' => false,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
            )
    );
    register_taxonomy('widget_type', array('vc_widget'), array(
        'label' => __('Widget type', 'vc_widgets'),
        'hierarchical' => true,
    ));
    if (class_exists('Vc_Manager')) {
        $vc_manager = Vc_Manager::getInstance();
        $post_types = $vc_manager->editorPostTypes();
        if (!in_array('vc_widget', $post_types)) {
            $post_types[] = 'vc_widget';
            $vc_manager->setEditorPostTypes($post_types);
        }
    }
}

add_filter('post_type_link', 'azexo_post_link', 10, 3);

function azexo_post_link($permalink, $post, $leavename) {
    if (in_array($post->post_type, array('vc_widget'))) {
        $external_url = get_post_meta($post->ID, 'external_url', true);
        if (!empty($external_url)) {
            return $external_url;
        }
    }
    return $permalink;
}
