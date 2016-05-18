<?php
global $userMeta;
// Expected $integration

$hooksList = $userMeta->hooksList();

$hooks = array();
foreach( $hooksList as $key => $val ) {
    if ( strpos( $key, 'group_' ) !== false ) {
        $newKey = $val;
        continue;
    }
    
    if ( ! empty( $newKey ) ) 
        $hooks[ $newKey ][ $key ] = $key;
}


echo $userMeta->createInput( 'integration[ump_wp_hooks]', 'multiselect', array( 
    'label'         => 'Integrate filter / action hooks',
    'value'         => isset( $integration['ump_wp_hooks']  ) ? $integration['ump_wp_hooks'] : '',
    'class'         => 'pf_width_50',
    'label_class'   => 'um_label_top',
    'enclose'       => 'p',
 ), $hooks ); 


echo "<p>These hooks will allow others plugins to talk with User Meta Pro. "
. "Enable them to integrate with others plugin or disable them for avoiding plugin conflict. </p>";


echo "<div class='pf_divider'></div>";  


echo '<h4>Override email notifications</h4>';

echo $userMeta->createInput( 'integration[override_registration_email]', 'checkbox', array(
    'label'         => __( 'Override default user registration email.', $userMeta->name ),
    'value'         => ! empty ( $integration['override_registration_email'] ) ? true : false,
    'id'            => 'um_integration_override_registration_email',
    'enclose'       => 'p',
) );

echo $userMeta->createInput( 'integration[override_resetpass_email]', 'checkbox', array(
    'label'         => __( 'Override default reset password email.', $userMeta->name ),
    'value'         => ! empty ( $integration['override_resetpass_email'] ) ? true : false,
    'id'            => 'um_integration_override_resetpass_email',
    'enclose'       => 'p',
) );



echo "<p>Enable those checkboxes to override default WordPress emails with User Meta Pro generated emails. "
. "This could be useful, when you need registration form other than us but custom email notification by UMP. </p>";

?>

<?php if ( version_compare( $userMeta->version, '1.1.7rc1', '>=' ) ) : ?>
    <div class='pf_divider'></div>
    <h4>WPML</h4>
    <a href="javascript:void(0)" class="button-secondary um_generate_wpml_config">Generate wpml-config.xml</a>
<?php endif; ?>