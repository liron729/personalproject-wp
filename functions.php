<?php
/**
 * Bookstore Theme Functions
 *
 * This file contains all theme setup and configuration functions.
 *
 * @package BookstoreTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Theme Setup
 *
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @return void
 */
function bookstore_theme_setup() {
	// Add support for post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add support for title tag
	add_theme_support( 'title-tag' );

	// Add support for custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Add support for custom background
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) );

	// Add support for custom header
	add_theme_support( 'custom-header', array(
		'default-image'      => '',
		'width'              => 1000,
		'height'             => 250,
		'flex-height'        => true,
		'flex-width'         => true,
		'default-text-color' => '000000',
	) );

	// Add HTML5 support
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'script',
		'style',
	) );

	// Add support for post formats
	add_theme_support( 'post-formats', array(
		'aside',
		'gallery',
		'quote',
		'video',
	) );

	// Add automatic feed links
	add_theme_support( 'automatic-feed-links' );

	// Register navigation menus
	register_nav_menus( array(
		'primary-menu' => esc_html__( 'Primary Menu', 'bookstore-theme' ),
		'footer-menu'  => esc_html__( 'Footer Menu', 'bookstore-theme' ),
	) );

	// Load text domain for translations
	load_theme_textdomain( 'bookstore-theme', get_template_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'bookstore_theme_setup' );

/**
 * Enqueue Styles and Scripts
 *
 * Properly enqueues all CSS and JavaScript files.
 *
 * @return void
 */
function bookstore_theme_enqueue_assets() {
	// Enqueue main stylesheet
	wp_enqueue_style(
		'bookstore-style',
		get_template_directory_uri() . '/assets/css/style.css',
		array(),
		filemtime( get_template_directory() . '/assets/css/style.css' ),
		'all'
	);

	// Enqueue main JavaScript
	wp_enqueue_script(
		'bookstore-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		filemtime( get_template_directory() . '/assets/js/main.js' ),
		true
	);

	// Localize script for AJAX if needed
	wp_localize_script( 'bookstore-main', 'bookstoreTheme', array(
		'ajaxurl'  => admin_url( 'admin-ajax.php' ),
		'siteUrl'  => home_url(),
		'nonce'    => wp_create_nonce( 'bookstore_nonce' ),
	) );

	// Enqueue comment reply script on single post pages
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'bookstore_theme_enqueue_assets' );

/**
 * Register Sidebars/Widget Areas
 *
 * Registers widget areas for the theme.
 *
 * @return void
 */
