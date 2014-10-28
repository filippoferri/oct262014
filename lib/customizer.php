<?php
//Customization
//Remove customizer submenu
function ff_remove_customize_submenu_page() {
  remove_submenu_page( 'themes.php', 'customize.php' );
}

add_action( 'admin_menu', 'ff_remove_customize_submenu_page' );
/**
 * The configuration options for the Shoestrap Customizer
 */
function ff_add_customizer_menu() {
  add_menu_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'customize.php', NULL, NULL, 10 );
  add_submenu_page( 'customize.php', 'Import', 'Import', 'edit_theme_options', 'import', 'ff_customizer_import_option_page' );
  add_submenu_page( 'customize.php', 'Export', 'Export', 'edit_theme_options', 'export', 'ff_customizer_export_option_page' );
}

add_action( 'admin_menu', 'ff_add_customizer_menu' );

function shoestrap_customizer_config() {

	$args = array(

		// Change the logo image. (URL)
		// If omitted, the default theme info will be displayed.
		// A good size for the logo is 250x50.
		'logo_image'   => get_template_directory_uri() . '/assets/img/admin-logo.png',

		// The color of active menu items, help bullets etc.
		'color_active' => '#ffe000',

		// Color used for secondary elements and desable/inactive controls
		'color_light'  => '#646464',

		// Color used for button-set controls and other elements
		'color_select' => '#5c6977',

		// Color used on slider controls and image selects
		'color_accent' => '#ffe000',

		// The generic background color.
		// You should choose a dark color here as we're using white for the text color.
		'color_back'   => '#191919',

		// If Kirki is embedded in your theme, then you can use this line to specify its location.
		// This will be used to properly enqueue the necessary stylesheets and scripts.
		// If you are using kirki as a plugin then please delete this line.
		'url_path'     => get_template_directory_uri() . '/admin/',

		// If you want to take advantage of the backround control's 'output',
		// then you'll have to specify the ID of your stylesheet here.
		// The "ID" of your stylesheet is its "handle" on the wp_enqueue_style() function.
		// http://codex.wordpress.org/Function_Reference/wp_enqueue_style
		'stylesheet_id' => 'customizer',

	);

	return $args;

}
add_filter( 'kirki/config', 'shoestrap_customizer_config' );


/**
 * Change the url of the Close link in the /wp-admin/customize.php page
 * See http://wordpress.stackexchange.com/q/116257
 */
function change_close_url_wpse_116257() {
    $url = get_admin_url(); // Edit this to your needs
    printf( "<script>
                jQuery(document).ready( function(){
                    jQuery('#customize-header-actions a.customize-controls-close').attr('href', '%s');
                });
            </script>"
            , esc_js( $url ) );
}
add_action( 'customize_controls_print_footer_scripts', 'change_close_url_wpse_116257' );

// Turn on Output Buffering
// =============================================================================
ob_start();

// Import Page
// =============================================================================

function ff_customizer_import_option_page() {
?>
  <div class="wrap">
    <div id="icon-tools" class="icon32"><br></div>
    <h2>Customizer Import</h2>
    <?php
    if ( isset( $_FILES['import'] ) && check_admin_referer( 'ff-customizer-import' ) ) {
      if ( $_FILES['import']['error'] > 0 ) {
        wp_die( 'An error occured.' );
      } else {
        $file_name = $_FILES['import']['name'];
        $file_ext  = strtolower( end( explode( '.', $file_name ) ) );
        $file_size = $_FILES['import']['size'];
        if ( ( $file_ext == 'json' ) && ( $file_size < 500000 ) ) {
          $encode_options = file_get_contents( $_FILES['import']['tmp_name'] );
          $options        = json_decode( $encode_options, true );
          foreach ( $options as $key => $value ) {
            set_theme_mod( $key, $value );
          }
          echo '<div class="updated"><p>All options were restored successfully!</p></div>';
        } else {
          echo '<div class="error"><p>Invalid file or file size too big.</p></div>';
        }
      }
    }
    ?>
    <form method="post" enctype="multipart/form-data">
      <?php wp_nonce_field( 'ff-customizer-import' ); ?>
      <p>Howdy! Upload your Custom Settings (XCS) file and we&apos;ll import the options into this site.</p>
      <p>Choose a XCS (.json) file to upload, then click Upload file and import.</p>
      <p>Choose a file from your computer: <input type="file" id="customizer-upload" name="import"></p>
      <p class="submit">
        <input type="submit" name="submit" id="customizer-submit" class="button" value="Upload file and import" disabled>
      </p>
    </form>
  </div>
<?php
}

