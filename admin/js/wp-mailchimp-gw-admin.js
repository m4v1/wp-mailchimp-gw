(function ($) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$('#wp_mailchimp_gw_options').on('click', '#add', function (e) {
		e.preventDefault();
		let slug = $('#endpoint-slug').val();
		let listid = $('#endpoint-listid').val();
		let $endpoint = $('<div class="endpoint">');
		$endpoint.append('<input type="text" name="wp-mailchimp-gw[endpoints][' + slug + '][slug]" value="' + slug + '" readonly/>');
		$endpoint.append('<input type="hidden" name="wp-mailchimp-gw[endpoints][' + slug + '][listid]" value="' + listid + '" readonly/>');
		$endpoint.append('<span id="remove" class="dashicons dashicons-trash"></span></div>');
		$('#endpoints').append($endpoint);
	});

	$('#wp_mailchimp_gw_options').on('click', '#remove', function (e) {
		e.preventDefault();
		$(this).parent('.endpoint').remove();
	});

})(jQuery);
