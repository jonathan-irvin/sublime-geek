<?php
// via
// http://planetozh.com/blog/2008/07/what-plugin-coders-must-know-about-wordpress-26/
$root = dirname(dirname(dirname(dirname(__FILE__))));
if (file_exists($root.'/wp-load.php')) {
  // WP 2.6
  require_once($root.'/wp-load.php');
} else {
  // Before 2.6
  require_once($root.'/wp-config.php');
}
require_once($root . '/wp-includes/registration.php');

function rpx_signin_user($auth_info) {  
  $identifier = $auth_info['profile']['identifier'];
  $current_user = wp_get_current_user();
  $wpuid = rpx_get_wpuid_by_identifier($identifier);

  /* if we don't have the identifier mapped to wp user, create a new one */
  if (!$wpuid) {
    $wpuid = rpx_create_wp_user($auth_info);
  }

  /* sign the user in */
  wp_set_auth_cookie($wpuid, true, false);
  wp_set_current_user($wpuid);
  
  /* redirect them back to the page they were originally on */
  wp_redirect($_GET['goback']);
  die();
}

function rpx_get_wpuid_by_identifier($identifier) {
  global $wpdb;
  $sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'rpx_identifier' AND meta_value = %s";
  $r = $wpdb->get_var($wpdb->prepare($sql, $identifier));
  
  if ($r) {
    return $r;
  } else {
    return null;
  }
}

function rpx_get_identifier_by_wpuid($wpuid) {
  return get_usermeta($wpuid, 'rpx_identifier');
}

function rpx_get_user_login_name($identifier) {
  return 'rpx'.md5($identifier);
}

function rpx_username_taken($username) {
  $user = get_userdatabylogin($username);
  return $user != false;
}

// create a new user based on the 
function rpx_create_wp_user($auth_info) {
  $p = $auth_info['profile'];
  $rid = $p['identifier'];
  $provider_name = $p['providerName'];

  $username = $p['preferredUsername'];
  if(!$username or rpx_username_taken($username)) {
    $username = rpx_get_user_login_name($rid);
  }   

  $last_name = null;
  $first_name = null;
  if($p['name']) {
    $first_name = $p['name']['givenName'];
    $last_name = $p['name']['familyName'];
  }

  $userdata = array(
     'user_pass' => wp_generate_password(),
     'user_login' => $username,
     'display_name' => $p['displayName'],
     'user_url' => $p['url'],
     'user_email' => $p['email'],
     'first_name' => $first_name,
     'last_name' =>  $last_name,
     'nickname' => $p['displayName']);
  
  $wpuid = wp_insert_user($userdata);
  if ($wpuid) {
    update_usermeta($wpuid, 'rpx_identifier', $rid);
  }
    
  return $wpuid;
}


function rpx_edit_user_page() {

  $user = wp_get_current_user();
  $rpx_identifier = $user->rpx_identifier;
  $login_provider = $user->rpx_provider;
 
  echo '<h3 id="rpx">Sign-in Provider</h3>';
  
  if ($rpx_identifier) {
    
    // extract the provider domain
    $pieces = explode('/', $rpx_identifier);
    $host = $pieces[2];

    echo '<p>You are currently using <b>'. $host .'</b> as your sign-in provider.  You may change this by choosing a different provider or OpenID below and clicking "Sign-In."</p>';

  } else {
    
    echo '<p>You can sign in to this blog without a password by choosing a provider below.</p>';

  }

  $token_url_params = '&attach_to=' . $user->ID;

  rpx_iframe('border:1px solid #aaa;padding:2em;background-color:white;',
	     $token_url_params);
}


?>