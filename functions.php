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
 * Create Sample Books (Direct PHP Function)
 * 
 * Call this in the browser console: bookstoreCreateSampleBooks()
 * Or access it via: /wp-admin/admin-ajax.php?action=create_sample_books
 *
 * @return void
 */
function bookstore_create_sample_books_direct() {
	$books = array(
		array(
			'title'   => 'The Midnight Library',
			'excerpt' => 'A dazzling novel about a woman who gets the chance to explore all the different lives she could have lived.',
			'author'  => 'Matt Haig',
			'genres'  => array( 'Fiction', 'Fantasy' ),
		),
		array(
			'title'   => 'Project Hail Mary',
			'excerpt' => 'A lone astronaut must save Earth from extinction in this thrilling science fiction adventure.',
			'author'  => 'Andy Weir',
			'genres'  => array( 'Science Fiction', 'Adventure' ),
		),
		array(
			'title'   => 'The Silent Patient',
			'excerpt' => 'A psychological thriller about a woman found covered in blood with a gun in her hand.',
			'author'  => 'Alex Michaelides',
			'genres'  => array( 'Thriller', 'Mystery' ),
		),
		array(
			'title'   => 'Educated',
			'excerpt' => 'A memoir about a young woman who leaves her survivalist family to pursue education.',
			'author'  => 'Tara Westover',
			'genres'  => array( 'Memoir', 'Biography' ),
		),
		array(
			'title'   => 'Lessons in Chemistry',
			'excerpt' => 'A woman scientist fights for her place in a male-dominated 1960s world.',
			'author'  => 'Bonnie Garmus',
			'genres'  => array( 'Historical Fiction', 'Women\'s Fiction' ),
		),
		array(
			'title'   => 'The Thursday Murder Club',
			'excerpt' => 'Four unlikely friends meet weekly to investigate unsolved killings in this charming mystery.',
			'author'  => 'Richard Osman',
			'genres'  => array( 'Mystery', 'Comedy' ),
		),
	);

	$created = 0;
	foreach ( $books as $book_data ) {
		// Create the book post
		$book_id = wp_insert_post( array(
			'post_type'    => 'book',
			'post_title'   => $book_data['title'],
			'post_excerpt' => $book_data['excerpt'],
			'post_content' => $book_data['excerpt'],
			'post_status'  => 'publish',
		) );

		if ( ! is_wp_error( $book_id ) && $book_id ) {
			// Add author
			if ( ! empty( $book_data['author'] ) ) {
				$author_term = term_exists( $book_data['author'], 'author' );
				if ( ! $author_term ) {
					$author_term = wp_insert_term( $book_data['author'], 'author' );
				}
				if ( ! is_wp_error( $author_term ) ) {
					wp_set_post_terms( $book_id, $author_term['term_id'], 'author' );
				}
			}

			// Add genres
			if ( ! empty( $book_data['genres'] ) ) {
				$genre_ids = array();
				foreach ( $book_data['genres'] as $genre ) {
					$genre_term = term_exists( $genre, 'genre' );
					if ( ! $genre_term ) {
						$genre_term = wp_insert_term( $genre, 'genre' );
					}
					if ( ! is_wp_error( $genre_term ) ) {
						$genre_ids[] = $genre_term['term_id'];
					}
				}
				if ( ! empty( $genre_ids ) ) {
					wp_set_post_terms( $book_id, $genre_ids, 'genre' );
				}
			}

			$created++;
		}
	}

	return $created;
}

// AJAX endpoint
add_action( 'wp_ajax_create_sample_books', function() {
	$count = bookstore_create_sample_books_direct();
	wp_send_json_success( array( 'created' => $count ) );
} );

