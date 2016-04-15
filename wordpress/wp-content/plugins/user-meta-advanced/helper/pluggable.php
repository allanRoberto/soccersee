<?php

if ( ! function_exists('wp_new_user_notification') ) :
/** 
 * Check if override is set, call UMP emails else wp default 
 */
function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
    global $userMeta;
    
    $advanced = $userMeta->getData( 'advanced' );
    if ( ! empty( $advanced['integration']['override_registration_email'] ) ) {
        $user = new WP_User( $user_id );
        $user->password = $plaintext_pass;
        $userMeta->prepareEmail( 'registration', $user );
        return;
    }
    
    //Copied out of /wp-includes/pluggable.php
    
	$user = get_userdata( $user_id );

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n";
	$message .= sprintf(__('Username: %s'), $user->user_login) . "\r\n\r\n";
	$message .= sprintf(__('E-mail: %s'), $user->user_email) . "\r\n";

	@wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);

	if ( empty($plaintext_pass) )
		return;

	$message  = sprintf(__('Username: %s'), $user->user_login) . "\r\n";
	$message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n";
	$message .= wp_login_url() . "\r\n";

	wp_mail($user->user_email, sprintf(__('[%s] Your username and password'), $blogname), $message);

}
endif;



if ( !function_exists('wp_password_change_notification') ) :
/**
 * Notify the blog admin of a user changing password, normally via email.
 */
function wp_password_change_notification(&$user) {
    global $userMeta;
    
    $advanced = $userMeta->getData( 'advanced' );
    if ( ! empty( $advanced['integration']['override_resetpass_email'] ) ) {
        $userMeta->prepareEmail( 'reset_password', $user );
        return;
    }
    
    //Copied out of /wp-includes/pluggable.php
    
	// send a copy of password change notification to the admin
	// but check to see if it's the admin whose password we're changing, and skip this
	if ( 0 !== strcasecmp( $user->user_email, get_option( 'admin_email' ) ) ) {
		$message = sprintf(__('Password Lost and Changed for user: %s'), $user->user_login) . "\r\n";
		// The blogname option is escaped with esc_html on the way into the database in sanitize_option
		// we want to reverse this for the plain text arena of emails.
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
		wp_mail(get_option('admin_email'), sprintf(__('[%s] Password Lost/Changed'), $blogname), $message);
	}
}
endif;