function bookstore_theme_register_sidebars() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'bookstore-theme' ),
		'id'            => 'primary-sidebar',
		'description'   => esc_html__( 'Main sidebar for pages and posts', 'bookstore-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area 1', 'bookstore-theme' ),
		'id'            => 'footer-sidebar-1',
		'description'   => esc_html__( 'First footer widget area', 'bookstore-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area 2', 'bookstore-theme' ),
		'id'            => 'footer-sidebar-2',
		'description'   => esc_html__( 'Second footer widget area', 'bookstore-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area 3', 'bookstore-theme' ),
		'id'            => 'footer-sidebar-3',
		'description'   => esc_html__( 'Third footer widget area', 'bookstore-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}

add_action( 'widgets_init', 'bookstore_theme_register_sidebars' );

/**
 * Add Custom Body Classes
 *
 * Adds custom classes to the body tag via the body_class filter.
 *
 * @param array $classes The existing body classes.
 * @return array Modified body classes.
 */
function bookstore_theme_body_classes( $classes ) {
	// Add theme name
	$classes[] = 'bookstore-theme';

	// Add sidebar class to posts
	if ( is_singular( 'post' ) ) {
		$classes[] = 'has-sidebar';
	}

	// Add single-book-page class to single books
	if ( is_singular( 'book' ) ) {
		$classes[] = 'single-book-page';
	}

	// Add archive class for book archives
	if ( is_post_type_archive( 'book' ) || is_tax( array( 'genre', 'author' ) ) ) {
		$classes[] = 'book-archive-page';
	}

	// Add sidebar class for pages with sidebars
	if ( is_active_sidebar( 'primary-sidebar' ) && ! is_home() && ! is_front_page() ) {
		$classes[] = 'has-sidebar';
	}

	return $classes;
}

add_filter( 'body_class', 'bookstore_theme_body_classes' );

/**
 * Register Custom Post Type: Book
 *
 * Creates a custom post type for books with support for archives and custom slug.
 *
 * @return void
 */
function bookstore_theme_register_book_post_type() {
	$labels = array(
		'name'                  => esc_html_x( 'Books', 'Post Type General Name', 'bookstore-theme' ),
		'singular_name'         => esc_html_x( 'Book', 'Post Type Singular Name', 'bookstore-theme' ),
		'menu_name'             => esc_html__( 'Books', 'bookstore-theme' ),
		'name_admin_bar'        => esc_html__( 'Book', 'bookstore-theme' ),
		'archives'              => esc_html__( 'Book Archives', 'bookstore-theme' ),
		'parent_item_colon'     => esc_html__( 'Parent Book:', 'bookstore-theme' ),
		'all_items'             => esc_html__( 'All Books', 'bookstore-theme' ),
		'add_new_item'          => esc_html__( 'Add New Book', 'bookstore-theme' ),
		'add_new'               => esc_html__( 'Add New', 'bookstore-theme' ),
		'new_item'              => esc_html__( 'New Book', 'bookstore-theme' ),
		'edit_item'             => esc_html__( 'Edit Book', 'bookstore-theme' ),
		'update_item'           => esc_html__( 'Update Book', 'bookstore-theme' ),
		'view_item'             => esc_html__( 'View Book', 'bookstore-theme' ),
		'view_items'            => esc_html__( 'View Books', 'bookstore-theme' ),
		'search_items'          => esc_html__( 'Search Book', 'bookstore-theme' ),
		'not_found'             => esc_html__( 'Not found', 'bookstore-theme' ),
		'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'bookstore-theme' ),
	);

	$args = array(
		'label'               => esc_html__( 'Book', 'bookstore-theme' ),
		'description'         => esc_html__( 'Custom post type for books', 'bookstore-theme' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-book',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => array(
			'slug'       => 'books',
			'with_front' => true,
		),
		'capability_type'     => 'post',
	);

	register_post_type( 'book', $args );
}

add_action( 'init', 'bookstore_theme_register_book_post_type' );

/**
 * Register Custom Taxonomies for Books
 *
 * Creates genre, author, and format taxonomies for the book post type.
 *
 * @return void
 */
function bookstore_theme_register_book_taxonomies() {
	// Genre Taxonomy (Hierarchical)
	$genre_labels = array(
		'name'                       => esc_html_x( 'Genres', 'Taxonomy General Name', 'bookstore-theme' ),
		'singular_name'              => esc_html_x( 'Genre', 'Taxonomy Singular Name', 'bookstore-theme' ),
		'menu_name'                  => esc_html__( 'Genres', 'bookstore-theme' ),
		'all_items'                  => esc_html__( 'All Genres', 'bookstore-theme' ),
		'parent_item'                => esc_html__( 'Parent Genre', 'bookstore-theme' ),
		'parent_item_colon'          => esc_html__( 'Parent Genre:', 'bookstore-theme' ),
		'new_item_name'              => esc_html__( 'New Genre Name', 'bookstore-theme' ),
		'add_new_item'               => esc_html__( 'Add New Genre', 'bookstore-theme' ),
		'edit_item'                  => esc_html__( 'Edit Genre', 'bookstore-theme' ),
		'update_item'                => esc_html__( 'Update Genre', 'bookstore-theme' ),
		'view_item'                  => esc_html__( 'View Genre', 'bookstore-theme' ),
		'separate_items_with_commas' => esc_html__( 'Separate genres with commas', 'bookstore-theme' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove genres', 'bookstore-theme' ),
		'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'bookstore-theme' ),
		'popular_items'              => esc_html__( 'Popular Genres', 'bookstore-theme' ),
		'search_items'               => esc_html__( 'Search Genres', 'bookstore-theme' ),
		'not_found'                  => esc_html__( 'Not Found', 'bookstore-theme' ),
	);

	$genre_args = array(
		'labels'            => $genre_labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'rewrite'           => array(
			'slug'       => 'genre',
			'with_front' => true,
		),
	);

	register_taxonomy( 'genre', 'book', $genre_args );

	// Author Taxonomy (Non-Hierarchical)
	$author_labels = array(
		'name'                       => esc_html_x( 'Authors', 'Taxonomy General Name', 'bookstore-theme' ),
		'singular_name'              => esc_html_x( 'Author', 'Taxonomy Singular Name', 'bookstore-theme' ),
		'menu_name'                  => esc_html__( 'Authors', 'bookstore-theme' ),
		'all_items'                  => esc_html__( 'All Authors', 'bookstore-theme' ),
		'new_item_name'              => esc_html__( 'New Author Name', 'bookstore-theme' ),
		'add_new_item'               => esc_html__( 'Add New Author', 'bookstore-theme' ),
		'edit_item'                  => esc_html__( 'Edit Author', 'bookstore-theme' ),
		'update_item'                => esc_html__( 'Update Author', 'bookstore-theme' ),
		'view_item'                  => esc_html__( 'View Author', 'bookstore-theme' ),
		'separate_items_with_commas' => esc_html__( 'Separate authors with commas', 'bookstore-theme' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove authors', 'bookstore-theme' ),
		'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'bookstore-theme' ),
		'popular_items'              => esc_html__( 'Popular Authors', 'bookstore-theme' ),
		'search_items'               => esc_html__( 'Search Authors', 'bookstore-theme' ),
		'not_found'                  => esc_html__( 'Not Found', 'bookstore-theme' ),
	);

	$author_args = array(
		'labels'            => $author_labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'rewrite'           => array(
			'slug'       => 'author',
			'with_front' => true,
		),
	);

	register_taxonomy( 'author', 'book', $author_args );

	// Format Taxonomy (Non-Hierarchical)
	$format_labels = array(
		'name'                       => esc_html_x( 'Formats', 'Taxonomy General Name', 'bookstore-theme' ),
		'singular_name'              => esc_html_x( 'Format', 'Taxonomy Singular Name', 'bookstore-theme' ),
		'menu_name'                  => esc_html__( 'Formats', 'bookstore-theme' ),
		'all_items'                  => esc_html__( 'All Formats', 'bookstore-theme' ),
		'new_item_name'              => esc_html__( 'New Format Name', 'bookstore-theme' ),
		'add_new_item'               => esc_html__( 'Add New Format', 'bookstore-theme' ),
		'edit_item'                  => esc_html__( 'Edit Format', 'bookstore-theme' ),
		'update_item'                => esc_html__( 'Update Format', 'bookstore-theme' ),
		'view_item'                  => esc_html__( 'View Format', 'bookstore-theme' ),
		'separate_items_with_commas' => esc_html__( 'Separate formats with commas', 'bookstore-theme' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove formats', 'bookstore-theme' ),
		'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'bookstore-theme' ),
		'popular_items'              => esc_html__( 'Popular Formats', 'bookstore-theme' ),
		'search_items'               => esc_html__( 'Search Formats', 'bookstore-theme' ),
		'not_found'                  => esc_html__( 'Not Found', 'bookstore-theme' ),
	);

	$format_args = array(
		'labels'            => $format_labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'rewrite'           => array(
			'slug'       => 'format',
			'with_front' => true,
		),
	);

	register_taxonomy( 'format', 'book', $format_args );
}

add_action( 'init', 'bookstore_theme_register_book_taxonomies', 0 );