// Export Page
// =============================================================================

function ff_customizer_export_option_page() {
  if ( ! isset( $_POST['export'] ) ) {
  ?>
    <div class="wrap">
      <div id="icon-tools" class="icon32"><br></div>
      <h2>Customizer Export</h2>
      <form method="post">
        <?php wp_nonce_field( 'ff-customizer-export' ); ?>
        <p>When you click the button below WordPress will create a JSON file for you to save to your computer.</p>
        <p>This format, which we call Options Settings or XCS, will contain your Options settings for this website.</p>
        <p>Once you&apos;ve saved the download file, you can use the Options Import function to import the previusly exported settings.</p>
        <p class="submit"><input type="submit" name="export" class="button button-primary" value="Download XCS File"></p>
      </form>
    </div>
  <?php
  } elseif ( check_admin_referer( 'ff-customizer-export' ) ) {

    $blogname  = strtolower( str_replace( ' ', '', get_option( 'blogname' ) ) );
    $date      = date( 'm-d-Y' );
    $json_name = $blogname . '-options-' . $date;
    $options   = get_theme_mods();

    unset( $options['nav_menu_locations'] );

    foreach ( $options as $key => $value ) {
      $value              = maybe_unserialize( $value );
      $need_options[$key] = $value;
    }

    $json_file = json_encode( $need_options );

    ob_clean();

    echo $json_file;

    header( 'Content-Type: text/json; charset=' . get_option( 'blog_charset' ) );
    header( 'Content-Disposition: attachment; filename="' . $json_name . '.json"' );

    exit();

  }
}

// Include Preloader
// =============================================================================

function ff_customizer_preloader() {
  echo '<style type="text/css"> @import url("//fonts.googleapis.com/css?family=Lato:100,300,900"); body { overflow: hidden !important; } #ff-customizer-preloader { position: fixed; top: 0; left: 0; right: 0; bottom: 0; text-align: center; background-color: #fff; z-index: 9999999; opacity:1; } #ff-customizer-preloader #ff-customizer-preloader-inner { display: table; position: absolute; top: 50%; left: 50%; width: 450px; margin: -90px 0 0 -225px; background-repeat: no-repeat; background-position: center 155px; background-color: #fff; } #ff-customizer-preloader p.status { display: table-cell; vertical-align: middle; position: relative; padding: 0 0 10px; font-family: Lato, "Helvetica Neue", Helvetica, Arial, sans-serif; line-height: 1.1; color: #333; } #ff-customizer-preloader p.status span { position: relative; display: block; z-index: 99999999; } #ff-customizer-preloader p.status span.loading { margin-left: -2px; font-size: 84px; font-weight: 100; letter-spacing: -2px; text-transform: uppercase; } #ff-customizer-preloader p.status span.step { margin-top: 9px; font-size: 18px; font-weight: 300; } #ff-customizer-preloader p.status > span.progress { margin-top: 9px; font-weight: 900; } #ff-customizer-preloader h1.powered-by { position: absolute; left: 0; right: 0; bottom: 24px; margin-right: -6px; font-size: 14px; font-weight: 300; letter-spacing: 6px; line-height: 1.1; text-transform: uppercase; color: #b5b5b5; } </style><div id="ff-customizer-preloader"><div id="ff-customizer-preloader-inner"><p class="status"><span class="loading">Loading</span><span class="step">(Step 2 of 2) Initializing Live Preview</span><span class="progress"></span></p></div><h1 class="powered-by">Powered by Filippo Ferri</h1></div>';
}

add_action( 'customize_controls_print_styles', 'ff_customizer_preloader' );
