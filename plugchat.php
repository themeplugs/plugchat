<?php 
/*
Plugin Name:  Plug Chat
Plugin URI: http://themeplugs.com/plugin/plugsprice/
Author: Themeplugs
Author URI: http://themeplugs.com/
Version: 1.0.0
Text Domain: plugchat
Description: Plugchat is describe the menu add function and display the option 
*/

if ( ! defined( 'ABSPATH' ) ) {
	wp_die(esc_html__("Direct Access Not Allow",'plugchat'));
}

function plugchat_add_admin_page(){
    // Add main menu item
    add_menu_page('Plug Chat Option','Plugchat','manage_options','alecadd_plugchat','plugchat_plugin_create_page',plugins_url("/assets/images/chat.png",__FILE__),110);
   
    // Add Sub menu item 
    add_submenu_page('alecadd_plugchat','Plugchat Plugin Options','General','manage_options','alecadd_plugchat','plugchat_plugin_create_page');    
    add_submenu_page('alecadd_plugchat','Plugchat Css Options','Custom Css','manage_options','alecadd_plugchat_css','plugchat_plugin_settings_page');

    // Activate Custom Settings

    add_action("admin_init","plugchat_custom_settings");
}

add_action('admin_menu','plugchat_add_admin_page');


function plugchat_custom_settings(){
    register_setting("plugchat-settings-group","first_name");
    register_setting("plugchat-settings-group","chat_color");
    add_settings_section('plugchat-page-options','Plugchat Options','plugchat_sidebar_options','alecadd_plugchat');
    add_settings_field('pageid', "Page ID","plugchat_sidebar_name", "alecadd_plugchat", "plugchat-page-options");
    add_settings_field('chat_color', "Chat Color","plugchat_color", "alecadd_plugchat", "plugchat-page-options");
    add_settings_field('chat_reply', "Chat Default Reply","plugchat_reply", "alecadd_plugchat", "plugchat-page-options");
}

function plugchat_sidebar_options(){
    echo esc_html__("Customize your chatbot","plugchat");
}
function plugchat_sidebar_name(){
    $firstName = esc_attr(get_option('first_name'));
    echo '<input type="text" class="plugs-input" name="first_name" value="'.$firstName.'" />';
}

function plugchat_color(){
    $chatColor = esc_attr(get_option('chat_color'));
    echo '<input type="text" class="chat_color" name="chat_color" value="'.$chatColor.'" />';
}
function plugchat_reply(){
    $chatReply = esc_attr(get_option('chat_reply'));
    echo "<textarea placeholder='Enter your reply text' class='plugs-input plugs-reply'>".$chatReply."</textarea>";
}

/**
 *  enqueue scripts and styles
 */
function plugchat_assets() {

    wp_enqueue_style( 'plugchat', plugins_url("/assets/css/main-style.css",__FILE__),false,"1.0.0" );
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script("plugchat-js", plugins_url("/assets/js/script.js",__FILE__),array("jquery"),"1.0.0",true);
}
add_action( 'wp_enqueue_scripts', 'plugchat_assets' );

/**
 * Admin scripting assets
 */
function plugchat_custom_admin_assets() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_style( "admin-style", plugins_url("/assets/css/admin-style.css",__FILE__),false,"1.0.0" );
    
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_script("plugchat-js", plugins_url("/assets/js/script.js",__FILE__),array("jquery"),"1.0.0",true);
}
add_action( 'admin_enqueue_scripts', 'plugchat_custom_admin_assets' );

/**
 * For main menu 
 */
function plugchat_plugin_create_page(){
    require_once("inc/templates/admin.php");
}

/**
 * For Sub Menu 
 */
function plugchat_plugin_settings_page(){
   
}

// Prepend a meaningful comment so you instantly know what the code below does.
add_action('wp_footer', 'plugchat_inject_footer');

function plugchat_inject_footer(){
?>
	
<?php 
	$page_id = esc_attr(get_option('first_name'));
	$chat_color = esc_attr(get_option('chat_color'));

    ?>
    <div id='fb-root'></div>
    <div class='fb-customerchat'
        attribution="wordpress"
        page_id='<?php print $page_id; ?>'
        theme_color='<?php print $chat_color; ?>'
    >
    </div>
<?php
};