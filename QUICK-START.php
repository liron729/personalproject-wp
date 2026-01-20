<?php
/**
 * QUICK START GUIDE - Bookstore Theme
 *
 * This file is for reference only - delete after reading.
 *
 * @package BookstoreTheme
 */

/**
 * INSTALLATION STEPS
 * ==================
 *
 * 1. Copy the bookstore-theme folder to: wp-content/themes/
 * 2. In WordPress Admin: Appearance > Themes
 * 3. Click "Activate" on Bookstore Theme
 * 4. Go to Appearance > Customize to adjust theme options
 *
 */

/**
 * CREATING YOUR CONTENT
 * ====================
 *
 * BOOKS:
 * ------
 * 1. Go to Posts > Books
 * 2. Click Add New Book
 * 3. Enter:
 *    - Book Title
 *    - Description (in editor)
 *    - Featured Image (book cover)
 *    - Authors (via Authors taxonomy)
 *    - Genres (via Genres taxonomy - hierarchical like categories)
 *    - Format (eBook, Hardcover, Paperback)
 * 4. Publish
 *
 * PAGES:
 * ------
 * 1. Go to Pages > Add New
 * 2. Create pages with these slugs:
 *    - /about (will use page-about.php template)
 *    - /contact (will use page-contact.php template)
 *    - /blog (will use page-blog.php template)
 *
 * MENUS:
 * ------
 * 1. Go to Appearance > Menus
 * 2. Create "Main Menu" and add pages/books
 * 3. Set "Display location" to "Primary Menu"
 * 4. Create "Footer Menu" and set location to "Footer Menu"
 *
 * WIDGETS:
 * --------
 * 1. Go to Appearance > Widgets
 * 2. Add widgets to:
 *    - Primary Sidebar
 *    - Footer Widget Area 1, 2, 3
 *
 */

/**
 * THEME CUSTOMIZATION
 * ===================
 *
 * COLORS:
 * -------
 * Edit assets/css/style.css and change:
 * - #0066cc (primary color - change to your brand color)
 * - #2c3e50 (footer background)
 * - #f8f9fa (light background)
 *
 * FONTS:
 * ------
 * Edit the body font-family in assets/css/style.css
 * Add Google Fonts in functions.php:
 *
 *     wp_enqueue_style(
 *         'google-fonts',
 *         'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700'
 *     );
 *
 * LOGO:
 * -----
 * Go to Appearance > Customize > Site Identity
 * Upload your custom logo (recommended: 400x100px)
 *
 * FAVICON:
 * --------
 * Go to Appearance > Customize > Site Identity
 * Upload your favicon
 *
 */

/**
 * TEMPLATE HIERARCHY
 * ==================
 *
 * Homepage:         front-page.php
 * About Page:       page-about.php
 * Contact Page:     page-contact.php
 * Blog Page:        page-blog.php
 * Single Post:      single.php
 * Single Book:      single-book.php
 * Book Archive:     archive-book.php
 * Genre Archive:    taxonomy-genre.php
 * Author Archive:   taxonomy-author.php
 * Search Results:   index.php
 * 404 Page:         404.php
 *
 */

/**
 * CUSTOM POST TYPES & TAXONOMIES
 * ==============================
 *
 * POST TYPE: book
 * - URL: /books/
 * - Can have Featured Image, Title, Content, Excerpt
 *
 * TAXONOMY: genre (Hierarchical like Categories)
 * - URL: /genre/fiction/
 * - Can have parent/child genres
 *
 * TAXONOMY: author (Non-Hierarchical like Tags)
 * - URL: /author/j-k-rowling/
 *
 * TAXONOMY: format (Non-Hierarchical like Tags)
 * - URL: /format/hardcover/
 * - Examples: eBook, Hardcover, Paperback
 *
 */

