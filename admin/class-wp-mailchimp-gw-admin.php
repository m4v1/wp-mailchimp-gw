<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://m4v1.work
 * @since      1.0.0
 *
 * @package    Wp_Mailchimp_Gw
 * @subpackage Wp_Mailchimp_Gw/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Mailchimp_Gw
 * @subpackage Wp_Mailchimp_Gw/admin
 * @author     Marco Vivi <marco.vivi@gmail.com>
 */
class Wp_Mailchimp_Gw_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Mailchimp_Gw_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Mailchimp_Gw_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-mailchimp-gw-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Mailchimp_Gw_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Mailchimp_Gw_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-mailchimp-gw-admin.js', array('jquery'), $this->version, false);

    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu()
    {
        add_options_page('WP Mailchimp Gateway', 'WP Mailchimp', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'));
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */

    public function add_action_links($links)
    {
        $settings_link = array(
            '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page()
    {
        include_once 'partials/wp-mailchimp-gw-admin-display.php';
    }

    /**
     * Validates settings for this plugin.
     *
     * @since    1.0.0
     */
    public function validate($input)
    {
        // All  inputs
        $valid = array();

        // Do not check Mailchimp API KEY
        $valid['wp_mailchimp_gw_api'] = $input['wp_mailchimp_gw_api'];

        return $valid;
    }

    /**
     * Saves/updates settings for this plugin.
     *
     * @since    1.0.0
     */
    public function options_update()
    {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
    }

    /**
     * A custom update checker for WordPress plugins.
     *
     * Useful if you don't want to host your project
     * in the official WP repository, but would still like it to support automatic updates.
     * Despite the name, it also works with themes.
     *
     * @since 1.0.0
     *
     * @link http://w-shadow.com/blog/2011/06/02/automatic-updates-for-commercial-themes/
     * @link https://github.com/YahnisElsts/plugin-update-checker
     * @link https://github.com/YahnisElsts/wp-update-server
     */
    public function update_checker()
    {
        if (is_admin()) {
            $WpbUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
                'https://gitlab.com/m4v1/wp-mailchimp-gw/', //Repo URL.
                __FILE__, //Full path to the main plugin file.
                'wp-biscotti' //Plugin slug.
            );
            $WpbUpdateChecker->setBranch('master');
        }
    }

}