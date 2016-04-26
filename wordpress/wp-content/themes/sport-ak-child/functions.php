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
					País :
				</label>
					<select name="state_user">
						<option value"">Afeganistão</option>
						<option value"">África do Sul</option>
						<option value"">Akrotiri</option>
						<option value"">Albânia</option>
						<option value"">Alemanha</option>
						<option value"">Andorra</option>
						<option value"">Angola</option>
						<option value"">Anguila</option>
						<option value"">Antárctida</option>
						<option value"">Antígua e Barbuda</option>
						<option value"">Antilhas Neerlandesas</option>
						<option value"">Arábia Saudita</option>
						<option value"">Arctic Ocean</option>
						<option value"">Argélia</option>
						<option value"">Argentina</option>
						<option value"">Arménia</option>
						<option value"">Aruba</option>
						<option value"">Ashmore and Cartier Islands</option>
						<option value"">Atlantic Ocean</option>
						<option value"">Austrália</option>
						<option value"">Áustria</option>
						<option value"">Azerbaijão</option>
						<option value"">Baamas</option>
						<option value"">Bangladeche</option>
						<option value"">Barbados</option>
						<option value"">Barém</option>
						<option value"">Bélgica</option>
						<option value"">Belize</option>
						<option value"">Benim</option>
						<option value"">Bermudas</option>
						<option value"">Bielorrússia</option>
						<option value"">Birmânia</option>
						<option value"">Bolívia</option>
						<option value"">Bósnia e Herzegovina</option>
						<option value"">Botsuana</option>
						<option value"" selected>Brasil</option>
						<option value"">Brunei</option>
						<option value"">Bulgária</option>
						<option value"">Burquina Faso</option>
						<option value"">Burúndi</option>
						<option value"">Butão</option>
						<option value"">Cabo Verde</option>
						<option value"">Camarões</option>
						<option value"">Camboja</option>
						<option value"">Canadá</option>
						<option value"">Catar</option>
						<option value"">Cazaquistão</option>
						<option value"">Chade</option>
						<option value"">Chile</option>
						<option value"">China</option>
						<option value"">Chipre</option>
						<option value"">Clipperton Island</option>
						<option value"">Colômbia</option>
						<option value"">Comores</option>
						<option value"">Congo-Brazzaville</option>
						<option value"">Congo-Kinshasa</option>
						<option value"">Coral Sea Islands</option>
						<option value"">Coreia do Norte</option>
						<option value"">Coreia do Sul</option>
						<option value"">Costa do Marfim</option>
						<option value"">Costa Rica</option>
						<option value"">Croácia</option>
						<option value"">Cuba</option>
						<option value"">Dhekelia</option>
						<option value"">Dinamarca</option>
						<option value"">Domínica</option>
						<option value"">Egipto</option>
						<option value"">Emiratos Árabes Unidos</option>
						<option value"">Equador</option>
						<option value"">Eritreia</option>
						<option value"">Eslováquia</option>
						<option value"">Eslovénia</option>
						<option value"">Espanha</option>
						<option value"">Estados Unidos</option>
						<option value"">Estónia</option>
						<option value"">Etiópia</option>
						<option value"">Faroé</option>
						<option value"">Fiji</option>
						<option value"">Filipinas</option>
						<option value"">Finlândia</option>
						<option value"">França</option>
						<option value"">Gabão</option>
						<option value"">Gâmbia</option>
						<option value"">Gana</option>
						<option value"">Gaza Strip</option>
						<option value"">Geórgia</option>
						<option value"">Geórgia do Sul e Sandwich do Sul</option>
						<option value"">Gibraltar</option>
						<option value"">Granada</option>
						<option value"">Grécia</option>
						<option value"">Gronelândia</option>
						<option value"">Guame</option>
						<option value"">Guatemala</option>
						<option value"">Guernsey</option>
						<option value"">Guiana</option>
						<option value"">Guiné</option>
						<option value"">Guiné Equatorial</option>
						<option value"">Guiné-Bissau</option>
						<option value"">Haiti</option>
						<option value"">Honduras</option>
						<option value"">Hong Kong</option>
						<option value"">Hungria</option>
						<option value"">Iémen</option>
						<option value"">Ilha Bouvet</option>
						<option value"">Ilha do Natal</option>
						<option value"">Ilha Norfolk</option>
						<option value"">Ilhas Caimão</option>
						<option value"">Ilhas Cook</option>
						<option value"">Ilhas dos Cocos</option>
						<option value"">Ilhas Falkland</option>
						<option value"">Ilhas Heard e McDonald</option>
						<option value"">Ilhas Marshall</option>
						<option value"">Ilhas Salomão</option>
						<option value"">Ilhas Turcas e Caicos</option>
						<option value"">Ilhas Virgens Americanas</option>
						<option value"">Ilhas Virgens Britânicas</option>
						<option value"">Índia</option>
						<option value"">Indian Ocean</option>
						<option value"">Indonésia</option>
						<option value"">Irão</option>
						<option value"">Iraque</option>
						<option value"">Irlanda</option>
						<option value"">Islândia</option>
						<option value"">Israel</option>
						<option value"">Itália</option>
						<option value"">Jamaica</option>
						<option value"">Jan Mayen</option>
						<option value"">Japão</option>
						<option value"">Jersey</option>
						<option value"">Jibuti</option>
						<option value"">Jordânia</option>
						<option value"">Kuwait</option>
						<option value"">Laos</option>
						<option value"">Lesoto</option>
						<option value"">Letónia</option>
						<option value"">Líbano</option>
						<option value"">Libéria</option>
						<option value"">Líbia</option>
						<option value"">Listenstaine</option>
						<option value"">Lituânia</option>
						<option value"">Luxemburgo</option>
						<option value"">Macau</option>
						<option value"">Macedónia</option>
						<option value"">Madagáscar</option>
						<option value"">Malásia</option>
						<option value"">Malávi</option>
						<option value"">Maldivas</option>
						<option value"">Mali</option>
						<option value"">Malta</option>
						<option value"">Man, Isle of</option>
						<option value"">Marianas do Norte</option>
						<option value"">Marrocos</option>
						<option value"">Maurícia</option>
						<option value"">Mauritânia</option>
						<option value"">Mayotte</option>
						<option value"">México</option>
						<option value"">Micronésia</option>
						<option value"">Moçambique</option>
						<option value"">Moldávia</option>
						<option value"">Mónaco</option>
						<option value"">Mongólia</option>
						<option value"">Monserrate</option>
						<option value"">Montenegro</option>
						<option value"">Mundo</option>
						<option value"">Namíbia</option>
						<option value"">Nauru</option>
						<option value"">Navassa Island</option>
						<option value"">Nepal</option>
						<option value"">Nicarágua</option>
						<option value"">Níger</option>
						<option value"">Nigéria</option>
						<option value"">Niue</option>
						<option value"">Noruega</option>
						<option value"">Nova Caledónia</option>
						<option value"">Nova Zelândia</option>
						<option value"">Omã</option>
						<option value"">Pacific Ocean</option>
						<option value"">Países Baixos</option>
						<option value"">Palau</option>
						<option value"">Panamá</option>
						<option value"">Papua-Nova Guiné</option>
						<option value"">Paquistão</option>
						<option value"">Paracel Islands</option>
						<option value"">Paraguai</option>
						<option value"">Peru</option>
						<option value"">Pitcairn</option>
						<option value"">Polinésia Francesa</option>
						<option value"">Polónia</option>
						<option value"">Porto Rico</option>
						<option value"">Portugal</option>
						<option value"">Quénia</option>
						<option value"">Quirguizistão</option>
						<option value"">Quiribáti</option>
						<option value"">Reino Unido</option>
						<option value"">República Centro-Africana</option>
						<option value"">República Checa</option>
						<option value"">República Dominicana</option>
						<option value"">Roménia</option>
						<option value"">Ruanda</option>
						<option value"">Rússia</option>
						<option value"">Salvador</option>
						<option value"">Samoa</option>
						<option value"">Samoa Americana</option>
						<option value"">Santa Helena</option>
						<option value"">Santa Lúcia</option>
						<option value"">São Cristóvão e Neves</option>
						<option value"">São Marinho</option>
						<option value"">São Pedro e Miquelon</option>
						<option value"">São Tomé e Príncipe</option>
						<option value"">São Vicente e Granadinas</option>
						<option value"">Sara Ocidental</option>
						<option value"">Seicheles</option>
						<option value"">Senegal</option>
						<option value"">Serra Leoa</option>
						<option value"">Sérvia</option>
						<option value"">Singapura</option>
						<option value"">Síria</option>
						<option value"">Somália</option>
						<option value"">Southern Ocean</option>
						<option value"">Spratly Islands</option>
						<option value"">Sri Lanca</option>
						<option value"">Suazilândia</option>
						<option value"">Sudão</option>
						<option value"">Suécia</option>
						<option value"">Suíça</option>
						<option value"">Suriname</option>
						<option value"">Svalbard e Jan Mayen</option>
						<option value"">Tailândia</option>
						<option value"">Taiwan</option>
						<option value"">Tajiquistão</option>
						<option value"">Tanzânia</option>
						<option value"">Território Britânico do Oceano Índico</option>
						<option value"">Territórios Austrais Franceses</option>
						<option value"">Timor Leste</option>
						<option value"">Togo</option>
						<option value"">Tokelau</option>
						<option value"">Tonga</option>
						<option value"">Trindade e Tobago</option>
						<option value"">Tunísia</option>
						<option value"">Turquemenistão</option>
						<option value"">Turquia</option>
						<option value"">Tuvalu</option>
						<option value"">Ucrânia</option>
						<option value"">Uganda</option>
						<option value"">União Europeia</option>
						<option value"">Uruguai</option>
						<option value"">Usbequistão</option>
						<option value"">Vanuatu</option>
						<option value"">Vaticano</option>
						<option value"">Venezuela</option>
						<option value"">Vietname</option>
						<option value"">Wake Island</option>
						<option value"">Wallis e Futuna</option>
						<option value"">West Bank</option>
						<option value"">Zâmbia</option>
						<option value"">Zimbabué</option>					
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




