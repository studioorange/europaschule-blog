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
 * AJAX endpoint to verify captcha answer before showing full form
 * Prevents users from seeing the form if they don't know the answer
 */
add_action('wp_ajax_eskblog_verify_captcha', 'eskblog_verify_captcha');
add_action('wp_ajax_nopriv_eskblog_verify_captcha', 'eskblog_verify_captcha');
function eskblog_verify_captcha() {
    $usp_options = get_option('usp_options');
    $correct_answer = isset($usp_options['usp_response']) ? $usp_options['usp_response'] : '';
    $case_sensitive = isset($usp_options['usp_casing']) ? $usp_options['usp_casing'] : false;

    $user_answer = isset($_POST['answer']) ? sanitize_text_field($_POST['answer']) : '';

    // Compare answers
    if ($case_sensitive) {
        $is_correct = ($user_answer === $correct_answer);
    } else {
        $is_correct = (strtolower($user_answer) === strtolower($correct_answer));
    }

    wp_send_json(array('valid' => $is_correct));
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

        // Two-step form: Show verification first, then rest of form
        const form = document.getElementById('usp_form');
        if (!form) return;

        // Create step containers
        const step1Fields = ['usp-name', 'usp-email', 'usp-captcha'];
        const step1Container = document.createElement('div');
        step1Container.id = 'usp-step-1';
        step1Container.className = 'usp-form-step usp-step-active';

        const step2Container = document.createElement('div');
        step2Container.id = 'usp-step-2';
        step2Container.className = 'usp-form-step usp-step-hidden';

        // Get all fieldsets
        const fieldsets = form.querySelectorAll('fieldset');
        const submitDiv = form.querySelector('#usp-submit');
        const errorDiv = form.querySelector('#usp-error-message');

        // Move fieldsets to appropriate containers
        fieldsets.forEach(function(fieldset) {
            const classes = fieldset.className;
            if (step1Fields.some(cls => classes.includes(cls))) {
                step1Container.appendChild(fieldset);
            } else {
                step2Container.appendChild(fieldset);
            }
        });

        // Create "Continue" button for step 1
        const continueBtn = document.createElement('button');
        continueBtn.type = 'button';
        continueBtn.id = 'usp-continue-btn';
        continueBtn.className = 'usp-submit';
        continueBtn.textContent = 'Weiter zum Formular';
        step1Container.appendChild(continueBtn);

        // Create "Back" button for step 2
        const backBtn = document.createElement('button');
        backBtn.type = 'button';
        backBtn.id = 'usp-back-btn';
        backBtn.className = 'usp-back-btn';
        backBtn.textContent = '← Zurück';

        // Insert containers into form
        if (errorDiv && errorDiv.nextSibling) {
            form.insertBefore(step1Container, errorDiv.nextSibling);
        } else {
            form.insertBefore(step1Container, form.firstChild);
        }
        form.insertBefore(step2Container, submitDiv);
        step2Container.insertBefore(backBtn, step2Container.firstChild);
        step2Container.appendChild(submitDiv);

        // Create error message element for captcha
        const captchaError = document.createElement('div');
        captchaError.id = 'usp-captcha-error';
        captchaError.className = 'usp-captcha-error usp-hidden';
        captchaError.textContent = 'Die Antwort ist leider falsch. Bitte versuchen Sie es erneut.';
        step1Container.insertBefore(captchaError, continueBtn);

        // Step navigation logic with server-side captcha validation
        continueBtn.addEventListener('click', function() {
            // Validate step 1 fields
            const nameField = form.querySelector('[name="user-submitted-name"]');
            const emailField = form.querySelector('[name="user-submitted-email"]');
            const captchaField = form.querySelector('[name="user-submitted-captcha"]');

            let valid = true;
            let firstInvalid = null;

            // Hide previous captcha error
            captchaError.classList.add('usp-hidden');

            // Check required fields in step 1
            [nameField, emailField, captchaField].forEach(function(field) {
                if (field && field.hasAttribute('required') && !field.value.trim()) {
                    field.classList.add('usp-error');
                    valid = false;
                    if (!firstInvalid) firstInvalid = field;
                } else if (field) {
                    field.classList.remove('usp-error');
                }
            });

            // Email format check
            if (emailField && emailField.value && !emailField.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                emailField.classList.add('usp-error');
                valid = false;
                if (!firstInvalid) firstInvalid = emailField;
            }

            if (!valid) {
                if (firstInvalid) firstInvalid.focus();
                return;
            }

            // Disable button during validation
            continueBtn.disabled = true;
            continueBtn.textContent = 'Wird geprüft...';

            // Verify captcha answer via AJAX
            const formData = new FormData();
            formData.append('action', 'eskblog_verify_captcha');
            formData.append('answer', captchaField.value);

            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                continueBtn.disabled = false;
                continueBtn.textContent = 'Weiter zum Formular';

                if (data.valid) {
                    // Captcha correct - move to step 2
                    captchaField.classList.remove('usp-error');
                    step1Container.classList.remove('usp-step-active');
                    step1Container.classList.add('usp-step-hidden');
                    step2Container.classList.remove('usp-step-hidden');
                    step2Container.classList.add('usp-step-active');
                    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    // Captcha wrong - show error
                    captchaField.classList.add('usp-error');
                    captchaError.classList.remove('usp-hidden');
                    captchaField.focus();
                }
            })
            .catch(error => {
                continueBtn.disabled = false;
                continueBtn.textContent = 'Weiter zum Formular';
                console.error('Captcha verification failed:', error);
            });
        });

        backBtn.addEventListener('click', function() {
            step2Container.classList.remove('usp-step-active');
            step2Container.classList.add('usp-step-hidden');
            step1Container.classList.remove('usp-step-hidden');
            step1Container.classList.add('usp-step-active');
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });

        // Save form data to sessionStorage on submit for validation errors
        // Clear when leaving page without submitting (browser close, navigate away)

        const storageKey = 'usp_form_data';
        const submitFlagKey = 'usp_form_submitted';
        const fieldsToSave = ['user-submitted-name', 'user-submitted-email', 'user-submitted-title', 'user-submitted-tags', 'user-submitted-category', 'user-submitted-content'];

        // Check if we're returning from a form submit (validation error)
        const wasSubmitted = sessionStorage.getItem(submitFlagKey);
        const savedData = sessionStorage.getItem(storageKey);

        if (wasSubmitted && savedData) {
            // Restore saved data after validation error
            try {
                const data = JSON.parse(savedData);
                fieldsToSave.forEach(function(fieldName) {
                    if (data[fieldName]) {
                        const field = form.querySelector('[name="' + fieldName + '"], [name="' + fieldName + '[]"]');
                        if (field) {
                            if (field.tagName === 'SELECT') {
                                field.value = data[fieldName];
                            } else if (field.tagName === 'TEXTAREA' || field.type === 'text' || field.type === 'email') {
                                field.value = data[fieldName];
                            }
                        }
                    }
                });
                // Restore TinyMCE content
                if (data['user-submitted-content'] && typeof tinymce !== 'undefined') {
                    setTimeout(function() {
                        const editor = tinymce.get('user-submitted-content');
                        if (editor) {
                            editor.setContent(data['user-submitted-content']);
                        }
                    }, 500);
                }
            } catch (e) {
                console.log('Could not restore form data');
            }
            // Keep data for potential next validation error, but clear submit flag
            sessionStorage.removeItem(submitFlagKey);
        } else {
            // Fresh page load (not from submit) - clear any old data
            sessionStorage.removeItem(storageKey);
            sessionStorage.removeItem(submitFlagKey);
        }

        // Save data function
        function saveFormData() {
            const data = {};
            fieldsToSave.forEach(function(fieldName) {
                const field = form.querySelector('[name="' + fieldName + '"], [name="' + fieldName + '[]"]');
                if (field) {
                    data[fieldName] = field.value;
                }
            });
            // Save TinyMCE content
            if (typeof tinymce !== 'undefined') {
                const editor = tinymce.get('user-submitted-content');
                if (editor) {
                    data['user-submitted-content'] = editor.getContent();
                }
            }
            sessionStorage.setItem(storageKey, JSON.stringify(data));
        }

        // Save data when form is submitted (set flag to indicate submit happened)
        form.addEventListener('submit', function() {
            sessionStorage.setItem(submitFlagKey, 'true');
            saveFormData();
        });
    });
    </script>
    <?php
}

