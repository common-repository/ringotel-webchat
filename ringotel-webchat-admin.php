<?php
  

    class Ringotel_Webchat_Admin {

        public static function init() {
            $plugin = plugin_basename( __FILE__ );

            add_action( 'admin_menu', array( 'Ringotel_Webchat_Admin', 'add_menu') );
            add_action( 'admin_init', array( 'Ringotel_Webchat_Admin', 'register_plugin_options') );
            add_action('wp_enqueue_scripts', array( 'Ringotel_Webchat_Admin', 'add_plugin_scripts') );
            add_filter( "plugin_action_links_$plugin", array( 'Ringotel_Webchat_Admin', 'plugin_add_settings_link') );
        }

        public static function add_menu() {
            add_options_page( 'Ringotel Webchat', 'Ringotel Webchat', 'manage_options', '  ringotel-webchat', array( 'Ringotel_Webchat_Admin', 'add_options') );
        }

        public static function add_options() {
            if ( !current_user_can( 'manage_options' ) )  {
                wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
            }

            echo '<div class="wrap">';
            echo '<h1>Ringotel Webchat</h1>';
            echo '<form method="post" action="options.php">';

            settings_fields( 'plugin_options' );
            do_settings_sections( 'plugin' );
            submit_button();

            echo "</form>";
            echo '</div>';
        }

        public static function register_plugin_options() { // whitelist options
            register_setting( 'plugin_options', 'wchat_page_id', array( 'Ringotel_Webchat_Admin', 'validate_page_id') );
            register_setting( 'plugin_options', 'locale', array( 'Ringotel_Webchat_Admin', 'validate_locale') );
            // register_setting( 'plugin_options', 'api_version', 'validate_api_version' );

            add_settings_section('plugin_main', 'Plugin Options', array( 'Ringotel_Webchat_Admin', 'plugin_section_text'), 'plugin');

            add_settings_field('wchat_page_id', 'Page ID', array( 'Ringotel_Webchat_Admin', 'setting_string'), 'plugin', 'plugin_main', array('option_id' => 'wchat_page_id', 'description' => self::getFieldDescription('wchat_page_id')));
        }

        public static function plugin_section_text() {
            echo (
                '<p>You need to have a Webchat channel created in your Ringotel workspace admin panel.</p>'
            );
        }

        public static function setting_string($opts) {
            $option_id = $opts['option_id'];
            $option = get_option($option_id);
            $defaultValue = "";
            $value = "";

            if(array_key_exists('default_value', $opts)) {
                $defaultValue = $opts['default_value'];
            }

            if(empty($option)) {
                $value = $defaultValue;
            } else {
                $value = $option;
            }

            echo "<input id='$option_id' name='$option_id' size='40' type='text' value='$value' />";
            echo ("<p class=\"description\">" . $opts['description'] . "</p>");
        }

        public static function plugin_add_settings_link( $links ) {
           $settings_link = '<a href="options-general.php?page=plugin_name">' . __( 'Settings' ) . '</a>';
           array_push( $links, $settings_link );
           return $links;
        }

        public static function getFieldDescription($field_id) {
            $desc = '';

            switch($field_id) {
                case 'wchat_page_id':
                    $desc = 'To get a <em>Page ID</em> value, you need to create a webchat channel first.';
                    break;
            }

            return $desc;
        }
      
        public static function validate_page_id($input) {
            return $input;
        }

        public static function validate_locale($input) {
            return $input;
        }

        // public static function validate_api_version($input) {
        //    return $input;
        // }
    }

?>