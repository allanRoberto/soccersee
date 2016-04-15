<?php
/*
Plugin Name: User Meta Advanced
Plugin URI: http://wordpress.org/plugins/user-meta-advanced/
Description: User Meta Pro add-on for advanced settings.
Author: Khaled Hossain
Version: 1.0.1
Author URI: http://khaledsaikat.com
*/

if ( realpath( __FILE__ ) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    exit( 'Please don\'t access this file directly.' );
}

class userMetaAdvanced {
    
    function __construct() {
        $this->callHooks();
    }
    
    
    function callHooks() {
        add_action( 'plugins_loaded',           array( $this, 'loadTextDomain' ) ); 
        add_filter( 'user_meta_load_extension', array( $this, 'loadExtension' ) );
        add_action( 'admin_menu',               array( $this, 'pluginActionLink' ) );
    }
    
    
    function loadTextDomain() {
        load_plugin_textdomain( 'user-meta-advanced', false,  dirname( __FILE__ ) . '/helper/languages' );
    }
    
    
    function loadExtension( $extensions ){
        $extensions[ 'advanced' ]   = dirname( __FILE__ );
        return $extensions;
    }
    
    
    function pluginActionLink() {
        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, '_pluginSettingsMenu' ) );
    }
    
    
    function _pluginSettingsMenu( $links ) {
        $settings_link = '<a href="'. get_admin_url(null, 'admin.php?page=user-meta-advanced') .'">Settings</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }
       
}

$userMetaAdvanced = new userMetaAdvanced;