/**
 * Redirect to thank you page after successful USP form submission
 * Uses usp_submit_success action hook to override redirect
 */
add_action('usp_submit_success', 'eskblog_usp_redirect_to_thanks', 1);
function eskblog_usp_redirect_to_thanks($redirect) {
    wp_redirect(home_url('/danke/'));
    exit;
}

/**
 * Auto-generate excerpt for posts without one when saving
 * Especially important for USP submitted posts
 */
add_action('save_post', 'eskblog_auto_generate_excerpt', 10, 3);
function eskblog_auto_generate_excerpt($post_id, $post, $update) {
    // Only for posts
    if ($post->post_type !== 'post') {
        return;
    }

    // Don't run on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // If excerpt already exists, skip
    if (!empty($post->post_excerpt)) {
        return;
    }

    // Generate excerpt from content
    $content = $post->post_content;
    $content = strip_shortcodes($content);
    $content = wp_strip_all_tags($content);
    $content = trim($content);

    if (empty($content)) {
        return;
    }

    // Limit to ~20 words
    $excerpt = wp_trim_words($content, 20, '…');

    // Update post without triggering infinite loop
    remove_action('save_post', 'eskblog_auto_generate_excerpt', 10);
    wp_update_post(array(
        'ID' => $post_id,
        'post_excerpt' => $excerpt
    ));
    add_action('save_post', 'eskblog_auto_generate_excerpt', 10, 3);
}

