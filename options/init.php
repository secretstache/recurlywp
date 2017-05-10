<?php


// Options page init
function recurlywp_settings_init() {

    // Register Setting
    register_setting('recurlywp', 'recurlywp_options');

    // Section -> Recurly Settings
    add_settings_section(
        'recurlywp_section_recurly',
        __('Recurly Settings', 'recurlywp'),
        'recurlywp_section_empty_cb',
        'recurlywp'
    );


    // Field -> Recurly Private API Key
    add_settings_field(
        'recurlywp_setting_recurly_api_key_private',
        __('Recurly Private API Key', 'recurlywp'),
        'recurlywp_setting_field_text',
        'recurlywp',
        'recurlywp_section_recurly',
        [
            'label_for'         => 'recurlywp_setting_recurly_api_key_private',
            'description'       => 'You can find this key in your Recurly dashboard: Developers > API Credentials',
            'is_valid_info'     => recurlywp_is_valid_recurly_config()
        ]
    );

    // Field -> Recurly Subdomain
    add_settings_field(
        'recurlywp_setting_recurly_subdomain',
        __('Recurly Subdomain', 'recurlywp'),
        'recurlywp_setting_field_text',
        'recurlywp',
        'recurlywp_section_recurly',
        [
            'label_for'         => 'recurlywp_setting_recurly_subdomain',
            'description'       => 'For https://my-company.recurly.com your subdomain is my-company',
            'is_valid_info'     => recurlywp_is_valid_recurly_config()
        ]
    );


    // Field -> Recurly Account Code URL param
    add_settings_field(
        'recurlywp_setting_account_code_query_var',
        __('URL Parameter for "Account Code"', 'recurlywp'),
        'recurlywp_setting_field_text',
        'recurlywp',
        'recurlywp_section_recurly',
        [
            'label_for'         => 'recurlywp_setting_account_code_query_var',
            'description'       => 'Query variable key for account code in Confirmation page redirect URL.',
            'default_value'     => 'account_code'
        ]
    );

        // Field -> Recurly Subdomain
    // add_settings_field(
    //     'recurlywp_setting_plan_code_query_var',
    //     __('URL query variable: Plan Code', 'recurlywp'),
    //     'recurlywp_setting_field_text',
    //     'recurlywp',
    //     'recurlywp_section_pap',
    //     [
    //         'label_for'         => 'recurlywp_setting_plan_code_query_var',
    //         'description'       => 'Query variable key for plan code in Confirmation page redirect URL.',
    //         'default_value'     => 'plan'
    //     ]
    // );
}
add_action('admin_init', 'recurlywp_settings_init');

// Empty section callback
function recurlywp_section_empty_cb($args) {

}

// Field: Text
function recurlywp_setting_field_text($args) {

    $options = get_option('recurlywp_options');
    $value   = ( $options[$args['label_for']] ) ? $options[$args['label_for']] : $args['default_value'];
    ?>
    <input type="text" class="regular-text" name="recurlywp_options[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo esc_attr($value);?>">
    <?php if (isset($args['is_valid_info'])) { 
        echo ($args['is_valid_info']) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>';
    } ?>
    <?php if ( isset($args['description']) ) : ?>
    <p class="description">
        <?php echo esc_html($args['description'], 'recurlywp'); ?>
    </p>
    <?php endif;?>

    <?php
}

/**
 * top level menu:
 * callback functions
 */
function recurlywp_options_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_GET['settings-updated'])) {
        // add settings saved message with the class of "updated"
        add_settings_error('recurlywp_messages', 'recurlywp_message', __('Settings Saved', 'recurlywp'), 'updated');

        // Get saved settings
        $private_key = recurlywp_get_option('recurlywp_setting_recurly_api_key_private');
        $sub_domain = recurlywp_get_option('recurlywp_setting_recurly_subdomain');

        // Revalidate settings
        recurlywp_validate_info($private_key, $sub_domain, false);
    }

    settings_errors( 'recurlywp_messages' );

    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "recurlywp"
            settings_fields('recurlywp');
            // output setting sections and their fields
            // (sections are registered for "recurlywp", each field is registered to a specific section)
            do_settings_sections('recurlywp');
            // output save settings button
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}
