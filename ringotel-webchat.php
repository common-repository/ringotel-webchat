<?php
   /*
   Plugin Name: Ringotel Webchat Plugin
   Description: Add a Ringotel webchat widget to your website and talk to your website visitors in real-time.
   Version: 1.0.0
   Author: Ringotel
   License: GPL3
   */
  

   // Make sure we don't expose any info if called directly
   if ( !function_exists( 'add_action' ) ) {
      echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
      exit;
   }

   define('RINGOTEL_WEBCHAT_VERSION', '1.0.0');
   define( 'RINGOTEL_WEBCHAT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

   // add_action( 'admin_menu', 'messenger_customer_chat_menu' );
   if ( is_admin() ){ // admin actions
      require_once( RINGOTEL_WEBCHAT__PLUGIN_DIR . 'ringotel-webchat-admin.php' );
      add_action( 'init', array( 'Ringotel_WEBCHAT_Admin', 'init' ) );

   } else {
     // non-admin enqueues, actions, and filters
     ringotel_webchat_add_client_scripts();
   }

   function ringotel_webchat_add_client_scripts() {
      wp_enqueue_script( 'ringotel-webchat', plugins_url('/ringotel-webchat.js',  __FILE__ ), array('jquery'), RINGOTEL_WEBCHAT_VERSION, true);

      $data = array(
         'wchat_page_id' => get_option('wchat_page_id')
         // 'locale' => get_option('locale')
         // 'api_version' => get_option('api_version')
      );

      wp_localize_script( 'ringotel-webchat', 'plugin_options', $data );
   }


?>