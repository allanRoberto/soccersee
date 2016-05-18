<?php
global $userMeta; 
// Expected: $advanced
?>

<div class="wrap">
    <?php screen_icon( 'options-general' ); ?>
    <h2><?php _e( 'Advanced Settings', $userMeta->name ); ?></h2>   
    <?php do_action( 'um_admin_notice' ); ?>
    <div id="dashboard-widgets-wrap">
        <div class="metabox-holder">
            <div id="um_admin_content">
                
                <form method="post" id="um_advanced_settings" onsubmit="pfAjaxRequest(this); return false;" />
                <div id="um_advanced_tabs">
                    <ul>
                        <li><a href="#um_advanced_tab_integration"><?php _e( 'Plugins Integration', 'user-meta-advanced' ) ?></a></li>     
                        <li><a href="#um_advanced_tab_views"><?php _e( 'Views', 'user-meta-advanced' ) ?></a></li>
                    </ul>  
                    
                    <div id="um_advanced_tab_integration">
                        <?php
                        echo $html = $userMeta->renderPro( 'integration', array(
                            'integration' => ! empty( $advanced['integration'] ) ? $advanced['integration'] : array(),
                        ), 'advanced', true );
                        ?>
                    </div>
                    
                    <div id="um_advanced_tab_views">
                        <?php
                        echo $html = $userMeta->renderPro( 'viewsInject', array(
                            'views' => ! empty( $advanced['views'] ) ? $advanced['views'] : array(),
                        ), 'advanced', true );
                        ?>
                    </div>
                    
                </div>
                <?php

                echo $userMeta->methodName( 'saveAdvancedSettings', true );

                echo $userMeta->createInput( "save_advanced", "submit", array(
                    "value" => __( "Save Changes", $userMeta->name ),
                    "id"    => "update_settings",
                    "class" => "button-primary",
                    "enclose"   => "p",
                ) ); 

                ?>
                </form>  
                

                
            </div>
            
            <div id="um_admin_sidebar">                            
                <?php
                
                $html = 'This add-on allows more advanced settings on User Meta Pro.';
                $html .= "<p><center><a class=\"button-primary\" href=\"" . $userMeta->website .  "\">". __( 'Visit Plugin Site', $userMeta->name ) ."</a></center></p>";
                
                echo $userMeta->metaBox( __( 'User Meta Pro Advanced', $userMeta->name ),  $html, false, true );               

                ?>
            </div>
        </div>
    </div>     
</div>

<script type="text/javascript">
jQuery(function() {
    jQuery( "#um_advanced_tabs" ).tabs();
    jQuery( "#um_advanced_view_tab" ).tabs();
    jQuery('select').multipleSelect();
});
</script>
