<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://m4v1.work
 * @since      1.0.0
 *
 * @package    Wp_Mailchimp_Gw
 * @subpackage Wp_Mailchimp_Gw/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">

    <h2 class="wp-heading-inline"><?php echo esc_html(get_admin_page_title()); ?></h2>

    <form method="post" name="wp_mailchimp_gw_options" action="options.php">

        <?php
settings_fields($this->plugin_name);
//Grab all options
$options = get_option($this->plugin_name);

// Modal customization vars
$wp_mailchimp_gw_api = $options['wp_mailchimp_gw_api'];
?>

        <h2 class="wp-heading-inline"><?php _e('Mailchimp API Key', $this->plugin_name);?></h2>
        <fieldset class="<?php echo $this->plugin_name; ?>-admin-api">
            <input type="text" class="<?php echo $this->plugin_name; ?>-api" id="<?php echo $this->plugin_name; ?>-api"
                name="<?php echo $this->plugin_name; ?>[wp_mailchimp_gw_api]"
                value="<?php echo $wp_mailchimp_gw_api; ?>" size="40" />
        </fieldset>

        <?php submit_button(__('Save all changes', $this->plugin_name), 'primary', 'submit', true);?>


    </form>

</div>