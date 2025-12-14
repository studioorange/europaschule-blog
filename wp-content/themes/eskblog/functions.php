<?php
/**
 * Europaschule Köln Child Theme Functions
 *
 * @package europaschule
 * @since 1.0.0
 * @version 1.1.0
 */

// Security: Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load child theme textdomain for translations
 */
add_action('after_setup_theme', 'uncode_language_setup');
function uncode_language_setup()
{
    load_child_theme_textdomain('uncode', get_stylesheet_directory() . '/languages');
}

/**
 * Enqueue parent and child theme styles with optimized cache-busting
 */
function theme_enqueue_styles()
{
    $production_mode = function_exists('ot_get_option') ? ot_get_option('_uncode_production') : 'on';

    // Cache-busting: Use theme version for production, timestamp for development
    $theme_version = wp_get_theme()->get('Version');
    $resources_version = ($production_mode === 'on') ? $theme_version : time();

    // Check for optimization plugin compatibility
    if (function_exists('get_rocket_option') && (get_rocket_option('remove_query_strings') || get_rocket_option('minify_css') || get_rocket_option('minify_js'))) {
        $resources_version = null;
    }

    $parent_style = 'uncode-style';
    $child_style = array('uncode-style');
    wp_enqueue_style($parent_style, get_template_directory_uri() . '/library/css/style.css', array(), $resources_version);
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', $child_style, $resources_version);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 100);

/**
 * Optimize WordPress Heartbeat API
 * Reduces server load by increasing interval from 15s to 60s
 */
add_filter('heartbeat_settings', 'europaschule_heartbeat_settings');
function europaschule_heartbeat_settings($settings)
{
    $settings['interval'] = 60; // Default: 15 seconds
    return $settings;
}

/**
 * Disable WordPress Emojis (Performance optimization)
 */
add_action('init', 'europaschule_disable_emojis');
function europaschule_disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}



/**
 * Activate anti spam for email 
 */
function wpcodex_hide_email_shortcode( $atts , $content = null ) {
	if ( ! is_email( $content ) ) {
		return;
	}

	return '<a href="mailto:' . antispambot( $content ) . '">' . antispambot( $content ) . '</a>';
}

add_shortcode( 'email', 'wpcodex_hide_email_shortcode' );



/**
 * Add CTA Button to Mobile Header (before hamburger menu)
 * Uses Uncode's filter for mobile extra menu elements
 */
add_filter('uncode_mobile_extra_menu_elements', 'eskblog_mobile_cta_button');
function eskblog_mobile_cta_button($content) {
    // Get the CTA menu and display it in mobile header
    $cta_menu = wp_nav_menu(array(
        'theme_location' => 'cta',
        'container'      => 'div',
        'container_class' => 'mobile-cta-menu',
        'menu_class'     => 'mobile-cta-list',
        'fallback_cb'    => false,
        'echo'           => false,
        'depth'          => 1,
    ));

    if ($cta_menu) {
        return $cta_menu . $content;
    }

    return $content;
}

/**
 * German validation messages for User Submitted Posts form
 * Overrides Parsley.js validation messages to German
 */
add_action('wp_footer', 'eskblog_german_validation_messages');
function eskblog_german_validation_messages() {
    // Only load on pages with the USP form
    if (!has_shortcode(get_post()->post_content ?? '', 'user-submitted-posts')) {
        return;
    }
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Parsley.js German translations
        if (typeof Parsley !== 'undefined') {
            Parsley.addMessages('de', {
                defaultMessage: "Dieser Wert ist ungültig.",
                type: {
                    email:        "Bitte geben Sie eine gültige E-Mail-Adresse ein.",
                    url:          "Bitte geben Sie eine gültige URL ein.",
                    number:       "Bitte geben Sie eine gültige Nummer ein.",
                    integer:      "Bitte geben Sie eine ganze Zahl ein.",
                    digits:       "Bitte geben Sie nur Ziffern ein.",
                    alphanum:     "Bitte geben Sie nur Buchstaben und Zahlen ein."
                },
                notblank:       "Dieses Feld darf nicht leer sein.",
                required:       "Dieses Feld ist erforderlich.",
                pattern:        "Dieser Wert ist ungültig.",
                min:            "Dieser Wert muss größer oder gleich %s sein.",
                max:            "Dieser Wert muss kleiner oder gleich %s sein.",
                range:          "Dieser Wert muss zwischen %s und %s liegen.",
                minlength:      "Bitte geben Sie mindestens %s Zeichen ein.",
                maxlength:      "Bitte geben Sie maximal %s Zeichen ein.",
                length:         "Die Länge muss zwischen %s und %s Zeichen liegen.",
                mincheck:       "Bitte wählen Sie mindestens %s Optionen.",
                maxcheck:       "Bitte wählen Sie maximal %s Optionen.",
                check:          "Bitte wählen Sie zwischen %s und %s Optionen.",
                equalto:        "Dieses Feld muss identisch sein."
            });
            Parsley.setLocale('de');
        }
    });
    </script>
    <?php
}

/**
 * Allow editors to see access the Menus page under Appearance but hide other options
 * Note that users who know the correct path to the hidden options can still access them
 */
add_action('admin_menu', function() {
 $user = wp_get_current_user();

 // Check if the current user is an Editor - or bail
 if(!in_array( 'editor', (array) $user->roles )) return;

 // They're an editor, so grant the edit_theme_options capability if they don't have it
 if ( !current_user_can( 'edit_theme_options' ) ) {
  $role_object = get_role( 'editor' );
  $role_object->add_cap( 'edit_theme_options' );
 }

 // Hide the Themes page
 remove_submenu_page( 'themes.php', 'themes.php' );

 // Hide the Widgets page
 remove_submenu_page( 'themes.php', 'widgets.php' );

 // Hide the Customize page
 remove_submenu_page( 'themes.php', 'customize.php' );

 // Remove Customize from the Appearance submenu
 global $submenu;
 unset($submenu['themes.php'][6]);
});
