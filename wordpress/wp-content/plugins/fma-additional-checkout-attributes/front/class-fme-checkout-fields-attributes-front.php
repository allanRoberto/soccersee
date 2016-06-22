<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !class_exists( 'FME_Checkout_Fields_Attributes_Front' ) ) { 

	class FME_Checkout_Fields_Attributes_Front extends FME_Checkout_Fields_Attributes {

		public function __construct() {
			add_action( 'wp_loaded', array( $this, 'front_scripts' ) );
			$this->module_settings = $this->get_module_settings();
			add_action( 'woocommerce_after_order_notes', array($this, 'fme_additional_checkout_fields' ));
			add_action('woocommerce_checkout_process', array($this, 'fme_additional_checkout_field_process'));
			add_action('woocommerce_checkout_update_order_meta', array($this, 'fme_additional_checkout_field_update_order_meta' ));
			add_action( 'woocommerce_thankyou', array($this, 'fme_display_order_additioanl_data'), 20 );
			add_action( 'woocommerce_view_order', array($this, 'fme_display_order_additioanl_data'), 20 );
			
	       
	       add_action('wp_ajax_fme_additional_checkout_field_update_order_meta', array($this, 'fme_additional_checkout_field_update_order_meta')); 
		}

		

		public function front_scripts() {	
            
            

        	
        	wp_enqueue_script( 'jquery-ui');
        	wp_enqueue_script( 'fmecfa-front-jsssssss', plugins_url( '/js/script.js', __FILE__ ), array('jquery'), false );
        	wp_enqueue_style( 'fmecfa-front-css', plugins_url( '/css/fmecfa_style_front.css', __FILE__ ), false );
        	wp_enqueue_style( 'jquery-ui-css');
        	
        		
        }



		

		function getSelectOptions($id)
		{
			global $wpdb;
             
            $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->fmecfa_meta." WHERE field_id = ".$id, ARRAY_A));      
            return $result;

		}

		function fme_additional_checkout_fields($checkout)
		{
			$add_fields = $this->getAdditionlFields();
			if($add_fields!='') {
				echo '<div class="fme_additional_checkout_field"><h3>' . esc_html__($this->module_settings['additional_title']) .'</h3>';
			}
			
			//print_r($add_fields);
			foreach ($add_fields as $bfield) {
				if($bfield->is_hide == 0) {

					if($bfield->field_type == 'select' || $bfield->field_type == 'radioselect' || $bfield->field_type == 'multiselect') {
				   		$opts = $this->getSelectOptions($bfield->field_id);
				   		foreach ($opts as $opt) {
				   			
				   			$options[$opt->meta_key] = $opt->meta_value;
				   		}
			   		}



			   		if($bfield->field_type == 'datepicker') {

			   			woocommerce_form_field( $bfield->field_name, array(

					   'type' => 'text',
					   'label'      => esc_html__($bfield->field_label, 'woocommerce'),
					   'placeholder'   => _x($bfield->field_placeholder, 'placeholder', 'woocommerce'),
					   'required'      => ($bfield->is_required == 0 ? false : true),
					   'input_class'   => array('input-text datepick'),
					   'class'         => array(($bfield->width == 'full' ? 'full' : 'half')),
					   'clear'     => false,
					       ), $checkout->get_value( $bfield->field_name ));

			   		} else if($bfield->field_type == 'timepicker') {

			   			woocommerce_form_field( $bfield->field_name, array(

					   'type' => 'text',
					   'label'      => esc_html__($bfield->field_label, 'woocommerce'),
					   'placeholder'   => _x($bfield->field_placeholder, 'placeholder', 'woocommerce'),
					   'required'      => ($bfield->is_required == 0 ? false : true),
					   'input_class'   => array('input-text timepick'),
					   'class'         => array(($bfield->width == 'full' ? 'full' : 'half')),
					   'clear'     => false,
					       ), $checkout->get_value( $bfield->field_name ));

			   		}

			   		else if($bfield->field_type == 'multiselect') {
				   		
				   		woocommerce_form_field( $bfield->field_name.'[]', array(

					   'type' => $bfield->field_type,
					   'label'      => esc_html__($bfield->field_label, 'woocommerce'),
					   'placeholder'   => _x($bfield->field_placeholder, 'placeholder', 'woocommerce'),
					   'required'      => ($bfield->is_required == 0 ? false : true),
					   'class'         => array(($bfield->width == 'full' ? 'full' : 'half')),
					   'clear'     => false,
					   'options' => $options,
					       ), $checkout->get_value( $bfield->field_name ));
			   		}


			   		else if($bfield->field_type == 'radioselect') {
				   		
				   		woocommerce_form_field( $bfield->field_name, array(

					   'type' => 'radio',
					   'label'      => esc_html__($bfield->field_label, 'woocommerce'),
					   'placeholder'   => _x($bfield->field_placeholder, 'placeholder', 'woocommerce'),
					   'required'      => ($bfield->is_required == 0 ? false : true),
					   'class'         => array(($bfield->width == 'full' ? 'full' : 'half')),
					   'clear'     => false,
					   'options' => $options,
					       ), $checkout->get_value( $bfield->field_name ));
			   		}


			   		
			   		 else {

						woocommerce_form_field( $bfield->field_name, array(

					   'type' => $bfield->field_type,
					   'label'      => esc_html__($bfield->field_label, 'woocommerce'),
					   'placeholder'   => _x($bfield->field_placeholder, 'placeholder', 'woocommerce'),
					   'required'      => ($bfield->is_required == 0 ? false : true),
					   'class'         => array(($bfield->width == 'full' ? 'full' : 'half')),
					   'clear'     => false,
					   'options' => $options,
					       ), $checkout->get_value( $bfield->field_name ));
					}
					
					}
			}
			echo "</div>";
		}


		function getAdditionlFields()
		{
			global $wpdb;
             
            $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->fmecfa_fields." WHERE field_type!='' AND type = 'additional' ORDER BY length(sort_order), sort_order", ARRAY_A));      
            return $result;
		}

		function fme_additional_checkout_field_process()
		{ 
			foreach (sanitize_text_field($_POST) as $key => $value) { 
				$er = $this->getRequired($key);
				if ( sanitize_text_field($_POST[$key]) == '' && $er->is_required == 1 ) {
       				wc_add_notice( __( $er->field_label.' is a required field' ), 'error' );
       			}
			}
		}

		function getRequired($name)
		{
			global $wpdb;

           	$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".$wpdb->fmecfa_fields." WHERE field_mode!='default' AND field_name = '".$name."'", ARRAY_A));      
            return $result;
		}

		function getAdditional($name)
		{
			global $wpdb;

           	$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".$wpdb->fmecfa_fields." WHERE field_name = '".$name."'", ARRAY_A));      
            return $result;
		}

		function getAdditionalBylabel($name)
		{
			global $wpdb;

           	$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".$wpdb->fmecfa_fields." WHERE field_label = '".$name."'", ARRAY_A));      
            return $result;
		}

		function fme_additional_checkout_field_update_order_meta($order_id)
		{
			
			foreach (sanitize_text_field($_POST) as $key => $value) {
				$er = $this->getAdditional($key);
				if ($er->field_mode == 'additional_additional' ) {
					if($er->field_type == 'multiselect')
					{ 	$prefix = '';
						foreach ($_POST[$key] as $value) {
							$multi .= $prefix.$value;
    						$prefix = ', ';
						}
						
						update_post_meta( $order_id, $er->field_label, sanitize_text_field($multi) );
						
					} else {

						update_post_meta( $order_id, $er->field_label, sanitize_text_field($_POST[$key]) );
					}

					
				}
					

			}
		}

		

		function fme_display_order_additioanl_data($order_id) { ?> 

			<h2><?php esc_html__($this->module_settings['additional_title']); ?></h2>
		    <table class="shop_table shop_table_responsive additional_info">
		        <tbody>
		        <?php 
		        	$add_fields = $this->getAdditionlFields();
		        	foreach ($add_fields as $add_field) {
		        	$check = get_post_meta( $order_id, $add_field->field_label, true );
		        	$label = $this->getAdditionalBylabel($add_field->field_label);
		        	if($check!='') {
		        		$value = get_post_meta( $order_id, $add_field->field_label, true )
		        ?>
		            <tr>
		                <th><?php esc_html__( $add_field->field_label.':' ); ?></th>
		                <td>
		                	<?php 
		                		if($label->field_type=='checkbox' && $value==1) {
		                			echo "Yes";
		                		} else if($label->field_type=='checkbox' && $value==0) {
		                			echo "No";
		                		}
		                		else {
		                			echo esc_html($value);
		                		}
		                	?>
		                </td>
		            </tr>

		        <?php } } ?>
		            
		        </tbody>
		    </table>

		<?php }

			

				

				function fme_checkout_field_order_meta_keys($keys)
				{
					$add_fields = getAdditional();
					foreach ($add_fields as $add_field) {
						$keys[$add_field->field_label] = $add_field->field_label;
					}

					
					
				    return $keys;
				}

				



	}


	new FME_Checkout_Fields_Attributes_Front();
}

?>