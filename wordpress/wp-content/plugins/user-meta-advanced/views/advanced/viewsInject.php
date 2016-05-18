<?php
global $userMeta;
// Expected: (array) $views

extract( $views );
// Expected: $login, $lostpassword $resetpass

$loginInputs = array(
    'group_1'           => 'group',
    'form_id'           => null,
    'form_class'        => null,
    'before_form'       => null,
    'after_form'        => null,
    
    'group_2'           => 'group',
    'login_label'       => null,
    'login_placeholder' => null,
    'login_id'          => null,
    'login_class'       => null,
    'login_label_class' => null,
    
    'group_3'           => 'group',
    'pass_label'        => null,
    'pass_placeholder'  => null,
    'pass_id'           => null,
    'pass_class'        => null,
    'pass_label_class'  => null,
    
    'group_4'           => 'group',
    'remember_label'    => null,
    'remember_id'       => null,
    'remember_class'    => null,
    
    'group_5'           => 'group',
    'button_value'      => null,
    'button_id'         => null,
    'button_class'      => null,
    'before_button'     => null,
    'after_button'      => null,
    
    'group_6'           => 'group',
    'registration_link_class'   => null,
);

$lostpassInputs = array(
    'group_1'           => 'group',
    'title'             => null,
    'form_id'           => null,
    'form_class'        => null,
    'before_form'       => null,
    'after_form'        => null,
    'before_div'        => null,
    'after_div'         => null,
    
    'group_2'           => 'group',
    'intro_text'        => null,
    
    'group_3'           => 'group',
    'input_label'       => null,
    'placeholder'       => null,
    'input_id'          => null,
    'input_class'       => null,
    'input_label_class' => null,
    
    'group_4'           => 'group',
    'button_value'      => null,
    'button_id'         => null,
    'button_class'      => null,
    'before_button'     => null,
    'after_button'      => null,
);

$resetpassInputs = array(
    'group_1'           => 'group',
    'title'             => null,
    'form_id'           => null,
    'form_class'        => null,
    'before_form'       => null,
    'after_form'        => null,
    
    'group_2'           => 'group',
    'heading'           => null,
    'intro_text'        => null,
    
    'group_3'           => 'group',
    'pass1_label'       => null,
    'pass1_placeholder' => null,
    'pass1_id'          => null,
    'pass1_class'       => null,
    'pass1_label_class' => null,
    
    'group_4'           => 'group',
    'pass2_label'       => null,
    'pass2_placeholder' => null,
    'pass2_id'          => null,
    'pass2_class'       => null,
    'pass2_label_class' => null,
    
    'group_5'           => 'group',
    'button_value'      => null,
    'button_id'         => null,
    'button_class'      => null,
    'before_button'     => null,
    'after_button'      => null,
);

?>

<h4>Here you can apply more personalization on view pages.</h4>
<p>(Leave blank to use default)</p>

<div id="um_advanced_view_tab">
    <ul>
        <li><a href="#um_advanced_view_login"><?php _e( 'Login', 'user-meta-advanced' ) ?></a></li>     
        <li><a href="#um_advanced_view_lostpass"><?php _e( 'Lost Password', 'user-meta-advanced' ) ?></a></li>
        <li><a href="#um_advanced_view_resetpass"><?php _e( 'Reset Password', 'user-meta-advanced' ) ?></a></li>
    </ul>  

    <div id="um_advanced_view_login">
        <?php
        foreach( $loginInputs as $key => $val ) {
            if ( empty( $val ) ) {
                echo $userMeta->createInput( "views[login][$key]", 'text', array(
                    'label'         => $key,
                    'value'         => isset( $login[ $key ]  ) ? $login[ $key ] : '',
                    'class'         => 'pf_width_50',
                    'label_class'   => 'um_label_left',
                    'label_style'   => 'width:30%',
                    'enclose'       => 'p'
                ) );
            } elseif( $val == 'group' ) {
                echo '<br />';
            }
        }
        ?>
    </div>

    <div id="um_advanced_view_lostpass">
        <?php
        foreach( $lostpassInputs as $key => $val ) {
            if ( empty( $val ) ) {
                echo $userMeta->createInput( "views[lostpassword][$key]", 'text', array(
                    'label'         => $key,
                    'value'         => isset( $lostpassword[ $key ]  ) ? $lostpassword[ $key ] : '',
                    'class'         => 'pf_width_50',
                    'label_class'   => 'um_label_left',
                    'enclose'       => 'p'
                ) );
            } elseif( $val == 'group' ) {
                echo '<br />';
            }
        }
        ?>
    </div>
    
    <div id="um_advanced_view_resetpass">
        <?php
        foreach( $resetpassInputs as $key => $val ) {
            if ( empty( $val ) ) {
                echo $userMeta->createInput( "views[resetpass][$key]", 'text', array(
                    'label'         => $key,
                    'value'         => isset( $resetpass[ $key ]  ) ? $resetpass[ $key ] : '',
                    'class'         => 'pf_width_50',
                    'label_class'   => 'um_label_left',
                    'enclose'       => 'p'
                ) );
            } elseif( $val == 'group' ) {
                echo '<br />';
            }
        }
        ?>
    </div>

</div>
