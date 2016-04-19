<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

add_action('after_setup_theme', 'azexo_load_childtheme_languages', 5);

function azexo_load_childtheme_languages() {
    /* this theme supports localization */
    load_child_theme_textdomain('sport-ak', get_stylesheet_directory() . '/languages');
}


add_action('wp_enqueue_scripts', 'azexo_custom_scripts');

function azexo_custom_scripts() {
    wp_register_script('custom-js', get_template_directory_uri() . '-child/js/custom.js', array('jquery'), AZEXO_THEME_VERSION, true);
    wp_enqueue_script('custom-js');
    wp_register_script('masketinput-js', get_template_directory_uri() . '-child/js/jquery.maskedinput.min.js', array('jquery'), AZEXO_THEME_VERSION, true); 
    wp_enqueue_script('masketinput-js');
}

add_action( 'wp_ajax_load_files', 'load_files' );
add_action( 'wp_ajax_nopriv_load_files', 'load_files' );


function load_files() {
	$id=20; 
	$post = get_post($id); 
	$content = apply_filters('the_content', $post->post_content); 
	return $content; 
	wp_die();
}

add_action( 'wp_ajax_load_cities', 'load_cities' );
add_action( 'wp_ajax_nopriv_load_cities', 'load_cities' );


function load_cities() {

	global $wpdb;

	$state = $_REQUEST['estado'];

	$query = 'SELECT cod_cidades, nome FROM '.$wpdb->prefix.'cidades WHERE '.$wpdb->prefix.'estados.cod_estados = '.$state.' ORDER BY nome';

	$results = $wpdb->get_results($query, OBJECT);

	echo json_encode($results);
	
	die();
}

add_shortcode('user_search', 'search_user_shortcode');


function search_user_shortcode() {

	 echo user_search_form();
	}

function user_search_form() {
	ob_start(); ?>
	<form id="user_search_form" method="GET" action="<?php echo get_permalink(1155); ?>">
	<?php wp_nonce_field('user_search_form', 'user_search_form_submitted');?>
		<div class="row">
			<div class="col-lg-12">
				<h1 class="entry-title-form">Pesquisa de jogadores</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-xs-12">
				<label for="name_user">Nome:</label>
				<input type="text" name="name_user" id="name_user" />
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<label for="position_user">Posição :</label>
				<select name="position_user">
					<option value="Goleiro">Goleiro</option>
				</select>		
			</div>
			<div class="col-lg-4">
				<label for="date_of_birth_min_user">
					Data de nascimento entre : 
				</label>
				<input type="text" value="" class="input-date" id="date_of_birth_user" name="date_of_birth_min_user"  />
			</div>
			<div class="col-lg-4">
				<label for="date_of_birth_min_user">
					Até : 
				</label>
				<input type="text" value="" class="input-date" id="date_of_birth_user" name="date_of_birth_max_user"  />
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<label for="height_user">
					Altura :
				</label>
				<select name="height_user" id="height_user">
					<option>1.50 a 1.55</option>
				</select>
			</div>
			<div class="col-lg-4">
				<label for="state_user">
					Estado :
				</label>
					<select name="state_user">
						<option>1</option>
					</select>
				</label>
			</div>
			<div class="col-lg-4">
				<label for="city_user">
					Cidade :
				</label>
					<select name="city_user">
						<option>1</option>
					</select>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<input type="submit" id="sui_submit" class="pricing-button" name="sui_submit" value="Pesquisar jogador" style="margin-top: 20px;">
			</div>
		</div>
	</form> 
	<?php 
 	
 	$output = ob_get_contents();
   	ob_clean(); 
    return $output; 
  }




