<?php
if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}
define('POST_TYPES', ['page', 'post']);
define('PLACEHOLDER_IMAGE_OGP', get_stylesheet_directory_uri() . '/assets/images/placeholder/og-image_400x248.png');
define('PLACEHOLDER-THUMB', get_stylesheet_directory_uri() . '/assets/images/placeholder/og-image_400x248.png');
define('PLACEHOLDER_DESCRIPTION_META_POST', 'カインズのインターンシップでは、業務体験をはじめキャリア形成相談や就活の進め方、地域貢献などを体験できます。就活の不安をなくし、未来の可能性を広げませんか。じぶんらしいキャリア、一緒に見つけよう。');
define('PLACEHOLDER_KEYWORDS_META_POST', 'カインズ,カインズホーム,cainz,インターン,インターンシップ,2023,採用,新卒,既卒,第2新卒,小売,ホームセンター,学生');
define('PLACEHOLDER_KEYWORDS_META', 'カインズ,カインズホーム,cainz,インターン,インターンシップ,2023,採用,新卒,既卒,第2新卒,小売,ホームセンター,学生');

// setup
function internship_setup() {
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'internship_setup' );

// load style css
function internship_enqueue_style() {
	wp_enqueue_style( 'internship-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'internship_enqueue_style' );


/**
 * Generate HTML for post thumbnails
 *
 * @param string $size The thumbnail size to use
 * @return string The HTML for the post thumbnail image
 */
function get_handle_thumbnail($size){
	$placeholder = defined("PLACEHOLDER-".$size) ? constant("PLACEHOLDER-".$size) : null;
	$images = '';
	if ( has_post_thumbnail() ) {
	  $images = '<img src="'. get_the_post_thumbnail_url(null, $size).'" alt="'. get_the_title() .'" loading="lazy">';
	}
	elseif(!empty($placeholder)){
		$images = '<img src="'. $placeholder . '" alt="'. get_the_title() .'" loading="lazy">';
	}
	else{
		$images = '<img src="'. constant('PLACEHOLDER-THUMB') . '" alt="'. get_the_title() .'" loading="lazy">';
	}
	return $images;
}


/**
 * Generate HTML for displaying post thumbnails
 *
 * @param string $size The thumbnail size to use
 * @return string The HTML for the post thumbnail image
 */
function handle_thumbnail($size){
	$placeholder = defined("PLACEHOLDER-".$size) ? constant("PLACEHOLDER-".$size) : null;
	$images = '';
	if ( has_post_thumbnail() ) {
		$images = the_post_thumbnail($size, array('loading' => 'lazy', 'alt'   => get_the_title() ) );
	}
	elseif(!empty($placeholder)){
		$images = '<img src="'. $placeholder . '" alt="'. get_the_title() .'" loading="lazy">';
	}
	else{
		$images = '<img src="'. constant('PLACEHOLDER-THUMB') . '" alt="'. get_the_title() .'" loading="lazy">';
	}
	return print $images;
}

/**
 * Generate HTML for displaying thumbnails by id
 *
 * @param int $id  attachment image
 * @param string $size The thumbnail size to use
 * @param string $alt alt image
 * @return string The HTML for the post thumbnail image
 */
function handle_thumbnail_id($id, $size = 'NEWS-THUMB', $alt = ''){
	$placeholder = defined("PLACEHOLDER-".$size) ? constant("PLACEHOLDER-".$size) : null;
	$images = wp_get_attachment_image_url($id, $size);
	if ($images) {
	  $images = '<figure><img src="'. wp_get_attachment_image_url($id, $size).'" alt="'. $alt .'" loading="lazy"></figure>';
	}
	elseif(!empty($placeholder)){
		$images = '<img src="'. $placeholder . '" alt="'. alt() .'" loading="lazy">';
	}
	else{
		$images = '<img src="'. constant('PLACEHOLDER-THUMB') . '" alt="'. $alt .'" loading="lazy">';
	}
	return print $images;
}

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Disable global-styles-inline-css
add_action( 'wp_enqueue_scripts', 'remove_global_styles' );
function remove_global_styles(){
    wp_dequeue_style( 'global-styles' );
		wp_dequeue_style( 'classic-theme-styles' );
		wp_dequeue_style( 'wp-block-library' );
}

function get_id_by_slug($page_slug) {
	// $page_slug = "parent-page"; in case of parent page
	// $page_slug = "parent-page/sub-page"; in case of inner page
	$page = get_page_by_path($page_slug);
	if ($page) {
			return $page->ID;
	} else {
			return null;
	}
}
// hide admin bar

/**
 * Get the slug of a category by its name.
 *
 * @param string $category_name The name of the category.
 *
 * @return string|null The slug of the category, or null if it does not exist.
 */
function get_category_slug_by_name( $category_name, $taxonomy = 'category' ) {
	$category = get_term_by( 'name', $category_name, $taxonomy );
	if ( $category ) {
			return $category->slug;
	} else {
			return null;
	}
}

// remove width & height attributes from images
function remove_img_attr ($html)
{
	return preg_replace('/(width|height)="\d+"\s/', "", $html);
}
add_filter( 'post_thumbnail_html', 'remove_img_attr' );

add_filter( 'jetpack_enable_open_graph', '__return_false' );
