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
    wp_register_script('maskinput-js', get_template_directory_uri() . '-child/js/jquery.maskedinput.min.js', array('jquery'), AZEXO_THEME_VERSION, true);
    wp_enqueue_script('maskinput-js');
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
			<div class="col-lg-6">
				<label for="date_of_birth_min_user">
					Data de nascimento entre : 
				</label>
				<select name="date_of_birth_min_user">
					<option value="1960">1960</option>
					<option value="1961">1961</option>
					<option value="1962">1962</option>
					<option value="1963">1963</option>
					<option value="1964">1964</option>
					<option value="1965">1965</option>
					<option value="1966">1966</option>
					<option value="1967">1967</option>
					<option value="1968">1968</option>
					<option value="1969">1969</option>
					<option value="1970">1970</option>
					<option value="1971">1971</option>
					<option value="1972">1972</option>
					<option value="1973">1973</option>
					<option value="1974">1974</option>
					<option value="1975">1975</option>
					<option value="1976">1976</option>
					<option value="1977">1977</option>
					<option value="1978">1978</option>
					<option value="1979">1979</option>
					<option value="1981">1981</option>
					<option value="1982">1982</option>
					<option value="1983">1983</option>
					<option value="1984">1984</option>
					<option value="1985">1985</option>
					<option value="1986">1986</option>
					<option value="1987">1987</option>
					<option value="1988">1988</option>
					<option value="1989">1989</option>
					<option value="1990">1990</option>
					<option value="1991">1991</option>
					<option value="1992">1992</option>
					<option value="1993">1993</option>
					<option value="1994">1994</option>
					<option value="1995">1995</option>
					<option value="1996">1996</option>
					<option value="1997">1997</option>
					<option value="1998">1998</option>
					<option value="1999">1999</option>
					<option value="2000">2000</option>
					<option value="2001">2001</option>
					<option value="2002">2002</option>
					<option value="2003">2003</option>
					<option value="2004">2004</option>
					<option value="2005">2005</option>
					<option value="2006">2006</option>
					<option value="2007">2007</option>
					<option value="2008">2008</option>
					<option value="2009">2009</option>
					<option value="2010">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
					<option value="2016">2016</option>
				</select>
			</div>
			<div class="col-lg-6">
				<label for="date_of_birth_min_user">
					Até : 
				</label>
				<select name="date_of_birth_max_user">
					<option value="1960">1960</option>
					<option value="1961">1961</option>
					<option value="1962">1962</option>
					<option value="1963">1963</option>
					<option value="1964">1964</option>
					<option value="1965">1965</option>
					<option value="1966">1966</option>
					<option value="1967">1967</option>
					<option value="1968">1968</option>
					<option value="1969">1969</option>
					<option value="1970">1970</option>
					<option value="1971">1971</option>
					<option value="1972">1972</option>
					<option value="1973">1973</option>
					<option value="1974">1974</option>
					<option value="1975">1975</option>
					<option value="1976">1976</option>
					<option value="1977">1977</option>
					<option value="1978">1978</option>
					<option value="1979">1979</option>
					<option value="1981">1981</option>
					<option value="1982">1982</option>
					<option value="1983">1983</option>
					<option value="1984">1984</option>
					<option value="1985">1985</option>
					<option value="1986">1986</option>
					<option value="1987">1987</option>
					<option value="1988">1988</option>
					<option value="1989">1989</option>
					<option value="1990">1990</option>
					<option value="1991">1991</option>
					<option value="1992">1992</option>
					<option value="1993">1993</option>
					<option value="1994">1994</option>
					<option value="1995">1995</option>
					<option value="1996">1996</option>
					<option value="1997">1997</option>
					<option value="1998">1998</option>
					<option value="1999">1999</option>
					<option value="2000">2000</option>
					<option value="2001">2001</option>
					<option value="2002">2002</option>
					<option value="2003">2003</option>
					<option value="2004">2004</option>
					<option value="2005">2005</option>
					<option value="2006">2006</option>
					<option value="2007">2007</option>
					<option value="2008">2008</option>
					<option value="2009">2009</option>
					<option value="2010">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
					<option value="2013">2013</option>
					<option value="2014">2014</option>
					<option value="2015">2015</option>
					<option value="2016">2016</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6">
				<label for="state_user">
					Estado :
				</label>
					<select name="state_user">
						<option value="Acre"/>Acre</option>
						<option value="Alagoas"/>Alagoas</option>
						<option value="Amapá"/>Amapá</option>
						<option value="Amazonas"/>Amazonas</option>
						<option value="Bahia"/>Bahia</option>
						<option value="Ceará"/>Ceará</option>
						<option value="Distrito Federal"/>Distrito Federal</option>
						<option value="Espírito Santo"/>Espírito Santo</option>
						<option value="Goiás"/>Goiás</option>
						<option value="Maranhão"/>Maranhão</option>
						<option value="Mato Grosso"/>Mato Grosso</option>
						<option value="Mato Grosso do Sul"/>Mato Grosso do Sul</option>
						<option value="Minas Gerais"/>Minas Gerais</option>
						<option value="Pará"/>Pará</option> 
						<option value="Paraíba"/>Paraíba</option>
						<option value="Paraná"/>Paraná</option>
						<option value="Pernambuco"/>Pernambuco</option>
						<option value="Piauí"/>Piauí</option>
						<option value="Rio de Janeiro"/>Rio de Janeiro</option>
						<option value="Rio Grande do Norte"/>Rio Grande do Norte</option>
						<option value="Rio Grande do Sul"/>Rio Grande do Sul</option>
						<option value="Rondônia"/>Rondônia</option>
						<option value="Roraima"/>Roraima</option>
						<option value="Santa Catarina"/>Santa Catarina</option>
						<option value="São Paulo"/>São Paulo</option>
						<option value="Sergipe"/>Sergipe</option>
						<option value="Tocantins "/>Tocantins</option>					
					</select>
				</label>
			</div>
			<div class="col-lg-6">
				<label for="position_user">Posição :</label>
				<select name="position_user">
					<option value="" selected="selected">Selecione uma posição</option>
					<option value="Goleiro">Goleiro</option>
					<option value="Zagueiro">Zagueiro</option>
					<option value="Lateral esquerdo">Lateral esquerdo</option>
					<option value="Lateral Direito">Lateral Direito</option>
					<option value="Volante">Volante</option>
					<option value="Ala direito">Ala direito</option>
					<option value="Ala esquerdo">Ala esquerdo</option>
					<option value="Meia armador">Meia armador</option>
					<option value="Meia esquerda">Meia esquerda</option>
					<option value="Meia direita">Meia direita</option>
					<option value="Meia ofensivo">Meia ofensivo</option>
					<option value="Atacante">Atacante</option>
					<option value="Centro-avante">Centro-avante</option>				
				</select>		
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




