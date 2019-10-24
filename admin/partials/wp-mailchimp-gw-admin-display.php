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

    <h2 class="wp-heading-inline"><?php esc_html(get_admin_page_title()); ?></h2>

    <form method="post" id="wp_mailchimp_gw_options" name="wp_mailchimp_gw_options" action="options.php">

        <?php
        settings_fields($this->plugin_name);
        //Grab all options
		$options = get_option($this->plugin_name);
        ?>

        <h2 class="wp-heading-inline"><?php esc_html_e('Mailchimp API Key', $this->plugin_name);?></h2>
        <fieldset class="<?php echo esc_html($this->plugin_name); ?>-admin-api">
            <input type="text" class="<?php echo esc_html($this->plugin_name); ?>-api"
                id="<?php echo esc_html($this->plugin_name); ?>-api"
                name="<?php echo esc_html($this->plugin_name); ?>[wp_mailchimp_gw_api]"
                value="<?php echo esc_html($options['wp_mailchimp_gw_api']); ?>" size="40" />
        </fieldset>

        <h2 class="wp-heading-inline"><?php esc_html_e('API Endpoints', $this->plugin_name);?></h2>
        <div class="endpoint">
            <input id="endpoint-slug" type="text" value=""
                placeholder="<?php esc_html_e('endpoint name', $this->plugin_name);?>" />
            <input id="endpoint-listid" type="text" value=""
                placeholder="<?php esc_html_e('list ID', $this->plugin_name);?>" />
        </div>
        <p class="submit">
            <button id="add" class="button button-primary">
                <?php esc_html_e('Add API Endpoint', $this->plugin_name); ?>
            </button>
        </p>

        <div id="endpoints">
            <?php
            if ( ! empty($options['endpoints']) ) {
                foreach ( $options['endpoints'] as $key => $endpoint ) {
                	echo '<div class="endpoint">';
                	echo '<input type="text" name="wp-mailchimp-gw[endpoints][' . esc_html($key) . '][slug]" value="' . esc_html($endpoint['slug']) . '" readonly/>';
                	echo '<input type="hidden" name="wp-mailchimp-gw[endpoints][' . esc_html($key) . '][listid]" value="' . esc_html($endpoint['listid']) . '" readonly/>';
                    echo '<span id="remove" class="dashicons dashicons-trash"></span>';
                    echo '<span class="wp-mailchimp-url-preview">url: /wp-json/' . esc_html($endpoint['slug']) . '/v1/submit</span>';
                    echo '</div>';
                }
            }
            ?>
        </div>

        <?php submit_button(__('Save all changes', $this->plugin_name), 'primary', 'submit', true); ?>

    </form>


</div>
