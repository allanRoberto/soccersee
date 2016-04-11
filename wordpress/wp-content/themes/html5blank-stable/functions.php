<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation

class description_walker extends Walker_Nav_Menu {

  function start_el(&$output, $item, $depth, $args) {
      
       global $wp_query;
       
       $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

       $class_names = $value = '';

       $classes = empty( $item->classes ) ? array() : (array) $item->classes;

       $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
       $class_names = ' class="'. esc_attr( $class_names ) . '"';

       $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

       $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
       $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
       $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
       $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

       $prepend = '';
       $append = '';
       $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

       if($depth != 0)
       {
            $description = $append = $prepend = "";
       }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .' class="menu-link">';
        $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
        $item_output .= $description.$args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

        if ($item->menu_order == 1) {
            $classes[] = 'first';
        }

    }
}

function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'ul',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'nav-menu',
		'menu_id'         => 'primary-menu-mobile',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'depth'           => 0,
		'walker'          => '',
        'items_wrap'       => '<ul class="coco">%3$s</ul>'
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    	wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('conditionizr'); // Enqueue it!

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('html5blankscripts'); // Enqueue it!

        wp_register_script('bootstrap-script', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('bootstrap-script'); // Enqueue it!

         wp_register_script('masonry-script', get_template_directory_uri() . '/js/masonry.min.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('masonry-script'); // Enqueue it!

    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    wp_enqueue_style('normalize'); // Enqueue it!

    wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('html5blank'); // Enqueue it!

    wp_register_style('bootstrap-style', get_template_directory_uri() . '/css/bootstrap.css', array(), '1.0', 'all');
    wp_enqueue_style('bootstrap-style'); // Enqueue it!

    wp_register_style('customize-style', get_template_directory_uri() . '/css/customize.css', array(), '1.0', 'all');
    wp_enqueue_style('customize-style'); // Enqueue it!

     wp_register_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '1.0', 'all');
    wp_enqueue_style('font-awesome'); // Enqueue it!




}



// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}


// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}


// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('html5-blank', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
            'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
            'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
            'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
            'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
            'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

add_shortcode( 'peneiras', 'artezzo_peneiras' );