/**
 * Clear form data from sessionStorage after successful submission
 * Works on both thank you page and success query parameter
 */
add_action('wp_footer', 'eskblog_clear_form_on_success');
function eskblog_clear_form_on_success() {
    // On thank you page or on success parameter
    if (!is_page('danke') && !isset($_GET['success'])) {
        return;
    }
    ?>
    <script>
    sessionStorage.removeItem('usp_form_data');
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

/**
 * Translate archive titles to German
 * Changes "Month:" to "Monat:" for monthly archives
 */
add_filter('get_the_archive_title', 'eskblog_translate_archive_titles');
function eskblog_translate_archive_titles($title) {
    // Replace "Month:" with "Monat:"
    $title = str_replace('Month:', 'Monat:', $title);

    // Optional: Also translate other archive labels
    $title = str_replace('Year:', 'Jahr:', $title);
    $title = str_replace('Day:', 'Tag:', $title);
    $title = str_replace('Author:', 'Autor:', $title);
    $title = str_replace('Archives:', 'Archiv:', $title);

    return $title;
}

/**
 * Replace WordPress author with submitted author name
 * Shows the user_submit_name instead of the WP user who published the post
 * Filters both the_author and get_the_author_meta for display_name
 */
add_filter('the_author', 'eskblog_replace_author_with_submitted_name');
add_filter('get_the_author_display_name', 'eskblog_replace_author_with_submitted_name');
function eskblog_replace_author_with_submitted_name($author) {
    $post_id = get_the_ID();
    if (!$post_id) {
        return $author;
    }

    // Get the submitted author name from USP
    $submitted_name = get_post_meta($post_id, 'user_submit_name', true);

    if (!empty($submitted_name)) {
        return esc_html($submitted_name);
    }

    return $author;
}

/**
 * Also filter author link to not link to WP user profile for submitted posts
 */
add_filter('author_link', 'eskblog_remove_author_link_for_submitted', 10, 3);
function eskblog_remove_author_link_for_submitted($link, $author_id, $author_nicename) {
    $post_id = get_the_ID();
    if (!$post_id) {
        return $link;
    }

    // If this is a user-submitted post, return empty link
    $submitted_name = get_post_meta($post_id, 'user_submit_name', true);
    if (!empty($submitted_name)) {
        return '#';
    }

    return $link;
}
