<?php 
/*
Plugin Name:  Plug Chat
Plugin URI: http://themeplugs.com/plugin/plugchat/
Author: Themeplugs
Author URI: http://themeplugs.com/
Version: 1.0.0
Text Domain: plugchat
Description: Plugchat is facebook chat for WordPress website. A feasible way to engage with the customer interactive sales experience for customers.
*/

if ( ! defined( 'ABSPATH' ) ) {
	wp_die(esc_html__("Direct Access Not Allow",'plugchat'));
}

    function plugchat_add_admin_page(){
        // Add main menu item
        add_menu_page('Plug Chat Option','Plugchat','manage_options','themeplugs_plugchat','plugchat_plugin_create_page',plugins_url("/assets/images/chat.png",__FILE__),110);
        
        // Activate Custom Settings
        add_action("admin_init","plugchat_custom_settings");
    }

    add_action('admin_menu','plugchat_add_admin_page');


    function plugchat_custom_settings(){
        register_setting("plugchat-settings-group","page_id");
        register_setting("plugchat-settings-group","chat_color");
        register_setting("plugchat-settings-group","chat_reply");
        register_setting("plugchat-settings-group","logtout_chat_reply");
        register_setting("plugchat-settings-group","plugchat_position");

        add_settings_section('plugchat-page-options','Plugchat Options','plugchat_sidebar_options','themeplugs_plugchat');
        add_settings_field('page_id', "Page ID","plugchat_sidebar_name", "themeplugs_plugchat", "plugchat-page-options");
        add_settings_field('chat_color', "Chat Color","plugchat_color", "themeplugs_plugchat", "plugchat-page-options");
        add_settings_field('chat_reply', "Chat Default Reply","plugchat_reply", "themeplugs_plugchat", "plugchat-page-options");
        add_settings_field('logtout_chat_reply', "Chat Logout Default Reply","plugchat_logout_reply", "themeplugs_plugchat", "plugchat-page-options");
        add_settings_field('plugchat_position', "Position","plugchat_position", "themeplugs_plugchat", "plugchat-page-options");
    }

    function plugchat_sidebar_options(){
        echo esc_html__("Customize your chatbot","plugchat");
    }
    function plugchat_sidebar_name(){
        $pageID = esc_attr(get_option('page_id'));
        echo '<input type="text" class="plugs-input" name="page_id" value="'.$pageID.'" />';
    }

    function plugchat_color(){
        $chatColor = esc_attr(get_option('chat_color'));
        echo '<input type="text" class="chat_color" name="chat_color" value="'.$chatColor.'" />';
    }
    function plugchat_reply(){
        $chatReply = esc_attr(get_option('chat_reply'));
        echo '<input  type="text" placeholder="Enter your reply text" class="plugs-input plugs-reply" name="chat_reply" value="'.$chatReply.'" />';
    }

    function plugchat_logout_reply(){
        $chatlogoutReply = esc_attr(get_option('logtout_chat_reply'));
        echo '<input  type="text" placeholder="Enter your reply text" class="plugs-input plugs-reply" name="logtout_chat_reply" value="'.$chatlogoutReply.'" />';
    }

    function plugchat_position(){
        ?>
            <select class="" name="plugchat_position">
                <option value="left" <?php if ( get_option('plugchat_position') == 'left' ) echo esc_attr('selected="selected"'); ?>>Left</option>
                <option value="right" <?php if ( get_option('plugchat_position') == 'right' ) echo  esc_attr('selected="selected"'); ?>>Right</option>
            </select>
        <?php 
    }

    /**
     *  enqueue scripts and styles
     */
    function plugchat_assets() {
        wp_enqueue_style( 'plugchat', plugins_url("/assets/css/style.css",__FILE__),false,"1.0.0" );
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
        wp_enqueue_script("plugchat-js", plugins_url("/assets/js/admin-script.js",__FILE__),array("jquery"),"1.0.0",true);
    }
    add_action( 'admin_enqueue_scripts', 'plugchat_custom_admin_assets' );

    /**
     * For main menu 
     */
    function plugchat_plugin_create_page(){
        require_once("inc/templates/admin.php");
    }

    // Hooks for footer 
    add_action('wp_footer', 'plugchat_inject_footer');

    function plugchat_inject_footer(){
    ?>
        
    <?php 
        $page_id = esc_attr(get_option('page_id'));
        $chat_color = esc_attr(get_option('chat_color'));
        $chat_reply = esc_attr(get_option('chat_reply'));
        $chatlogoutReply = esc_attr(get_option('logtout_chat_reply'));
        $plugchatPosition = esc_attr(get_option('plugchat_position'));
        ?>
        <div class="chat-btn <?php print $plugchatPosition; ?>">
            <div id='fb-root'></div>
            <div class='fb-customerchat'
                attribution="wordpress"
                page_id='<?php print $page_id; ?>'
                theme_color='<?php print $chat_color; ?>'
                logged_in_greeting='<?php print $chat_reply;  ?>'
                logged_out_greeting='<?php print $chatlogoutReply;  ?>'
            >
            </div>
    </div>
        
    <?php
    };
