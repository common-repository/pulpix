<?php
/**
 * custom option and settings
 */
function pulpix_settings_init() {
 // register a new setting for "pulpix" page
 register_setting( 'pulpix', 'pulpix_options' );

 // register a new section in the "pulpix" page
 add_settings_section(
 'pulpix_section_developers',
  null,
 'pulpix_section_developers_cb',
 'pulpix'
 );

 // register a new field in the "pulpix_section_developers" section, inside the "pulpix" page
 add_settings_field(
 'pulpix_field_website_id', // as of WP 4.6 this value is used only internally
 // use $args' label_for to populate the id inside the callback
 __( 'Website Id', 'pulpix' ),
 'pulpix_field_website_id_cb',
 'pulpix',
 'pulpix_section_developers',
 [
 'label_for' => 'pulpix_field_website_id',
 'class' => 'pulpix_row',
 ]
 );
}

/**
 * register our pulpix_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'pulpix_settings_init' );

/**
 * custom option and settings:
 * callback functions
 */

// developers section cb

// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function pulpix_section_developers_cb( $args ) {

}

// website_id field cb

// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.
function pulpix_field_website_id_cb( $args ) {
 // get the value of the setting we've registered with register_setting()
 $options = get_option( 'pulpix_options' );
 // output the field
 ?>
 <input
    id="<?php echo esc_attr( $args['label_for'] ); ?>"
    name="pulpix_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
    type="text"
    class="ltr"
    value="<?php echo esc_attr($options[ $args['label_for'] ]) ?>"
    placeholder="Website Id">

 <p class="description">Your website id as defined in your Pulpix account.<br>If you don't have one yet, please first sign-up:</p>
 <a href="https://dashboard.pulpix.com/signup" class="button-secondary">Sign-up</a>
 <?php
}

/**
 * top level menu
 */
function pulpix_options_page() {
 // add top level menu page
add_submenu_page(
    'options-general.php',
    'Pulpix Settings',
    'Pulpix',
    'manage_options',
    'pulpix',
    'pulpix_options_page_html'
);
}

/**
 * register our pulpix_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'pulpix_options_page' );




/**
 * top level menu:
 * callback functions
 */
function pulpix_options_page_html() {
 // check user capabilities
 if ( ! current_user_can( 'manage_options' ) ) {
 return;
 }
 // show error/update messages
 settings_errors( 'pulpix_messages' );
 ?>
 <div class="wrap">
 <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
 <form action="options.php" method="post">
 <?php
 // output security fields for the registered setting "pulpix"
 settings_fields( 'pulpix' );
 // output setting sections and their fields
 // (sections are registered for "pulpix", each field is registered to a specific section)
 do_settings_sections( 'pulpix' );
 // output save settings button
 submit_button( 'Save Settings' );
 ?>
 </form>
 </div>
 <?php
}

add_filter( 'plugin_action_links_pulpix/pulpix.php', 'add_action_links' );

function add_action_links ( $links ) {
 $mylinks = array(
 '<a href="' . admin_url( 'options-general.php?page=pulpix' ) . '">Settings</a>',
 );
return array_merge( $links, $mylinks );
}