/**
 * USEFUL WORDPRESS FUNCTIONS USED
 * ===============================
 *
 * Template Tags:
 * - get_header() / get_footer()       : Include header/footer
 * - get_template_part()              : Include template parts
 * - the_post() / have_posts()         : The Loop
 * - the_title()                       : Display post title
 * - the_content()                     : Display post content
 * - the_permalink()                   : Get post URL
 * - the_post_thumbnail()              : Display featured image
 * - the_archive_title()               : Display archive title
 * - the_posts_pagination()            : Display pagination
 * - wp_nav_menu()                     : Display menu
 * - dynamic_sidebar()                 : Display widgets
 * - bloginfo()                        : Display site info
 *
 * Queries:
 * - WP_Query                          : Query posts
 * - get_the_terms()                   : Get taxonomy terms for post
 * - wp_get_post_terms()               : Get post terms
 * - get_term_link()                   : Get term archive URL
 *
 * Escaping:
 * - esc_html()                        : Escape text for HTML
 * - esc_url()                         : Escape URL
 * - esc_attr()                        : Escape HTML attributes
 * - wp_kses_post()                    : Safe post content
 *
 */

/**
 * ADDING MORE FEATURES
 * ====================
 *
 * ADD ACF (Advanced Custom Fields):
 * ----------------------------------
 * 1. Install ACF plugin
 * 2. Create field groups for books
 * 3. Use get_field() in templates
 *
 * ADD WOOCOMMERCE SUPPORT:
 * -------------------------
 * 1. Install WooCommerce plugin
 * 2. Add to functions.php:
 *
 *     add_theme_support( 'woocommerce' );
 *
 * 3. Create woocommerce/ folder with templates
 *
 * ADD CONTACT FORM:
 * -----------------
 * 1. Install Contact Form 7 plugin
 * 2. Create form
 * 3. Add shortcode to page-contact.php
 *
 */

/**
 * TROUBLESHOOTING
 * ===============
 *
 * BLANK WHITE PAGE:
 * - Check WordPress debug log
 * - Verify functions.php has correct PHP syntax
 * - Check that custom post type names are correct
 *
 * STYLES NOT SHOWING:
 * - Go to Appearance > Customize > see if stylesheet is loaded
 * - Check assets/css/style.css exists
 * - Clear browser cache
 *
 * BOOKS NOT DISPLAYING:
 * - Verify "Book" post type is registered in functions.php
 * - Check that at least one book is published
 * - Visit /books/ to see the archive
 *
 * MENUS NOT SHOWING:
 * - Create a menu first in Appearance > Menus
 * - Set the menu location
 * - Add items to menu
 *
 */

/**
 * PERFORMANCE TIPS
 * ================
 *
 * 1. Use caching plugin (WP Super Cache, W3 Total Cache)
 * 2. Optimize images (JPEG for photos, PNG for graphics)
 * 3. Lazy load images (use WordPress native lazy-loading: loading="lazy")
 * 4. Minify CSS/JS in production (via plugin)
 * 5. Use a CDN for images
 * 6. Reduce database queries with caching
 *
 */

/**
 * SEO BEST PRACTICES
 * ==================
 *
 * 1. Install Yoast SEO or Rank Math plugin
 * 2. Fill in meta descriptions
 * 3. Use semantic HTML (proper heading hierarchy)
 * 4. Add alt text to images
 * 5. Use descriptive URLs
 * 6. Include relevant keywords in content
 * 7. Internal linking between books and posts
 *
 */

/**
 * ACCESSIBILITY CHECKLIST
 * =======================
 *
 * ✓ Theme includes skip-to-content link
 * ✓ Semantic HTML (header, nav, main, footer, article)
 * ✓ Proper heading hierarchy (h1, h2, h3...)
 * ✓ Image alt text (customize in media library)
 * ✓ ARIA labels on navigation
 * ✓ Color contrast meets WCAG standards
 * ✓ Keyboard navigation support
 * ✓ Screen reader friendly
 *
 * Additional tips:
 * - Always add meaningful alt text to images
 * - Use proper HTML semantics
 * - Test with screen readers
 * - Check color contrast ratios
 *
 */

/**
 * SUPPORT & RESOURCES
 * ===================
 *
 * WordPress Docs:
 * - https://developer.wordpress.org/themes/
 * - https://developer.wordpress.org/plugins/
 * - https://www.php.net/
 *
 * Theme Development:
 * - https://wordpress.org/support/forums/
 * - https://wordpress.stackexchange.com/
 *
 * Reference Code:
 * - All files in this theme include inline comments
 * - Check functions.php for hooks and filters
 * - See template-parts/ for component examples
 *
 */

?>
