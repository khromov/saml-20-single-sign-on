<?php
/*
Plugin Name: SAML 2.0 Single Sign-On
Version: 0.9.3b
Plugin URI: http://keithbartholomew.com
Description: Authenticate users using <a href="http://rnd.feide.no/simplesamlphp">simpleSAMLphp</a>.
Author: Keith Bartholomew
Author URI: http://keithbartholomew.com
*/

// Store all config stuff with the main blog, which is defined by BLOG_ID_CURRENT_SITE
switch_to_blog(constant('BLOG_ID_CURRENT_SITE'));
$upload_dir = wp_upload_dir();
define('SAMLAUTH_CONF', $upload_dir['basedir'] . '/saml-20-single-sign-on/etc');
define('SAMLAUTH_CONF_URL', $upload_dir['baseurl'] . '/saml-20-single-sign-on/etc');
restore_current_blog();

define('SAMLAUTH_ROOT',dirname(__FILE__));
define('SAMLAUTH_URL',plugins_url() . '/' . basename( dirname(__FILE__) ) );
define('SAMLAUTH_MD_URL', constant('SAMLAUTH_URL') . '/saml/www/module.php/saml/sp/metadata.php/' . get_current_blog_id() );


// Things needed everywhere
require_once( constant('SAMLAUTH_ROOT') . '/lib/classes/saml_settings.php' );
require_once( constant('SAMLAUTH_ROOT') . '/lib/classes/saml_client.php' );

$SAML_Client = new SAML_Client();

// WordPress action hooks
add_action('lost_password', array($SAML_Client,'disable_function'));
add_action('retrieve_password', array($SAML_Client,'disable_function'));
add_action('password_reset', array($SAML_Client,'disable_function'));
add_filter('show_password_fields', array($SAML_Client,'show_password_fields'));


// Things needed only by the admin portal
if( is_admin() )
{
  require_once( constant('SAMLAUTH_ROOT') . '/lib/classes/saml_admin.php' );
  $SAML_Admin = new SAML_Admin();
}

// end of file