// Also make it non-privileged
add_action( 'wp_ajax_nopriv_create_sample_books', function() {
	$count = bookstore_create_sample_books_direct();
	wp_send_json_success( array( 'created' => $count ) );
} );

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

	/**
	 * Default Primary Menu Fallback
	 *
	 * Outputs a useful default menu when no menu is assigned to the Primary Menu location.
	 * This intentionally lists the most common pages (Home, Books, Blog, About, Contact)
	 * and avoids listing the default "Sample Page" that comes with a fresh WP install.
	 */
	function bookstore_default_primary_menu() {
		echo '<ul id="primary-menu" class="menu">';
		// Home
		echo '<li class="menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'bookstore-theme' ) . '</a></li>';

		// Books archive (custom post type)
		$books_link = get_post_type_archive_link( 'book' );
		if ( $books_link ) {
			echo '<li class="menu-item"><a href="' . esc_url( $books_link ) . '">' . esc_html__( 'Books', 'bookstore-theme' ) . '</a></li>';
		}

		// Blogs link: prefer page using 'blogs.php' template, then page_for_posts, then common slugs/titles, then fallback to /blog/
		$blogs_link = '';

		// 1) Page with template 'blogs.php'
		$blogs_page = get_posts( array(
			'post_type'   => 'page',
			'meta_key'    => '_wp_page_template',
			'meta_value'  => 'blogs.php',
			'numberposts' => 1,
		) );

		if ( ! empty( $blogs_page ) ) {
			$blogs_link = get_permalink( $blogs_page[0]->ID );
		}

		// 2) Posts page
		if ( empty( $blogs_link ) ) {
			$page_for_posts = get_option( 'page_for_posts' );
			if ( $page_for_posts ) {
				$blogs_link = get_permalink( $page_for_posts );
			}
		}

		// 3) Common slugs: blog / blogs
		if ( empty( $blogs_link ) ) {
			$slug_page = get_page_by_path( 'blog' );
			if ( ! $slug_page ) {
				$slug_page = get_page_by_path( 'blogs' );
			}
			if ( $slug_page ) {
				$blogs_link = get_permalink( $slug_page->ID );
			}
		}

		// 4) Common titles: Blog / Blogs
		if ( empty( $blogs_link ) ) {
			$title_page = get_page_by_title( 'Blog' );
			if ( ! $title_page ) {
				$title_page = get_page_by_title( 'Blogs' );
			}
			if ( $title_page ) {
				$blogs_link = get_permalink( $title_page->ID );
			}
		}

		// 5) Fallback to /blog/
		if ( empty( $blogs_link ) ) {
			$blogs_link = home_url( '/blog/' );
		}

		echo '<li class="menu-item"><a href="' . esc_url( $blogs_link ) . '">' . esc_html__( 'Blog', 'bookstore-theme' ) . '</a></li>';

		// About page
		$about = get_page_by_path( 'about' );
		if ( $about ) {
			echo '<li class="menu-item"><a href="' . esc_url( get_permalink( $about ) ) . '">' . esc_html__( 'About', 'bookstore-theme' ) . '</a></li>';
		}

		// Contact page
		$contact = get_page_by_path( 'contact' );
		if ( $contact ) {
			echo '<li class="menu-item"><a href="' . esc_url( get_permalink( $contact ) ) . '">' . esc_html__( 'Contact', 'bookstore-theme' ) . '</a></li>';
		}

		// 404 test page: prefer page with template '404.php', then slug '404', then fallback
		$notfound_link = '';
		$nf_page = get_posts( array(
			'post_type'   => 'page',
			'meta_key'    => '_wp_page_template',
			'meta_value'  => '404.php',
			'numberposts' => 1,
			'post_status' => 'any',
		) );

		if ( ! empty( $nf_page ) ) {
			$notfound_link = get_permalink( $nf_page[0]->ID );
		}

		if ( empty( $notfound_link ) ) {
			$slug_404 = get_page_by_path( '404' );
			if ( $slug_404 ) {
				$notfound_link = get_permalink( $slug_404->ID );
			}
		}

		if ( empty( $notfound_link ) ) {
			$notfound_link = home_url( '/404' );
		}

		echo '<li class="menu-item"><a href="' . esc_url( $notfound_link ) . '">' . esc_html__( '404', 'bookstore-theme' ) . '</a></li>';

		echo '</ul>';
	}

	// Load text domain for translations
	load_theme_textdomain( 'bookstore-theme', get_template_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'bookstore_theme_setup' );

/**
 * Ensure a Blogs page exists (admin helper)
 *
 * Creates a published page using the `blogs.php` template if no suitable page exists.
 * Runs on admin_init once and stores a flag in options to avoid repeating.
 */