function artezzo_peneiras( $atts ) {
    
    $atts = shortcode_atts(array(
        'posts_per_page' => '6',
        'category'      => '',
        'auto'          => true,
        'speed'         => '5000',
        'not_in'        => '',
        'offset'        => ''   
    ), $atts );

    $args = array(
        'posts_per_page'      => $posts_per_page,
        'category'            => $category,
        'not_in'              => $not_in,
    );

    ob_start();?>

    <div class="vc_row wpb_row vc_row-fluid our-news vc_custom_1448547390713">
    <div class="row">
        <div class="h-padding-0 wpb_column vc_column_container vc_col-sm-12">
            <div class="wpb_wrapper">
                <div class="vc_row wpb_row vc_inner vc_row-fluid container">
                    <div class="row">
                        <div class="wpb_column vc_column_container vc_col-sm-12">
                            <div class="wpb_wrapper">
                                <h1 style="font-size: 37px;text-align: center" class="vc_custom_heading"><span>Avaliações</span> pelo Brasil</h1>
                                <div class="wpb_text_column wpb_content_element " style="margin-bottom: 35px;">
                                    <div class="wpb_wrapper">
                                        <p style="text-align: center;">Abaixo você confere as principais peneiras realizadas em todo o Brasil.</p>
                                    </div>
                                </div>
                                <div class="posts-list-wrapper  horizontal-list-2 hl-0-paddings">
                                    <div class="posts-list half-image-post   horizontal-list-2 hl-0-paddings" data-contents-per-item="1" data-width="400" data-height="400" data-stagepadding="0" data-margin="0" data-full-width="" data-center="" data-loop="">
                                        <div class="entry half-image-post post-735 post type-post status-publish format-standard has-post-thumbnail hentry category-entertainment tag-player">
                                            <div class="entry-thumbnail">
                                                <a href="http://azexo.com/sportak/2015/10/29/duis-aute-irure-dolor-in-reprehenderit-9/">
                                                    <div class="image " style="background-image: url(&quot;http://azexo.com/sportak/wp-content/uploads/2015/10/flank-599180_1280-400x400.jpg&quot;); height: 400px;" data-width="400" data-height="400">
                                                    </div>
                                                </a>
                                                <div class="entry-hover">
                                                </div>
                                            </div>
                                            <div class="entry-data">
                                                <div class="entry-header">
                                                    <div class="entry-extra">
                                                        <span class="date"><a href="http://azexo.com/sportak/2015/10/29/duis-aute-irure-dolor-in-reprehenderit-9/" title="Permalink to Duis aute irure dolor in reprehenderit" rel="bookmark"><time class="entry-date" datetime="2015-10-29T04:38:58+00:00">Data: 10/02/2014 às 14h</time></a></span>                
                                                    </div>
                                                    <h2 class="entry-title"><a href="http://azexo.com/sportak/2015/10/29/duis-aute-irure-dolor-in-reprehenderit-9/" rel="bookmark">Duis aute irure dolor in reprehenderit</a></h2>
                                                </div>
                                                <div class="entry-summary">
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore…                
                                                </div>
                                                <!-- .entry-summary -->
                                                <div class="entry-footer">
                                                    <div class="entry-more"> <a href="http://azexo.com/sportak/2015/10/29/duis-aute-irure-dolor-in-reprehenderit-9/#more-735" class="more-link">Read more</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- #post -->
                                        <div class="entry half-image-post post-681 post type-post status-publish format-standard has-post-thumbnail hentry category-entertainment tag-ball">
                                            <div class="entry-thumbnail">
                                                <a href="http://azexo.com/sportak/2015/10/28/duis-aute-irure-dolor-in-reprehenderit-8/">
                                                    <div class="image " style="background-image: url(&quot;http://azexo.com/sportak/wp-content/uploads/2015/10/football-19448_1280-400x400.jpg&quot;); height: 400px;" data-width="400" data-height="400">
                                                    </div>
                                                </a>
                                                <div class="entry-hover">
                                                </div>
                                            </div>
                                            <div class="entry-data">
                                                <div class="entry-header">
                                                    <div class="entry-extra">
                                                        <span class="date"><a href="http://azexo.com/sportak/2015/10/28/duis-aute-irure-dolor-in-reprehenderit-8/" title="Permalink to Duis aute irure dolor in reprehenderit" rel="bookmark"><time class="entry-date" datetime="2015-10-28T09:38:43+00:00">Data: 10/02/2014 às 14h</time></a></span>                
                                                    </div>
                                                    <h2 class="entry-title"><a href="http://azexo.com/sportak/2015/10/28/duis-aute-irure-dolor-in-reprehenderit-8/" rel="bookmark">Duis aute irure dolor in reprehenderit</a></h2>
                                                </div>
                                                <div class="entry-summary">
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore…                
                                                </div>
                                                <!-- .entry-summary -->
                                                <div class="entry-footer">
                                                    <div class="entry-more"> <a href="http://azexo.com/sportak/2015/10/28/duis-aute-irure-dolor-in-reprehenderit-8/#more-681" class="more-link">Read more</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- #post -->
                                    </div>
                                </div>
                                <div class="vc_btn3-container vc_btn3-center vc_custom_1445944218177"><a style="background-color:#ededed; color:#666666;" class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-square vc_btn3-style-custom" href="#" title="" target="_self">Veja a lista completa</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<?php
    $output = ob_get_contents();

    ob_end_clean();


    return $output;

}

add_shortcode( 'galeria', 'artezzo_galeria' );

