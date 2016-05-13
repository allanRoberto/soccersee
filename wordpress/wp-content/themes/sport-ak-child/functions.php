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
					<option value="1980">1980</option>
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
					<option value="1980">1980</option>
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
					País :
				</label>
					<select name="state_user">
						<option>Afeganistão</option>
						<option>África do Sul</option>
						<option>Akrotiri</option>
						<option>Albânia</option>
						<option>Alemanha</option>
						<option>Andorra</option>
						<option>Angola</option>
						<option>Anguila</option>
						<option>Antárctida</option>
						<option>Antígua e Barbuda</option>
						<option>Antilhas Neerlandesas</option>
						<option>Arábia Saudita</option>
						<option>Arctic Ocean</option>
						<option>Argélia</option>
						<option>Argentina</option>
						<option>Arménia</option>
						<option>Aruba</option>
						<option>Ashmore and Cartier Islands</option>
						<option>Atlantic Ocean</option>
						<option>Austrália</option>
						<option>Áustria</option>
						<option>Azerbaijão</option>
						<option>Baamas</option>
						<option>Bangladeche</option>
						<option>Barbados</option>
						<option>Barém</option>
						<option>Bélgica</option>
						<option>Belize</option>
						<option>Benim</option>
						<option>Bermudas</option>
						<option>Bielorrússia</option>
						<option>Birmânia</option>
						<option>Bolívia</option>
						<option>Bósnia e Herzegovina</option>
						<option>Botsuana</option>
						<option selected>Brasil</option>
						<option>Brunei</option>
						<option>Bulgária</option>
						<option>Burquina Faso</option>
						<option>Burúndi</option>
						<option>Butão</option>
						<option>Cabo Verde</option>
						<option>Camarões</option>
						<option>Camboja</option>
						<option>Canadá</option>
						<option>Catar</option>
						<option>Cazaquistão</option>
						<option>Chade</option>
						<option>Chile</option>
						<option>China</option>
						<option>Chipre</option>
						<option>Clipperton Island</option>
						<option>Colômbia</option>
						<option>Comores</option>
						<option>Congo-Brazzaville</option>
						<option>Congo-Kinshasa</option>
						<option>Coral Sea Islands</option>
						<option>Coreia do Norte</option>
						<option>Coreia do Sul</option>
						<option>Costa do Marfim</option>
						<option>Costa Rica</option>
						<option>Croácia</option>
						<option>Cuba</option>
						<option>Dhekelia</option>
						<option>Dinamarca</option>
						<option>Domínica</option>
						<option>Egipto</option>
						<option>Emiratos Árabes Unidos</option>
						<option>Equador</option>
						<option>Eritreia</option>
						<option>Eslováquia</option>
						<option>Eslovénia</option>
						<option>Espanha</option>
						<option>Estados Unidos</option>
						<option>Estónia</option>
						<option>Etiópia</option>
						<option>Faroé</option>
						<option>Fiji</option>
						<option>Filipinas</option>
						<option>Finlândia</option>
						<option>França</option>
						<option>Gabão</option>
						<option>Gâmbia</option>
						<option>Gana</option>
						<option>Gaza Strip</option>
						<option>Geórgia</option>
						<option>Geórgia do Sul e Sandwich do Sul</option>
						<option>Gibraltar</option>
						<option>Granada</option>
						<option>Grécia</option>
						<option>Gronelândia</option>
						<option>Guame</option>
						<option>Guatemala</option>
						<option>Guernsey</option>
						<option>Guiana</option>
						<option>Guiné</option>
						<option>Guiné Equatorial</option>
						<option>Guiné-Bissau</option>
						<option>Haiti</option>
						<option>Honduras</option>
						<option>Hong Kong</option>
						<option>Hungria</option>
						<option>Iémen</option>
						<option>Ilha Bouvet</option>
						<option>Ilha do Natal</option>
						<option>Ilha Norfolk</option>
						<option>Ilhas Caimão</option>
						<option>Ilhas Cook</option>
						<option>Ilhas dos Cocos</option>
						<option>Ilhas Falkland</option>
						<option>Ilhas Heard e McDonald</option>
						<option>Ilhas Marshall</option>
						<option>Ilhas Salomão</option>
						<option>Ilhas Turcas e Caicos</option>
						<option>Ilhas Virgens Americanas</option>
						<option>Ilhas Virgens Britânicas</option>
						<option>Índia</option>
						<option>Indian Ocean</option>
						<option>Indonésia</option>
						<option>Irão</option>
						<option>Iraque</option>
						<option>Irlanda</option>
						<option>Islândia</option>
						<option>Israel</option>
						<option>Itália</option>
						<option>Jamaica</option>
						<option>Jan Mayen</option>
						<option>Japão</option>
						<option>Jersey</option>
						<option>Jibuti</option>
						<option>Jordânia</option>
						<option>Kuwait</option>
						<option>Laos</option>
						<option>Lesoto</option>
						<option>Letónia</option>
						<option>Líbano</option>
						<option>Libéria</option>
						<option>Líbia</option>
						<option>Listenstaine</option>
						<option>Lituânia</option>
						<option>Luxemburgo</option>
						<option>Macau</option>
						<option>Macedónia</option>
						<option>Madagáscar</option>
						<option>Malásia</option>
						<option>Malávi</option>
						<option>Maldivas</option>
						<option>Mali</option>
						<option>Malta</option>
						<option>Man, Isle of</option>
						<option>Marianas do Norte</option>
						<option>Marrocos</option>
						<option>Maurícia</option>
						<option>Mauritânia</option>
						<option>Mayotte</option>
						<option>México</option>
						<option>Micronésia</option>
						<option>Moçambique</option>
						<option>Moldávia</option>
						<option>Mónaco</option>
						<option>Mongólia</option>
						<option>Monserrate</option>
						<option>Montenegro</option>
						<option>Mundo</option>
						<option>Namíbia</option>
						<option>Nauru</option>
						<option>Navassa Island</option>
						<option>Nepal</option>
						<option>Nicarágua</option>
						<option>Níger</option>
						<option>Nigéria</option>
						<option>Niue</option>
						<option>Noruega</option>
						<option>Nova Caledónia</option>
						<option>Nova Zelândia</option>
						<option>Omã</option>
						<option>Pacific Ocean</option>
						<option>Países Baixos</option>
						<option>Palau</option>
						<option>Panamá</option>
						<option>Papua-Nova Guiné</option>
						<option>Paquistão</option>
						<option>Paracel Islands</option>
						<option>Paraguai</option>
						<option>Peru</option>
						<option>Pitcairn</option>
						<option>Polinésia Francesa</option>
						<option>Polónia</option>
						<option>Porto Rico</option>
						<option>Portugal</option>
						<option>Quénia</option>
						<option>Quirguizistão</option>
						<option>Quiribáti</option>
						<option>Reino Unido</option>
						<option>República Centro-Africana</option>
						<option>República Checa</option>
						<option>República Dominicana</option>
						<option>Roménia</option>
						<option>Ruanda</option>
						<option>Rússia</option>
						<option>Salvador</option>
						<option>Samoa</option>
						<option>Samoa Americana</option>
						<option>Santa Helena</option>
						<option>Santa Lúcia</option>
						<option>São Cristóvão e Neves</option>
						<option>São Marinho</option>
						<option>São Pedro e Miquelon</option>
						<option>São Tomé e Príncipe</option>
						<option>São Vicente e Granadinas</option>
						<option>Sara Ocidental</option>
						<option>Seicheles</option>
						<option>Senegal</option>
						<option>Serra Leoa</option>
						<option>Sérvia</option>
						<option>Singapura</option>
						<option>Síria</option>
						<option>Somália</option>
						<option>Southern Ocean</option>
						<option>Spratly Islands</option>
						<option>Sri Lanca</option>
						<option>Suazilândia</option>
						<option>Sudão</option>
						<option>Suécia</option>
						<option>Suíça</option>
						<option>Suriname</option>
						<option>Svalbard e Jan Mayen</option>
						<option>Tailândia</option>
						<option>Taiwan</option>
						<option>Tajiquistão</option>
						<option>Tanzânia</option>
						<option>Território Britânico do Oceano Índico</option>
						<option>Territórios Austrais Franceses</option>
						<option>Timor Leste</option>
						<option>Togo</option>
						<option>Tokelau</option>
						<option>Tonga</option>
						<option>Trindade e Tobago</option>
						<option>Tunísia</option>
						<option>Turquemenistão</option>
						<option>Turquia</option>
						<option>Tuvalu</option>
						<option>Ucrânia</option>
						<option>Uganda</option>
						<option>União Europeia</option>
						<option>Uruguai</option>
						<option>Usbequistão</option>
						<option>Vanuatu</option>
						<option>Vaticano</option>
						<option>Venezuela</option>
						<option>Vietname</option>
						<option>Wake Island</option>
						<option>Wallis e Futuna</option>
						<option>West Bank</option>
						<option>Zâmbia</option>
						<option>Zimbabué</option>					
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