function bookstore_ensure_blogs_page() {
	// Only run in admin and only once
	if ( ! is_admin() ) {
		return;
	}

	if ( get_option( 'bookstore_blogs_page_created' ) ) {
		return;
	}

	// 1) Check for a page already using the blogs.php template
	$pages = get_posts( array(
		'post_type'   => 'page',
		'meta_key'    => '_wp_page_template',
		'meta_value'  => 'blogs.php',
		'numberposts' => 1,
		'post_status' => 'any',
	) );

	if ( ! empty( $pages ) ) {
		update_option( 'bookstore_blogs_page_created', 1 );
		update_option( 'bookstore_blogs_page_id', $pages[0]->ID );
		return;
	}

	// 2) Check for common slugs
	$slug_page = get_page_by_path( 'blog' ) ?: get_page_by_path( 'blogs' );
	if ( $slug_page ) {
		update_option( 'bookstore_blogs_page_created', 1 );
		update_option( 'bookstore_blogs_page_id', $slug_page->ID );
		return;
	}

	// 3) Create the page
	$new_page = array(
		'post_title'   => wp_strip_all_tags( 'Blog' ),
		'post_content' => '',
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_name'    => 'blog',
	);

	$page_id = wp_insert_post( $new_page );
	if ( $page_id && ! is_wp_error( $page_id ) ) {
		update_post_meta( $page_id, '_wp_page_template', 'blogs.php' );
		update_option( 'bookstore_blogs_page_created', 1 );
		update_option( 'bookstore_blogs_page_id', $page_id );
	}
}

add_action( 'admin_init', 'bookstore_ensure_blogs_page' );

/**
 * Ensure a 404 test page exists (admin helper)
 *
 * Creates a published page using the `404.php` template so the navbar can link to it.
 */
function bookstore_ensure_404_page() {
	// Only run in admin and only once
	if ( ! is_admin() ) {
		return;
	}

	if ( get_option( 'bookstore_404_page_created' ) ) {
		return;
	}

	// 1) Check for a page already using the 404.php template
	$pages = get_posts( array(
		'post_type'   => 'page',
		'meta_key'    => '_wp_page_template',
		'meta_value'  => '404.php',
		'numberposts' => 1,
		'post_status' => 'any',
	) );

	if ( ! empty( $pages ) ) {
		update_option( 'bookstore_404_page_created', 1 );
		update_option( 'bookstore_404_page_id', $pages[0]->ID );
		return;
	}

	// 2) Check for slug '404'
	$slug_page = get_page_by_path( '404' );
	if ( $slug_page ) {
		update_option( 'bookstore_404_page_created', 1 );
		update_option( 'bookstore_404_page_id', $slug_page->ID );
		return;
	}

	// 3) Create the page
	$new_page = array(
		'post_title'   => wp_strip_all_tags( '404' ),
		'post_content' => '',
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_name'    => '404',
	);

	$page_id = wp_insert_post( $new_page );
	if ( $page_id && ! is_wp_error( $page_id ) ) {
		update_post_meta( $page_id, '_wp_page_template', '404.php' );
		update_option( 'bookstore_404_page_created', 1 );
		update_option( 'bookstore_404_page_id', $page_id );
	}
}

add_action( 'admin_init', 'bookstore_ensure_404_page' );

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
 * Register Additional Custom Post Types
 *
 * Registers Review, Author, and Event post types.
 *
 * @return void
 */