function artezzo_galeria( $atts ) {
    
    $atts = shortcode_atts(array(
        'posts_per_page' => '6',
        'category'      => '',
        'auto'          => true,
        'speed'         => '5000',
        'not_in'        => '',
        'offset'        => ''   
    ), $atts );

    $args = array(
        'posts_per_page'      => $posts_per_page,
        'category'            => $category,
        'not_in'              => $not_in,
    );

    ob_start();?>

<div class="vc_row wpb_row vc_row-fluid vc_custom_1445943047633">
    <div class="row">
        <div class="h-padding-0 wpb_column vc_column_container vc_col-sm-12">
            <div class="wpb_wrapper">
                <div class="vc_row wpb_row vc_inner vc_row-fluid container vc_custom_1445358022892">
                    <div class="row">
                        <div class="wpb_column vc_column_container vc_col-sm-12">
                            <div class="wpb_wrapper">
                                <div class="entry  gallery-title">
                                    <div class="entry-data">
                                        <div class="entry-header">
                                            <div class="entry-title">Galeria de fotos</div>
                                        </div>
                                        <!-- header -->
                                        <div class="entry-content">
                                            <p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
                                        </div>
                                    </div>
                                    <!-- data -->
                                </div>
                                <!-- entry -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filters-wrapper ">
                    <script type="text/javascript">window["filters-33493050"] = {"0":{"items":"1"},"786":{"items":"2"},"962":{"items":"3"},"1200":{"items":"4"}};</script>
                    <div class="filterable masonry" data-selector=".entry" data-responsive="filters-33493050" data-gutter="0">
                        <div class="entry  gallery-item basketball showed">
                            <div class="entry-thumbnail"></div>
                            <div class="entry-data">
                                <div class="entry-header">
                                    <div class="entry-title">Douglas Payne</div>
                                    <div class="entry-meta">Defender</div>
                                </div>
                                <!-- header -->
                                <div class="entry-footer"><a class="image-popup" href="http://azexo.com/sportak/wp-content/uploads/2015/10/Layer-2.png">-</a></div>
                            </div>
                            <!-- data -->
                        </div>
                        <!-- entry -->
                        <div class="entry  gallery-item football regbee showed">
                            <div class="entry-thumbnail"></div>
                            <div class="entry-data">
                                <div class="entry-header">
                                    <div class="entry-title">Douglas Payne</div>
                                    <div class="entry-meta">Defender</div>
                                </div>
                                <!-- header -->
                                <div class="entry-footer"><a class="image-popup" href="http://azexo.com/sportak/wp-content/uploads/2015/10/Layer-2.png">-</a></div>
                            </div>
                            <!-- data -->
                        </div>
                        <!-- entry -->
                        <div class="entry  gallery-item football showed">
                            <div class="entry-thumbnail">
                                <div class="image" style="background-image: url(&quot;http://azexo.com/sportak/wp-content/uploads/2015/10/football-606230_1280-400x300.jpg&quot;); height: 300px;"></div>
                            </div>
                            <div class="entry-data">
                                <div class="entry-header">
                                    <div class="entry-title">Douglas Payne</div>
                                    <div class="entry-meta">Defender</div>
                                </div>
                                <!-- header -->
                                <div class="entry-footer"><a class="image-popup" href="http://azexo.com/sportak/wp-content/uploads/2015/10/Layer-2.png">-</a></div>
                            </div>
                            <!-- data -->
                        </div>
                        <!-- entry -->
                        <div class="entry  gallery-item hockey regbee showed">
                            <div class="entry-thumbnail">
                                <div class="image" style="background-image: url(&quot;http://azexo.com/sportak/wp-content/uploads/2015/10/football-461343_1280-400x300.jpg&quot;); height: 300px;"></div>
                            </div>
                            <div class="entry-data">
                                <div class="entry-header">
                                    <div class="entry-title">Douglas Payne</div>
                                    <div class="entry-meta">Defender</div>
                                </div>
                                <!-- header -->
                                <div class="entry-footer"><a class="image-popup" href="http://azexo.com/sportak/wp-content/uploads/2015/10/Layer-2.png">-</a></div>
                            </div>
                            <!-- data -->
                        </div>
                        <!-- entry -->
                        <div class="entry  gallery-item hockey baseball showed">
                            <div class="entry-thumbnail">
                                <div class="image" style="background-image: url(&quot;http://azexo.com/sportak/wp-content/uploads/2015/10/flank-599180_1280-400x300.jpg&quot;); height: 300px;"></div>
                            </div>
                            <div class="entry-data">
                                <div class="entry-header">
                                    <div class="entry-title">Douglas Payne</div>
                                    <div class="entry-meta">Defender</div>
                                </div>
                                <!-- header -->
                                <div class="entry-footer"><a class="image-popup" href="http://azexo.com/sportak/wp-content/uploads/2015/10/Layer-2.png">-</a></div>
                            </div>
                            <!-- data -->
                        </div>
                        <!-- entry -->
                        <div class="entry  gallery-item basketball showed">
                            <div class="entry-thumbnail">
                                <div class="image" style="background-image: url(&quot;http://azexo.com/sportak/wp-content/uploads/2015/10/shutterstock_176578913-400x300.jpg&quot;); height: 300px;"></div>
                            </div>
                            <div class="entry-data">
                                <div class="entry-header">
                                    <div class="entry-title">Douglas Payne</div>
                                    <div class="entry-meta">Defender</div>
                                </div>
                                <!-- header -->
                                <div class="entry-footer"><a class="image-popup" href="http://azexo.com/sportak/wp-content/uploads/2015/10/Layer-2.png">-</a></div>
                            </div>
                            <!-- data -->
                        </div>
                        <!-- entry -->
                        <div class="entry  gallery-item valleyball showed">
                            <div class="entry-thumbnail">
                                <div class="image" style="background-image: url(&quot;http://azexo.com/sportak/wp-content/uploads/2015/10/football-340938_1280-400x300.jpg&quot;); height: 300px;"></div>
                            </div>
                            <div class="entry-data">
                                <div class="entry-header">
                                    <div class="entry-title">Douglas Payne</div>
                                    <div class="entry-meta">Defender</div>
                                </div>
                                <!-- header -->
                                <div class="entry-footer"><a class="image-popup" href="http://azexo.com/sportak/wp-content/uploads/2015/10/Layer-2.png">-</a></div>
                            </div>
                            <!-- data -->
                        </div>
                        <!-- entry -->
                        <div class="entry  gallery-item hockey showed">
                            <div class="entry-thumbnail">
                                <div class="image" style="background-image: url(&quot;http://azexo.com/sportak/wp-content/uploads/2015/10/child-613199_640-400x300.jpg&quot;); height: 300px;"></div>
                            </div>
                            <div class="entry-data">
                                <div class="entry-header">
                                    <div class="entry-title">Douglas Payne</div>
                                    <div class="entry-meta">Defender</div>
                                </div>
                                <!-- header -->
                                <div class="entry-footer"><a class="image-popup" href="http://azexo.com/sportak/wp-content/uploads/2015/10/Layer-2.png">-</a></div>
                            </div>
                            <!-- data -->
                        </div>
                        <!-- entry -->
                        <div class="entry  gallery-item valleyball showed">
                            <div class="entry-thumbnail">
                                <div class="image" style="background-image: url(&quot;http://azexo.com/sportak/wp-content/uploads/2015/10/the-ball-488715_640-400x300.jpg&quot;); height: 300px;"></div>
                            </div>
                            <div class="entry-data">
                                <div class="entry-header">
                                    <div class="entry-title">Douglas Payne</div>
                                    <div class="entry-meta">Defender</div>
                                </div>
                                <!-- header -->
                                <div class="entry-footer"><a class="image-popup" href="http://azexo.com/sportak/wp-content/uploads/2015/10/Layer-2.png">-</a></div>
                            </div>
                            <!-- data -->
                        </div>
                        <!-- entry -->
                        <div class="entry  gallery-item basketball baseball showed">
                            <div class="entry-thumbnail">
                                <div class="image" style="background-image: url(&quot;http://azexo.com/sportak/wp-content/uploads/2015/10/football-674763_1280-400x300.jpg&quot;); height: 300px;"></div>
                            </div>
                            <div class="entry-data">
                                <div class="entry-header">
                                    <div class="entry-title">Douglas Payne</div>
                                    <div class="entry-meta">Defender</div>
                                </div>
                                <!-- header -->
                                <div class="entry-footer"><a class="image-popup" href="http://azexo.com/sportak/wp-content/uploads/2015/10/Layer-2.png">-</a></div>
                            </div>
                            <!-- data -->
                        </div>
                        <!-- entry -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $output = ob_get_contents();

    ob_end_clean();


    return $output;

}


?>
