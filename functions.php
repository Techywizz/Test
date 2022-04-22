<?php
/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */


if ( ! function_exists( 'twentytwentytwo_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

	}

endif;

add_action( 'after_setup_theme', 'twentytwentytwo_support' );

if ( ! function_exists( 'twentytwentytwo_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'twentytwentytwo-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Add styles inline.
		wp_add_inline_style( 'twentytwentytwo-style', twentytwentytwo_get_font_face_styles() );

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'twentytwentytwo-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'twentytwentytwo_styles' );

if ( ! function_exists( 'twentytwentytwo_editor_styles' ) ) :

	/**
	 * Enqueue editor styles.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_editor_styles() {

		// Add styles inline.
		wp_add_inline_style( 'wp-block-library', twentytwentytwo_get_font_face_styles() );

	}

endif;

add_action( 'admin_init', 'twentytwentytwo_editor_styles' );


if ( ! function_exists( 'twentytwentytwo_get_font_face_styles' ) ) :

	/**
	 * Get font face styles.
	 * Called by functions twentytwentytwo_styles() and twentytwentytwo_editor_styles() above.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return string
	 */
	function twentytwentytwo_get_font_face_styles() {

		return "
		@font-face{
			font-family: 'Source Serif Pro';
			font-weight: 200 900;
			font-style: normal;
			font-stretch: normal;
			font-display: swap;
			src: url('" . get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Roman.ttf.woff2' ) . "') format('woff2');
		}

		@font-face{
			font-family: 'Source Serif Pro';
			font-weight: 200 900;
			font-style: italic;
			font-stretch: normal;
			font-display: swap;
			src: url('" . get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Italic.ttf.woff2' ) . "') format('woff2');
		}
		";

	}

endif;

if ( ! function_exists( 'twentytwentytwo_preload_webfonts' ) ) :

	/**
	 * Preloads the main web font to improve performance.
	 *
	 * Only the main web font (font-style: normal) is preloaded here since that font is always relevant (it is used
	 * on every heading, for example). The other font is only needed if there is any applicable content in italic style,
	 * and therefore preloading it would in most cases regress performance when that font would otherwise not be loaded
	 * at all.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_preload_webfonts() {
		?>
		<link rel="preload" href="<?php echo esc_url( get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Roman.ttf.woff2' ) ); ?>" as="font" type="font/woff2" crossorigin>
		<?php
	}

endif;

add_action( 'wp_head', 'twentytwentytwo_preload_webfonts' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';

// Add block patterns
require get_template_directory() . '/inc/constants.php';


/* API City List Function Start */
/*function api_scripts() {
    wp_enqueue_style( 'api-css', get_template_directory_uri() . '/assets/api-css.css', array(), '10.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'api_scripts' );*/

add_action('wp_ajax_getWeatherData', 'getWeatherData');
add_action('wp_ajax_nopriv_getWeatherData', 'getWeatherData');

function getWeatherData(){
	$get_city = $_REQUEST['get_city'];

	if(!empty($get_city)){
		$request = wp_remote_request(API_BASE_URL.'data/2.5/forecast?q='.$get_city.'&APPID='.API_KEY);		
	} 
	if( is_wp_error( $request ) ) {
		return false; 
	} else {
		$body = wp_remote_retrieve_body( $request );
		$data = json_decode( $body );
		$weatherData = $data->list;
		foreach ( $weatherData as $weatherD ) {
			$mainData = $weatherD->main;
			$temp = $weatherD->main->temp;
			$humidity = $weatherD->main->humidity;
			$weatherData = $weatherD->weather;
			$skyweatherData = $weatherD->weather;
			foreach($skyweatherData as $weatherData) {
				$skyweather = $weatherData->main;
				$skyDescriptionweatherData = $weatherData->description;
			}
			
			$windData = $weatherD->wind;
			$speedwindData = $weatherD->wind->speed;
			$dateData = $weatherD->dt_txt;

			echo '<table>
				  <tr>
				    <th>Temperature</th>
				    <th>Humidity</th>
				    <th>Weather</th>
				    <th>Weather Description</th>
				    <th>Wind Speed</th>
				    <th>Date & Time</th>
				  </tr>

				  <tr>
				    <td>'.$temp.'</td>
				    <td>'.$humidity.'</td>
				    <td>'.$skyweather.'</td>
				    <td>'.$skyDescriptionweatherData.'</td>
				    <td>'.$speedwindData.'</td>
				    <td>'.$dateData.'</td>
				  </tr>
				</table>';	
		}
	}
	exit();
}

/* API City List Function End */