function bookstore_theme_register_additional_post_types() {
	// Review Post Type
	$review_labels = array(
		'name'                  => esc_html_x( 'Reviews', 'Post Type General Name', 'bookstore-theme' ),
		'singular_name'         => esc_html_x( 'Review', 'Post Type Singular Name', 'bookstore-theme' ),
		'menu_name'             => esc_html__( 'Reviews', 'bookstore-theme' ),
		'all_items'             => esc_html__( 'All Reviews', 'bookstore-theme' ),
		'add_new_item'          => esc_html__( 'Add New Review', 'bookstore-theme' ),
		'edit_item'             => esc_html__( 'Edit Review', 'bookstore-theme' ),
	);

	$review_args = array(
		'label'               => esc_html__( 'Review', 'bookstore-theme' ),
		'description'         => esc_html__( 'Book reviews and ratings', 'bookstore-theme' ),
		'labels'              => $review_labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments' ),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 6,
		'menu_icon'           => 'dashicons-format-quote',
		'has_archive'         => true,
		'rewrite'             => array( 'slug' => 'reviews' ),
	);

	register_post_type( 'review', $review_args );

	// Author Profile Post Type
	$author_profile_labels = array(
		'name'                  => esc_html_x( 'Author Profiles', 'Post Type General Name', 'bookstore-theme' ),
		'singular_name'         => esc_html_x( 'Author Profile', 'Post Type Singular Name', 'bookstore-theme' ),
		'menu_name'             => esc_html__( 'Author Profiles', 'bookstore-theme' ),
		'all_items'             => esc_html__( 'All Authors', 'bookstore-theme' ),
		'add_new_item'          => esc_html__( 'Add Author Profile', 'bookstore-theme' ),
		'edit_item'             => esc_html__( 'Edit Author Profile', 'bookstore-theme' ),
	);

	$author_profile_args = array(
		'label'               => esc_html__( 'Author Profile', 'bookstore-theme' ),
		'description'         => esc_html__( 'Author profile pages', 'bookstore-theme' ),
		'labels'              => $author_profile_labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'comments' ),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 7,
		'menu_icon'           => 'dashicons-businessman',
		'has_archive'         => true,
		'rewrite'             => array( 'slug' => 'authors' ),
	);

	register_post_type( 'author-profile', $author_profile_args );

	// Event Post Type
	$event_labels = array(
		'name'                  => esc_html_x( 'Events', 'Post Type General Name', 'bookstore-theme' ),
		'singular_name'         => esc_html_x( 'Event', 'Post Type Singular Name', 'bookstore-theme' ),
		'menu_name'             => esc_html__( 'Events', 'bookstore-theme' ),
		'all_items'             => esc_html__( 'All Events', 'bookstore-theme' ),
		'add_new_item'          => esc_html__( 'Add New Event', 'bookstore-theme' ),
		'edit_item'             => esc_html__( 'Edit Event', 'bookstore-theme' ),
	);

	$event_args = array(
		'label'               => esc_html__( 'Event', 'bookstore-theme' ),
		'description'         => esc_html__( 'Book signing events and readings', 'bookstore-theme' ),
		'labels'              => $event_labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 8,
		'menu_icon'           => 'dashicons-calendar',
		'has_archive'         => true,
		'rewrite'             => array( 'slug' => 'events' ),
	);

	register_post_type( 'event', $event_args );
}

add_action( 'init', 'bookstore_theme_register_additional_post_types' );

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

/**
 * AJAX Handler to Add Books
 */
function bookstore_add_book_handler() {
	// Verify nonce but don't die - return error instead
	$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
	
	if ( ! wp_verify_nonce( $nonce, 'bookstore_nonce' ) ) {
		wp_send_json_error( array( 'message' => 'Security check failed' ) );
		return;
	}

	$title = sanitize_text_field( $_POST['title'] ?? '' );
	$excerpt = sanitize_textarea_field( $_POST['excerpt'] ?? '' );
	$author = sanitize_text_field( $_POST['author'] ?? '' );
	$genres = isset( $_POST['genres'] ) ? json_decode( stripslashes( $_POST['genres'] ), true ) : array();

	if ( empty( $title ) ) {
		wp_send_json_error( array( 'message' => 'Title is required' ) );
		return;
	}

	// Create book post
	$book_id = wp_insert_post( array(
		'post_type'    => 'book',
		'post_title'   => $title,
		'post_excerpt' => $excerpt,
		'post_status'  => 'publish',
		'post_content' => $excerpt,
	) );

	if ( is_wp_error( $book_id ) ) {
		wp_send_json_error( array( 'message' => 'Failed to create book' ) );
		return;
	}

	// Add author term if provided
	if ( ! empty( $author ) ) {
		$author_term = term_exists( $author, 'author' );
		if ( $author_term === 0 || $author_term === null ) {
			$author_term = wp_insert_term( $author, 'author' );
		}
		if ( ! is_wp_error( $author_term ) ) {
			wp_set_post_terms( $book_id, $author_term['term_id'], 'author', false );
		}
	}

	// Add genre terms if provided
	if ( ! empty( $genres ) && is_array( $genres ) ) {
		$genre_ids = array();
		foreach ( $genres as $genre ) {
			$genre_term = term_exists( $genre, 'genre' );
			if ( $genre_term === 0 || $genre_term === null ) {
				$genre_term = wp_insert_term( $genre, 'genre' );
			}
			if ( ! is_wp_error( $genre_term ) ) {
				$genre_ids[] = $genre_term['term_id'];
			}
		}
		if ( ! empty( $genre_ids ) ) {
			wp_set_post_terms( $book_id, $genre_ids, 'genre', false );
		}
	}

	wp_send_json_success( array(
		'message' => 'Book added successfully',
		'book_id' => $book_id,
	) );
}

