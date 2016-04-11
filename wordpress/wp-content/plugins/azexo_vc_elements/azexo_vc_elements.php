<?php

/*
  Plugin Name: AZEXO Visual Composer elements
  Plugin URI: http://azexo.com
  Description: AZEXO Visual Composer elements
  Author: azexo
  Author URI: http://azexo.com
  Version: 1.18
  Text Domain: azvc
 */

define('AZVC_URL', plugins_url('', __FILE__));
define('AZVC_DIR', trailingslashit(dirname(__FILE__)) . '/');

add_action('plugins_loaded', 'azvc_plugins_loaded');

function azvc_plugins_loaded() {
    load_plugin_textdomain('azvc', FALSE, basename(dirname(__FILE__)) . '/lang/');
}

add_action('init', 'azvc_init');

function azvc_init() {
    wp_enqueue_script('azexo_vc', plugins_url('js/azexo_vc.js', __FILE__), array('jquery'));
    wp_enqueue_script('azvc-scrollReveal', plugins_url('js/scrollReveal.min.js', __FILE__));

    $taxonomies = get_taxonomies(array(), 'objects');
    $taxonomy_options = array();
    foreach ($taxonomies as $slug => $taxonomy) {
        $taxonomy_options[$taxonomy->label] = $slug;
    }

    if (class_exists('WPBakeryShortCode') && function_exists('vc_map')) {

        class WPBakeryShortCode_azexo_panel extends WPBakeryShortCodesContainer {
            
        }

        vc_map(array(
            "name" => "AZEXO - Panel",
            "base" => "azexo_panel",
            'category' => esc_html__('AZEXO', 'azvc'),
            "as_parent" => array('except' => 'azexo_panel'),
            "content_element" => true,
            "controls" => "full",
            "show_settings_on_create" => true,
            //"is_container" => true,
            'html_template' => AZVC_DIR . 'templates/azexo_panel.php',
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Panel title', 'azvc'),
                    'param_name' => 'title',
                    'description' => esc_html__('Enter text which will be used as title. Leave blank if no title is needed.', 'azvc'),
                    'admin_label' => true
                ),
                array(
                    'type' => 'vc_link',
                    'heading' => esc_html__('URL (Link)', 'azvc'),
                    'param_name' => 'link',
                    'dependency' => array(
                        'element' => 'title',
                        'not_empty' => true,
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Extra class name', 'azvc'),
                    'param_name' => 'el_class',
                    'admin_label' => true,
                    'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'azvc'),
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => esc_html__('Css', 'azvc'),
                    'param_name' => 'css',
                    'group' => esc_html__('Design options', 'azvc'),
                ),
            ),
            "js_view" => 'VcColumnView'
        ));

        class WPBakeryShortCode_azexo_taxonomy extends WPBakeryShortCode {
            
        }

        vc_map(array(
            'name' => "AZEXO - Taxonomy",
            'base' => 'azexo_taxonomy',
            'category' => esc_html__('AZEXO', 'azvc'),
            'description' => esc_html__('A list or dropdown of categories', 'azvc'),
            'html_template' => AZVC_DIR . 'templates/azexo_taxonomy.php',
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Widget title', 'azvc'),
                    'param_name' => 'title',
                    'description' => esc_html__('What text use as a widget title. Leave blank to use default widget title.', 'azvc'),
                    'value' => esc_html__('Categories', 'azvc'),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Taxonomy', 'azvc'),
                    'param_name' => 'taxonomy',
                    'value' => array_merge(array(esc_html__('Select', 'azvc') => ''), $taxonomy_options),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__('Display options', 'azvc'),
                    'param_name' => 'options',
                    'value' => array(
                        esc_html__('Dropdown', 'azvc') => 'dropdown',
                        esc_html__('Show post counts', 'azvc') => 'count',
                        esc_html__('Show hierarchy', 'azvc') => 'hierarchical'
                    ),
                    'description' => esc_html__('Select display options for categories.', 'azvc')
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Extra class name', 'azvc'),
                    'param_name' => 'el_class',
                    'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'azvc')
                )
            )
        ));

        class WPBakeryShortCode_azexo_carousel extends WPBakeryShortCodesContainer {
            
        }

        vc_map(array(
            "name" => "AZEXO - Carousel",
            "base" => "azexo_carousel",
            'category' => esc_html__('AZEXO', 'azvc'),
            "as_parent" => array('only' => 'azexo_generic_content'),
            "content_element" => true,
            "controls" => "full",
            "show_settings_on_create" => true,
            //"is_container" => true,
            'html_template' => AZVC_DIR . 'templates/azexo_carousel.php',
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Carousel title', 'azvc'),
                    'param_name' => 'title',
                    'description' => esc_html__('Enter text which will be used as title. Leave blank if no title is needed.', 'azvc')
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Item margin', 'azvc'),
                    'param_name' => 'item_margin',
                    'value' => '0',
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__('Center item?', 'azvc'),
                    'param_name' => 'center',
                    'value' => array(esc_html__('Yes, please', 'azvc') => 'yes'),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__('Autoplay?', 'azvc'),
                    'param_name' => 'autoplay',
                    'value' => array(esc_html__('Yes, please', 'azvc') => 'yes'),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__('Loop?', 'azvc'),
                    'param_name' => 'loop',
                    'value' => array(esc_html__('Yes, please', 'azvc') => 'yes'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Contents per carousel item', 'azvc'),
                    'param_name' => 'contents_per_item',
                    'value' => '1',
                ),
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__('Responsive', 'azvc'),
                    'param_name' => 'responsive',
                    'value' => urlencode(json_encode(array(
                        array(
                            'window_width' => '0',
                            'items' => '1'
                        ),
                        array(
                            'window_width' => '768',
                            'items' => '1'
                        )
                    ))),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Window width', 'azvc'),
                            'param_name' => 'window_width',
                            'admin_label' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items', 'azvc'),
                            'param_name' => 'items',
                            'admin_label' => true
                        ),
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Extra class name', 'azvc'),
                    'param_name' => 'el_class',
                    'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'azvc'),
                    'admin_label' => true
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => esc_html__('Css', 'azvc'),
                    'param_name' => 'css',
                    'group' => esc_html__('Design options', 'azvc'),
                ),
            ),
            "js_view" => 'VcColumnView'
        ));

        class WPBakeryShortCode_azexo_filters extends WPBakeryShortCodesContainer {
            
        }

        vc_map(array(
            "name" => "AZEXO - Filters",
            "base" => "azexo_filters",
            'category' => esc_html__('AZEXO', 'azvc'),
            "as_parent" => array('only' => 'azexo_generic_content'),
            "content_element" => true,
            "controls" => "full",
            "show_settings_on_create" => true,
            //"is_container" => true,
            'html_template' => AZVC_DIR . 'templates/azexo_filters.php',
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Filters title', 'azvc'),
                    'param_name' => 'title',
                    'description' => esc_html__('Enter text which will be used as title. Leave blank if no title is needed.', 'azvc')
                ),
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__('Filters', 'azvc'),
                    'param_name' => 'filters',
                    'value' => urlencode(json_encode(array(
                        array(
                            'title' => 'All',
                            'selector' => '> *'
                        ),
                    ))),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title', 'azvc'),
                            'param_name' => 'title',
                            'admin_label' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Selector', 'azvc'),
                            'param_name' => 'selector',
                        ),
                    ),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__('Masonry?', 'azvc'),
                    'param_name' => 'masonry',
                    'value' => array(esc_html__('Yes, please', 'azvc') => 'yes'),
                ),
                array(
                    'type' => 'param_group',
                    'heading' => esc_html__('Masonry responsive', 'azvc'),
                    'param_name' => 'responsive',
                    'dependency' => array(
                        'element' => 'masonry',
                        'value' => array('yes'),
                    ),
                    'value' => urlencode(json_encode(array(
                        array(
                            'window_width' => '0',
                            'items' => '1'
                        ),
                        array(
                            'window_width' => '768',
                            'items' => '1'
                        )
                    ))),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Window width', 'azvc'),
                            'param_name' => 'window_width',
                            'admin_label' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items', 'azvc'),
                            'param_name' => 'items',
                            'admin_label' => true
                        ),
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Masonry gutter (px)', 'azvc'),
                    'param_name' => 'gutter',
                    'value' => '0',
                    'dependency' => array(
                        'element' => 'masonry',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Extra class name', 'azvc'),
                    'param_name' => 'el_class',
                    'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'azvc'),
                    'admin_label' => true
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => esc_html__('Css', 'azvc'),
                    'param_name' => 'css',
                    'group' => esc_html__('Design options', 'azvc'),
                ),
            ),
            "js_view" => 'VcColumnView'
        ));

        class WPBakeryShortCode_azexo_generic_content extends WPBakeryShortCode {
            
        }

        vc_map(array(
            "name" => "AZEXO - Generic Content",
            "base" => "azexo_generic_content",
            'category' => esc_html__('AZEXO', 'azvc'),
            "controls" => "full",
            "show_settings_on_create" => true,
            'html_template' => AZVC_DIR . 'templates/azexo_generic_content.php',
            'params' => array(
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Media type', 'azvc'),
                    'param_name' => 'media_type',
                    'admin_label' => true,
                    'value' => array(
                        esc_html__('No media', 'azvc') => 'no_media',
                        esc_html__('Image', 'azvc') => 'image',
                        esc_html__('Gallery', 'azvc') => 'gallery',
                        esc_html__('Video', 'azvc') => 'video',
                        esc_html__('Icon', 'azvc') => 'icon',
                        esc_html__('Image and Icon', 'azvc') => 'image_icon',
                    ),
                    'group' => esc_html__('Media', 'azvc'),
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__('Image', 'azvc'),
                    'param_name' => 'image',
                    'group' => esc_html__('Media', 'azvc'),
                    'dependency' => array(
                        'element' => 'media_type',
                        'value' => array('image', 'image_icon'),
                    ),
                ),
                array(
                    'type' => 'attach_images',
                    'heading' => esc_html__('Images', 'azvc'),
                    'param_name' => 'gallery',
                    'group' => esc_html__('Media', 'azvc'),
                    'dependency' => array(
                        'element' => 'media_type',
                        'value' => array('gallery'),
                    ),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__('Thumbnails?', 'azvc'),
                    'param_name' => 'thumbnails',
                    'group' => esc_html__('Media', 'azvc'),
                    'value' => array(esc_html__('Yes, please', 'azvc') => 'yes'),
                    'dependency' => array(
                        'element' => 'media_type',
                        'value' => array('gallery'),
                    )),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Image size', 'azvc'),
                    'param_name' => 'img_size',
                    'group' => esc_html__('Media', 'azvc'),
                    'value' => 'thumbnail',
                    'description' => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)). Leave parameter empty to use "thumbnail" by default.', 'azvc'),
                    'dependency' => array(
                        'element' => 'media_type',
                        'value' => array('image', 'image_icon', 'gallery'),
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Video link', 'azvc'),
                    'param_name' => 'video',
                    'group' => esc_html__('Media', 'azvc'),
                    'value' => 'http://vimeo.com/92033601',
                    'description' => sprintf(wp_kses(__('Enter link to video (Note: read more about available formats at WordPress <a href="%s" target="_blank">codex page</a>).', 'azvc'), array('a')), 'http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F'),
                    'dependency' => array(
                        'element' => 'media_type',
                        'value' => array('video'),
                    ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Icon library', 'azvc'),
                    'value' => array(
                        esc_html__('Font Awesome', 'azvc') => 'fontawesome',
                        esc_html__('Open Iconic', 'azvc') => 'openiconic',
                        esc_html__('Typicons', 'azvc') => 'typicons',
                        esc_html__('Entypo', 'azvc') => 'entypo',
                        esc_html__('Linecons', 'azvc') => 'linecons',
                    ),
                    'param_name' => 'icon_library',
                    'group' => esc_html__('Media', 'azvc'),
                    'description' => esc_html__('Select icon library.', 'azvc'),
                    'dependency' => array(
                        'element' => 'media_type',
                        'value' => array('icon', 'image_icon'),
                    ),
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'azvc'),
                    'param_name' => 'icon_fontawesome',
                    'group' => esc_html__('Media', 'azvc'),
                    'value' => 'fa fa-adjust', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false,
                        // default true, display an "EMPTY" icon?
                        'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                    ),
                    'dependency' => array(
                        'element' => 'icon_library',
                        'value' => 'fontawesome',
                    ),
                    'description' => esc_html__('Select icon from library.', 'azvc'),
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'azvc'),
                    'param_name' => 'icon_openiconic',
                    'group' => esc_html__('Media', 'azvc'),
                    'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'openiconic',
                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_library',
                        'value' => 'openiconic',
                    ),
                    'description' => esc_html__('Select icon from library.', 'azvc'),
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'azvc'),
                    'param_name' => 'icon_typicons',
                    'group' => esc_html__('Media', 'azvc'),
                    'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'typicons',
                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_library',
                        'value' => 'typicons',
                    ),
                    'description' => esc_html__('Select icon from library.', 'azvc'),
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'azvc'),
                    'param_name' => 'icon_entypo',
                    'group' => esc_html__('Media', 'azvc'),
                    'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'entypo',
                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_library',
                        'value' => 'entypo',
                    ),
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'azvc'),
                    'param_name' => 'icon_linecons',
                    'group' => esc_html__('Media', 'azvc'),
                    'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false, // default true, display an "EMPTY" icon?
                        'type' => 'linecons',
                        'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                    ),
                    'dependency' => array(
                        'element' => 'icon_library',
                        'value' => 'linecons',
                    ),
                    'description' => esc_html__('Select icon from library.', 'azvc'),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Link click effect', 'azvc'),
                    'value' => array(
                        esc_html__('Classic link', 'azvc') => 'classic',
                        esc_html__('Image popup', 'azvc') => 'image_popup',
                        esc_html__('IFrame  popup', 'azvc') => 'iframe_popup',
                    ),
                    'param_name' => 'media_link_click',
                    'group' => esc_html__('Media', 'azvc'),
                    'dependency' => array(
                        'element' => 'media_type',
                        'value' => array('image', 'icon', 'image_icon'),
                    ),
                ),
                array(
                    'type' => 'vc_link',
                    'heading' => esc_html__('URL (Link)', 'azvc'),
                    'param_name' => 'media_link',
                    'group' => esc_html__('Media', 'azvc'),
                    'dependency' => array(
                        'element' => 'media_type',
                        'value' => array('image', 'icon', 'image_icon'),
                    ),
                ),
                array(
                    'type' => 'textarea_raw_html',
                    'heading' => esc_html__('Extra', 'azvc'),
                    'param_name' => 'extra',
                    'group' => esc_html__('Header', 'azvc'),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Link click effect', 'azvc'),
                    'value' => array(
                        esc_html__('Classic link', 'azvc') => 'classic',
                        esc_html__('Image popup', 'azvc') => 'image_popup',
                        esc_html__('IFrame  popup', 'azvc') => 'iframe_popup',
                    ),
                    'param_name' => 'title_link_click',
                    'group' => esc_html__('Header', 'azvc'),
                ),
                array(
                    'type' => 'vc_link',
                    'heading' => esc_html__('URL (Link)', 'azvc'),
                    'param_name' => 'title_link',
                    'group' => esc_html__('Header', 'azvc'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Title', 'azvc'),
                    'param_name' => 'title',
                    'admin_label' => true,
                    'group' => esc_html__('Header', 'azvc'),
                ),
                array(
                    'type' => 'textarea_raw_html',
                    'heading' => esc_html__('Meta', 'azvc'),
                    'param_name' => 'meta',
                    'group' => esc_html__('Header', 'azvc'),
                ),
                array(
                    'type' => 'textarea_html',
                    'heading' => esc_html__('Content', 'azvc'),
                    'holder' => 'div',
                    'param_name' => 'content',
                    'group' => esc_html__('Content', 'azvc'),
                    'value' => wp_kses(__('<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'azvc'), array('p'))
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Link click effect', 'azvc'),
                    'value' => array(
                        esc_html__('Classic link', 'azvc') => 'classic',
                        esc_html__('Image popup', 'azvc') => 'image_popup',
                        esc_html__('IFrame  popup', 'azvc') => 'iframe_popup',
                    ),
                    'param_name' => 'footer_link_click',
                    'group' => esc_html__('Footer', 'azvc'),
                ),
                array(
                    'type' => 'vc_link',
                    'heading' => esc_html__('URL (Link)', 'azvc'),
                    'param_name' => 'footer_link',
                    'group' => esc_html__('Footer', 'azvc'),
                ),
                array(
                    'type' => 'textarea_raw_html',
                    'heading' => esc_html__('Footer', 'azvc'),
                    'param_name' => 'footer',
                    'group' => esc_html__('Footer', 'azvc'),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__('Trigger?', 'azvc'),
                    'param_name' => 'trigger',
                    'value' => array(esc_html__('Yes, please', 'azvc') => 'yes'),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Trigger ON selector', 'azvc'),
                    'param_name' => 'trigger_on',
                    'dependency' => array(
                        'element' => 'trigger',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Trigger OFF selector', 'azvc'),
                    'param_name' => 'trigger_off',
                    'dependency' => array(
                        'element' => 'trigger',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Trigger Class', 'azvc'),
                    'param_name' => 'trigger_class',
                    'dependency' => array(
                        'element' => 'trigger',
                        'value' => array('yes'),
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Scroll Reveal settings', 'azvc'),
                    'param_name' => 'sr',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Extra class name', 'azvc'),
                    'param_name' => 'el_class',
                    'admin_label' => true,
                    'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'azvc'),
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => esc_html__('Css', 'azvc'),
                    'param_name' => 'css',
                    'group' => esc_html__('Design options', 'azvc'),
                ),
            ),
        ));
    }
}
