<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://m4v1.work
 * @since      1.0.0
 *
 * @package    Wp_Mailchimp_Gw
 * @subpackage Wp_Mailchimp_Gw/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Mailchimp_Gw
 * @subpackage Wp_Mailchimp_Gw/public
 * @author     Marco Vivi <marco.vivi@gmail.com>
 */
class Wp_Mailchimp_Gw_Public
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-mailchimp-gw-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-mailchimp-gw-public.js', array( 'jquery' ), $this->version, false);
    }

    /**
     * Register Wordpress API endpoints that web forms can use to submit data to mailchimp.
     *
     * @since    1.0.0
     */
    public function add_api_endpoints()
    {
        $options = get_option($this->plugin_name);

        if (!empty($options['endpoints'])) {
            foreach ($options['endpoints'] as $key => $endpoint) {
                register_rest_route('mailchimp-gw/v1', '/' . $key . '/submit/', array(
                    'methods' => WP_REST_Server::CREATABLE,
                    'callback' => 'wp_mailchimp_submit',
                    'args' => array(
                        'name' => array(
                            'required' => true,
                            'sanitize_callback' => function ($param, $request, $key) {
                                return filter_var($param, FILTER_SANITIZE_STRING);
                            }
                        ),
                        'surname' => array(
                            'required' => false,
                            'sanitize_callback' => function ($param, $request, $key) {
                                return filter_var($param, FILTER_SANITIZE_STRING);
                            }
                        ),
                        'email' => array(
                            'required' => true,
                            'validate_callback' => function ($param, $request, $key) {
                                return filter_var($param, FILTER_VALIDATE_EMAIL);
                            }
                        ),
                    )
                ));
            }
        }
    }

    /**
     * Callback that handles local API data submission to remote Mailchimp API.
     *
     * @since    1.0.0
     */
    public function wp_mailchimp_submit(WP_REST_Request $request)
    {
        $name = $request->get_param('name');
        $surname = $request->get_param('surname');
        $email = $request->get_param('email');

        $options = get_option($this->plugin_name);

        $MailChimp = new MailChimp($options['wp_mailchimp_gw_api']);

        $list_id = '';

        if (!empty($options['endpoints'])) {
            $slug = prev(end(explode("/", $request->get_url_params())));
            $list_id = $options['endpoints'][$slug]['listid'];
        }

        $result = $MailChimp->post("lists/$list_id/members", [
                    'email_address' => $email,
                    'status' => 'subscribed',
                    'source' => 'Sito Web',
                    'merge_fields' => ['FNAME'=>$name, 'LNAME'=>$surname],
                ]);

        if ($MailChimp->success()) {
            $data = [
            'success' => true,
            'result' => $result
            ];

            return new WP_REST_Response($data, 200);
        } else {
            $data = [
            'success' => false,
            'lasterror' => $MailChimp->getLastError(),
            'lastresponse' => $MailChimp->getLastResponse(),
            'result' => $result
            ];

            $to = 'info@pkctravelinsurance.com';
            $subject = 'Errore Form Newsletter assicurazioneviaggio.it';
            $message = "L'utente {$name} {$surname} ha tentato la registrazione con la mail: {$email} ma si è verificato un errore.";
            wp_mail($to, $subject, $message);

            return new WP_REST_Response($data, 400);
        }
    }
}