add_action( 'wp_ajax_bookstore_add_book', 'bookstore_add_book_handler' );
add_action( 'wp_ajax_nopriv_bookstore_add_book', 'bookstore_add_book_handler' );

/**
 * Register Customizer Controls for Book Covers
 *
 * Allows admins to customize book cover images and theme settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 */
function bookstore_theme_customize_register( $wp_customize ) {
	// Add a section for book covers
	$wp_customize->add_section( 'bookstore_book_covers', array(
		'title'       => esc_html__( 'Book Covers', 'bookstore-theme' ),
		'description' => esc_html__( 'Customize book cover images and styles', 'bookstore-theme' ),
		'priority'    => 160,
	) );

	// Add controls for book cover styling
	$wp_customize->add_setting( 'bookstore_cover_blur_amount', array(
		'default'           => '12',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'bookstore_cover_blur_amount', array(
		'label'       => esc_html__( 'Cover Blur Amount (px)', 'bookstore-theme' ),
		'description' => esc_html__( 'Blur amount before image loads (0-20)', 'bookstore-theme' ),
		'section'     => 'bookstore_book_covers',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 20,
			'step' => 1,
		),
	) );

	$wp_customize->add_setting( 'bookstore_cover_transition_speed', array(
		'default'           => '600',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'bookstore_cover_transition_speed', array(
		'label'       => esc_html__( 'Blur-to-Clear Speed (ms)', 'bookstore-theme' ),
		'description' => esc_html__( 'Animation duration in milliseconds', 'bookstore-theme' ),
		'section'     => 'bookstore_book_covers',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 100,
			'max'  => 2000,
			'step' => 100,
		),
	) );

	// Add section for gallery
	$wp_customize->add_section( 'bookstore_gallery', array(
		'title'       => esc_html__( 'Book Cover Gallery', 'bookstore-theme' ),
		'description' => esc_html__( 'View and manage book cover images', 'bookstore-theme' ),
		'priority'    => 161,
	) );

	$wp_customize->add_setting( 'bookstore_gallery_info', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( new WP_Customize_Control( 
		$wp_customize,
		'bookstore_gallery_info',
		array(
			'label'       => esc_html__( 'Covers Location', 'bookstore-theme' ),
			'description' => esc_html__( 'Book covers are stored in: /wp-content/themes/personalproject-wp/assets/images/', 'bookstore-theme' ),
			'section'     => 'bookstore_gallery',
			'type'        => 'hidden',
		)
	) );
}

add_action( 'customize_register', 'bookstore_theme_customize_register' );

/**
 * Output Customizer Settings as CSS
 *
 * Applies customizer values to the theme dynamically.
 *
 * @return void
 */
function bookstore_theme_customize_css() {
	$blur_amount = get_theme_mod( 'bookstore_cover_blur_amount', 12 );
	$transition_speed = get_theme_mod( 'bookstore_cover_transition_speed', 600 );

	$css = '
	.book-card-image {
		transition: filter ' . intval( $transition_speed ) . 'ms ease, opacity 400ms ease;
		filter: blur(' . intval( $blur_amount ) . 'px);
	}
	';

	wp_add_inline_style( 'bookstore-style', $css );
}

add_action( 'wp_enqueue_scripts', 'bookstore_theme_customize_css' );

