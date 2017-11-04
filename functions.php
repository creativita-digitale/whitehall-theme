<?php
/**
 * White Hall functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package White_Hall
 */

if ( ! function_exists( 'whitehall_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function whitehall_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on White Hall, use a find and replace
		 * to change 'whitehall-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'whitehall-theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Enable support for Post Formats on posts.
		 *
		 * @link https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'video', 'quote', 'link' ) );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Header', 'whitehall-theme' ),
			'menu-2' => esc_html__( 'Secondary', 'whitehall-theme' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'whitehall_theme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'whitehall_theme_setup' );


/**
 * Register custom fonts.
 */
function whitehall_theme_fonts_url() {
	$fonts_url = '';
	//https://fonts.googleapis.com/css?family=Cormorant+Garamond:400,700|Montserrat:400,700|Open+Sans
	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Cormorat Garamond, Open Sans and Montserrat, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$cormorat_garamond = _x( 'on', 'Cormorat Garamond font: on or off', 'whitehall-theme' );
	$montserrat = _x( 'on', 'Montserrat font: on or off', 'whitehall-theme' );
	$open_sans = _x( 'on', 'Garamond font: on or off', 'whitehall-theme' );

	$font_families = array();

	if ( 'off' !== $cormorat_garamond ) {
		$font_families[] = 'Cormorant Garamond:400,700';
	}

	if ( 'off' !== $montserrat ) {
		$font_families[] = 'Montserrat:400,700';
	}

	if ( 'off' !== $open_sans ) {
		$font_families[] = 'Open Sans';
	}

	if ( in_array( 'on', array( $cormorat_garamond, $montserrat, $open_sans) ) ) {




		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			//'subset' => urlencode( 'latin' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since White Hall 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function whitehall_theme_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'whitehall-theme-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'whitehall_theme_resource_hints', 10, 2 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function whitehall_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'whitehall_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'whitehall_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function whitehall_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'whitehall-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'whitehall-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'whitehall_theme_widgets_init' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since White Hall 1.0
 */
function whitehall_theme_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'whitehall_theme_javascript_detection', 0 );
/**
 * Enqueue scripts and styles.
 */
function whitehall_theme_scripts() {

	// enqueue google fonts
	//https://fonts.googleapis.com/css?family=Cormorant%2BGaramond%3A400%2C700%7CGaramond%3A400%2C700%7COpen%2BSans&subset=latin&ver=4.8.3
	//https://fonts.googleapis.com/css?family=Cormorant+Garamond:400,700|Montserrat:400,700|Open+Sans
	wp_enqueue_style( 'whitehall-theme-fonts', whitehall_theme_fonts_url() );

	wp_enqueue_style( 'whitehall-theme-style', get_stylesheet_uri() );

	wp_enqueue_script( 'whitehall-theme-navigation', get_theme_file_uri('/js/navigation.js') , array('jquery'), '20151215', true );

	wp_localize_script( 'whitehall-theme-navigation', 'whitehallthemeScreenReaderText', array(

		'expand' => __( 'Expand child menu', 'whitehall-theme' ),
		'collapse' => __( 'Collapse child menu', 'whitehall-theme' ),
	));

	wp_enqueue_script( 'whitehall-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'whitehall_theme_scripts' );

/**
 * Enqueue scripts and styles for IE in header.
 */
function whitehall_theme_ie_js_header() {
	echo '<!--[if lt IE 9]>'. "\n";
	echo '<script src="' . esc_url( get_template_directory_uri() . '/js/ie/html5.js' ) . '"></script>'. "\n";
	echo '<script src="' . esc_url( get_template_directory_uri() . '/js/ie/selectivizr.js' ) . '"></script>'. "\n";
	echo '<![endif]-->'. "\n";
}
add_action( 'wp_head', 'whitehall_theme_ie_js_header' );


/**
 * Enqueue scripts and styles for IE in Footer.
 */
function whitehall_theme_ie_js_footer() {
	echo '<!--[if lt IE 9]>'. "\n";
	echo '<script src="' . esc_url( get_template_directory_uri() . '/js/ie/respond.js' ) . '"></script>'. "\n";
	echo '<![endif]-->'. "\n";
}
add_action( 'wp_footer', 'whitehall_theme_ie_js_footer', 20 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load Plugins.
 */
if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
	require get_template_directory() . '/inc/plugins/plugins.php';
}
