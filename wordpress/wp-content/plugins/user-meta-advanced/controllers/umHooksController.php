<?php

if ( ! class_exists( 'umHooksController' ) ) :
class umHooksController {
    
    function __construct() {
        add_action( 'wp_ajax_um_generate_wpml_config',  array( &$this, 'generateWpmlConfig' ) ); 
        
        add_filter( 'user_meta_admin_pages',            array( &$this, 'addAdvancedMenu' ) );
        
        add_filter( 'user_meta_wp_hook',                array( &$this, 'toggleWpHooks' ), 10, 3 );
        add_filter( 'user_meta_execution_page_config',  array( &$this, 'hookViews' ), 10, 2 );
        add_filter( 'user_meta_default_login_form',     array( &$this, 'hookLoginForm' ) );
    }
    
    
    function addAdvancedMenu( $pages ) {
        global $userMeta;
        
          $pages['advanced']      = array(
                'menu_title'    => __( 'Advanced', $userMeta->name ),
                'page_title'    => __( 'Advanced Settings', $userMeta->name ),
                'menu_slug'     => 'user-meta-advanced',
                'position'      => 5,
                'is_free'       => true,
            );
        
        return $pages;
    }
    
    
    function toggleWpHooks( $enable, $hookName, $args ) {
        global $userMeta;
        
        $advanced = $userMeta->getData( 'advanced' );
        
        if ( empty( $advanced['integration']['ump_wp_hooks'] ) )
            return $enable;
        
        return in_array( $hookName, $advanced['integration']['ump_wp_hooks'] ) ? true : false;
    }
    
    
    function hookViews( $configs, $key ) {
        global $userMeta;
        
        $advanced = $userMeta->getData( 'advanced' );
        if ( ! empty( $advanced['views'][ $key ] ) )
            return $advanced['views'][ $key ];
        
        return $configs;
    }
    
    
    function hookLoginForm( $configs ) {
        global $userMeta;
        
        $advanced = $userMeta->getData( 'advanced' );
        if ( ! empty( $advanced['views']['login'] ) )
            return $advanced['views']['login'];
        
        return $configs;
    }
    
    function generateWpmlConfig() {
        global $userMeta;
        $userMeta->verifyNonce();
        
        if ( ! $userMeta->isAdmin() ) return;
        
        if ( ! is_writable( $userMeta->pluginPath ) ) return;
        
        $writer = new XMLWriter();  
        $writer->openURI( $userMeta->pluginPath . '/wpml-config.xml');   
        //$writer->openURI( 'php://output' );   
        //$writer->startDocument('1.0','UTF-8');   
        $writer->setIndent(4); 
        
        $writer->startElement( 'wpml-config' );  
        $writer->startElement( 'admin-texts' );  
        
        /**
         * user_meta_fields
         */
        $fields = $userMeta->getData( 'fields' );
        if ( is_array( $fields ) ) {
            $writer->startElement( 'key' );
            $writer->writeAttribute( 'name', 'user_meta_fields' );
            foreach ( $fields as $id => $field ) {
                $writer->startElement( 'key' );
                $writer->writeAttribute( 'name', $id );
                
                    $this->attWriter( 'field_title', $writer );
                    $this->attWriter( 'description', $writer );
                
                $writer->endElement();
            }
            $writer->endElement();
        }
        
        /**
         * user_meta_forms
         */
        $forms = $userMeta->getData( 'forms' );
        if ( is_array( $forms ) ) {
            $writer->startElement( 'key' );
            $writer->writeAttribute( 'name', 'user_meta_forms' );
            foreach ( $forms as $id => $form ) {
                $writer->startElement( 'key' );
                $writer->writeAttribute( 'name', $id );
                
                    if ( ! empty( $form['fields'] ) && is_array( $form['fields'] ) ) {
                        foreach ( $form['fields'] as $id => $field ) {
                            if ( ! ( ! empty( $field['field_title'] ) || ! empty( $field['description'] ) ) ) continue;
                            
                            $writer->startElement( 'key' );
                            $writer->writeAttribute( 'name', $id );
                            
                                $this->attWriter( 'field_title', $writer );
                                $this->attWriter( 'description', $writer );

                            $writer->endElement();
                        }
                    }
                    
                    $this->attWriter( 'button_title', $writer );
                
                $writer->endElement();
            }
            $writer->endElement();
        }
        
        /**
         * user_meta_emails
         */
        $emails = $userMeta->getData( 'emails' );
        if ( is_array( $emails ) ) {
            $writer->startElement( 'key' );
            $writer->writeAttribute( 'name', 'user_meta_emails' );
            foreach ( $emails as $key1 => $val1 ) {
                $writer->startElement( 'key' );
                $writer->writeAttribute( 'name', $key1 );
                if ( is_array( $val1 ) ) {
                    foreach ( $val1 as $ke2 => $val2 ) {
                        $writer->startElement( 'key' );
                        $writer->writeAttribute( 'name', $ke2 );
                        if ( is_array( $val2 ) ) {
                            foreach ( $val2 as $key3 => $val3 ) {
                                $writer->startElement( 'key' );
                                $writer->writeAttribute( 'name', $key3 );
                                    $this->attWriter( 'subject', $writer );
                                    $this->attWriter( 'body', $writer );
                                $writer->endElement();
                            }
                        }
                        $writer->endElement();
                    }
                }
                $writer->endElement();
            }
            $writer->endElement();
        }
        
        /**
         * user_meta_settings
         */
        $writer->startElement( 'key' );
        $writer->writeAttribute( 'name', 'user_meta_settings' );
        
            $writer->startElement( 'key' );
            $writer->writeAttribute( 'name', 'login' );
                $writer->startElement( 'key' );
                $writer->writeAttribute( 'name', 'loggedin_profile' );
                    $this->attWriter( '*', $writer );
                $writer->endElement();
            $writer->endElement();
            
            $writer->startElement( 'key' );
            $writer->writeAttribute( 'name', 'text' );
                $this->attWriter( '*', $writer );
            $writer->endElement();
            
        $writer->endElement();
        
        $writer->endElement();
        $writer->endElement();

        //$writer->endDocument();   
        $writer->flush(); 
        
        //$userMeta->dump($forms);
        
        echo '<p class="pf_info">Generated.</p>';
        die();   
    }
    
    private function attWriter( $attName, &$writer ) {
        $writer->startElement( 'key' );
        $writer->writeAttribute( 'name', $attName );
        $writer->endElement();
    }

}
endif;
    
