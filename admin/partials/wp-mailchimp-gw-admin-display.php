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

    <form method="post" id="wp_mailchimp_gw_options" name="wp_mailchimp_gw_options" action="options.php">

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

        <h2 class="wp-heading-inline"><?php _e('API Endpoints', $this->plugin_name);?></h2>
        <div class="endpoint"><input id="add-endpoint" type="text" value="" /></div>
        <p class="submit">
            <button id="add" class="button button-primary">
                <?php _e('Add API Endpoint', $this->plugin_name); ?>
            </button>
        </p>

        <div id="endpoints">
            <?php
            foreach ($options['endpoints'] as $key => $endpoint) {
                echo '<div class="endpoint"><input type="text" name="wp-mailchimp-gw[endpoints][' . $key . ']" value="' . $key . '" /><span id="remove" class="dashicons dashicons-trash"></span></div>';
            }
            ?>
        </div>

        <?php submit_button(__('Save all changes', $this->plugin_name), 'primary', 'submit', true); ?>

    </form>

</div>