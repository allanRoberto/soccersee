<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !class_exists( 'FME_Checkout_Fields_Attributes_Admin' ) ) { 

	class FME_Checkout_Fields_Attributes_Admin extends FME_Checkout_Fields_Attributes {


		public function __construct() {
			add_action( 'wp_loaded', array( $this, 'admin_init' ) );
			$this->module_settings = $this->get_module_settings();
			apply_filters( 'site_url', $url, $path, $orig_scheme, $blog_id );
			add_action('wp_ajax_update_additional_sortorder', array($this, 'update_additional_sortorder')); 
			add_action('wp_ajax_insert_additional_field', array($this, 'insert_additional_field')); 
			add_action('wp_ajax_del_additional_field', array($this, 'del_additional_field'));
			
			add_action('wp_ajax_save_all_data', array($this, 'save_all_data')); 
			

	       
		}

		public function admin_init() {
			add_action( 'admin_menu', array( $this, 'create_admin_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );	
		}

		public function admin_scripts() {	
            
        	wp_enqueue_style( 'fmecfa-admin-css', plugins_url( '/css/fmecfa_style.css', __FILE__ ), false );
        	wp_enqueue_script( 'jquery-ui-draggable');
        	wp_enqueue_script( 'jquery-ui-dropable');
        	wp_enqueue_script( 'jquery-ui-sortable');
        	
        }

		public function create_admin_menu() {	
			add_menu_page('Checkout Fields Attributes', __( 'Checkout Fields Attributes', 'fmecfa' ), apply_filters( 'fmecfa_capability', 'manage_options' ), 'fme-checkout-fields-attributes', array( $this, 'fmecfa_chekout_fields_module' ) ,plugins_url( 'images/fma.jpg', dirname( __FILE__ ) ), apply_filters( 'fmecfa_menu_position', 7 ) );
			add_submenu_page( 'fme-checkout-fields-attributes', __( 'Settings', 'fmecfa' ), __( 'Settings', 'fmecfa' ), 'manage_options', 'fmecfa_settings', array( $this, 'fme_mdoule_settings' ) );	

	        register_setting( 'fmecfa_settings', 'fmecfa_settings', array( $this, 'fmecfa_settings' ) );

	    }

	    public function fme_mdoule_settings() {
			require  FMECFA_PLUGIN_DIR . 'admin/view/settings.php';
		}

		function fmecfa_chekout_fields_module()
	    {
	    	require_once( FMECFA_PLUGIN_DIR . 'admin/view/view.php' );
	    }

		public function fmecfa_settings() { 

			$def_data = $this->get_module_default_settings();

			

			if ($_POST['fmecfa_module']['additional_title'] )  {
				$output['additional_title'] = sanitize_text_field($_POST['fmecfa_module']['additional_title']);
			} else {
				$output['additional_title'] = $def_data['additional_title'];
			}

			

			return $output;

		}


	   
        public function get_additional_fields() {
            
             global $wpdb;
             
             $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->fmecfa_fields." WHERE field_type!='' AND type = 'additional' ORDER BY length(sort_order), sort_order", ARRAY_A));      

             return $result;
        }

        


		function update_additional_sortorder()
		{
			global $wpdb;
			$ids = $_POST['ids'];

			
				
				$counter = 1;
				foreach ($ids as $id) {
					$did = intval($id);
					$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->fmecfa_fields." 
                    SET 
                    sort_order = '".$counter."'
                    WHERE field_id = ".$did, $did));
					
					$counter = $counter + 1;	
				}	
			

		}


		


		function insert_additional_field()
		{
			global $wpdb;
			$last1 = $wpdb->get_row("SHOW TABLE STATUS LIKE '$wpdb->fmecfa_fields'");
        	$a = ($last1->Auto_increment);
			$fieldtype = sanitize_text_field($_POST['fieldtype']);
			$type = sanitize_text_field($_POST['type']);
			$label = sanitize_text_field($_POST['label']);
			$name = 'additional_field_'.$a;
			$mode = sanitize_text_field($_POST['mode']);
			if($fieldtype!='' && $type!='' && $label!='') {
				$wpdb->query($wpdb->prepare( 
	            "
	            INSERT INTO $wpdb->fmecfa_fields
	            (field_name, field_label, field_type, type, field_mode)
	            VALUES (%s, %s, %s, %s, %s)
	            ",
	            $name,
	            $label, 
	            $fieldtype,
	            $type,
	            $mode
	            
	            
	            ) );
			}
			
			$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '$wpdb->fmecfa_fields'");
        	echo json_encode(($last->Auto_increment)-1);
			exit();


		}


		

		function del_additional_field()
		{
			$field_id = intval($_POST['field_id']);
			global $wpdb;
			$wpdb->query( $wpdb->prepare( "DELETE FROM ".$wpdb->fmecfa_fields . " WHERE field_id = %d", $field_id ) );
			die();
			return true;
		}

		function save_all_data()
		{ 
			global $wpdb;

			$combined_array1 = array_map(function($a, $b, $c) { return $a.'-_-'.$b.'-_-'.$c; }, $_POST['option_field_ids'], $_POST['option_value'], $_POST['option_text']);
			$wpdb->query( $wpdb->prepare( "DELETE FROM ".$wpdb->fmecfa_meta, $data[0] ) );
			foreach ($combined_array1 as $value) {

				$data = explode('-_-', $value);

			    $wpdb->query($wpdb->prepare( 
	            "
	            INSERT INTO $wpdb->fmecfa_meta
	            (field_id, meta_key, meta_value)
	            VALUES (%s, %s, %s)
	            ",
	            intval($data[0]),
	            sanitize_text_field($data[1]), 
	            sanitize_text_field($data[2])
	            
	            ) );

			}

			$combined_array = array_map(function($a, $b, $c, $d, $e, $f) { return $a.'-_-'.$b.'-_-'.$c.'-_-'.$d.'-_-'.$e.'-_-'.$f; }, $_POST['fieldids'], $_POST['fieldlabel'], $_POST['fieldplaceholder'], $_POST['fieldrequired'], $_POST['fieldhidden'], $_POST['fieldwidth']);
			//echo "<pre>".print_r($combined_array)."</pre>";
			foreach ($combined_array as $value) {
				
				$data = explode('-_-', $value);
				$field_id = intval($data[0]);
				$field_label = sanitize_text_field($data[1]);
				$field_placeholder = sanitize_text_field($data[2]);
				$field_required = sanitize_text_field($data[3]);
				$field_hide = sanitize_text_field($data[4]);
				$field_width = sanitize_text_field($data[5]);

				
				
				$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->fmecfa_fields." 
                    SET 
                    field_label = '".$field_label."',
                    field_placeholder = '".$field_placeholder."',
                    is_required = '".$field_required."',
                    is_hide = '".$field_hide."',
                    width = '".$field_width."'
                    WHERE field_id = ".$field_id, $field_id));
			}

			die();
			return true;
		}


		public function getOptions($id)
		{
			global $wpdb;
             
             $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->fmecfa_meta." WHERE field_id = ".$id, ARRAY_A));      

             return $result;
		}


		




		function getSelectOptions($id)
		{
			global $wpdb;
             
            $result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->fmecfa_meta." WHERE field_id = ".$id, ARRAY_A));      
            return $result;

		}



		

		



	}


	new FME_Checkout_Fields_Attributes_Admin();
}

?>