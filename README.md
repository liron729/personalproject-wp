# Bookstore Theme - Custom WordPress Theme

A fully custom WordPress theme built from scratch for a bookstore website, demonstrating advanced WordPress theme development skills and best practices.

## Features & Requirements Met

### ✅ 1. Theme Setup
- [x] Custom theme named "bookstore-theme"
- [x] Proper style.css header comments with Theme Name, Author, Version, Description
- [x] CSS and JavaScript files enqueued using `wp_enqueue_style()` and `wp_enqueue_script()`
- [x] Proper use of `wp_head()` and `wp_footer()`

### ✅ 2. Theme Supports
- [x] `title-tag` - Dynamic page titles
- [x] `post-thumbnails` - Featured images support
- [x] `custom-logo` - Custom logo support
- [x] `html5` - HTML5 markup support
- [x] `post-formats` - Support for aside, gallery, quote, video post formats
- [x] `custom-background` - Custom background color/image
- [x] `custom-header` - Custom header image
- [x] `automatic-feed-links` - Automatic feed links

### ✅ 3. Custom Menus
- [x] Two registered menus:
  - Primary Menu (Header)
  - Footer Menu
- [x] Menus output using `wp_nav_menu()`
- [x] Menu support registered via `register_nav_menus()`

### ✅ 4. Body Class
- [x] Properly implemented `body_class()` in header.php
- [x] Custom body classes added via filter (bookstore-theme, has-sidebar, single-book-page, book-archive-page)

### ✅ 5. Custom Post Type
- [x] Custom Post Type "book" with:
  - [x] Public visibility
  - [x] Archive support
  - [x] Custom slug `/books`
  - [x] Support for title, editor, thumbnail, excerpt
  - [x] Custom rewrite rules
  - [x] Proper admin UI labels

### ✅ 6. Custom Taxonomies
- [x] Three custom taxonomies for book post type:
  - [x] `genre` (hierarchical) - Like categories
  - [x] `author` (non-hierarchical) - Like tags
  - [x] `format` (non-hierarchical) - eBook, Hardcover, Paperback

### ✅ 7. Page Templates
- [x] `front-page.php` - Homepage with featured books section
- [x] `page-about.php` - About page template
- [x] `page-contact.php` - Contact page template
- [x] `page-blog.php` - Blog page template
- [x] All use `get_header()` and `get_footer()`
- [x] Semantic HTML structure throughout

### ✅ 8. Custom Archive Templates
- [x] `archive-book.php` - Book archive with grid layout
- [x] `taxonomy-genre.php` - Genre archive template
- [x] `taxonomy-author.php` - Author archive template
- [x] Pagination on all archive pages using `the_posts_pagination()`

### ✅ 9. Single Post Templates
- [x] `single.php` - Blog post template with:
  - [x] Featured image
  - [x] Title
  - [x] Meta data (author, date, categories)
  - [x] Content
- [x] `single-book.php` - Book template with:
  - [x] Featured image (book cover)
  - [x] Title
  - [x] Meta data (authors, genres, formats)
  - [x] Content

### ✅ 10. Post Loop
- [x] Proper use of The Loop with `have_posts()` and `the_post()`
- [x] `the_title()`, `the_content()`, `the_permalink()` usage
- [x] Reusable loops using `WP_Query` for featured books, related content

### ✅ 11. Sidebar & Widgets
- [x] Three registered sidebars:
  - Primary Sidebar
  - Footer Widget Area 1
  - Footer Widget Area 2
  - Footer Widget Area 3
- [x] Sidebars displayed using `dynamic_sidebar()`
- [x] Widget areas registered via `register_sidebar()`

### ✅ 12. Pagination
- [x] Pagination implemented on:
  - [x] Blog archive (index.php)
  - [x] Book archive (archive-book.php)
  - [x] All taxonomy archives
- [x] Uses `the_posts_pagination()`

### ✅ 13. Blog Info
- [x] `bloginfo()` and `get_bloginfo()` used for:
  - [x] Site title
  - [x] Tagline
  - [x] Charset
  - [x] Stylesheet URL

### ✅ 14. 404 Page
- [x] Custom 404.php with:
  - [x] Friendly message
  - [x] Search form using `get_search_form()`
  - [x] Navigation links back to homepage
  - [x] Recent books section

### ✅ 15. Custom CSS
- [x] Structured CSS in `assets/css/style.css` for:
  - [x] Header navigation
  - [x] Book grid layout
  - [x] Single book layout
  - [x] Sidebar styling
  - [x] Footer
  - [x] Responsive design (mobile-first)
  - [x] Accessible color contrast

### ✅ 16. Custom JavaScript
- [x] JavaScript in `assets/js/main.js` for:
  - [x] Mobile menu toggle functionality
  - [x] Smooth scrolling
  - [x] Load More Books AJAX functionality (prepared)
  - [x] Book filtering capability
  - [x] Optional lightbox enhancement
- [x] Properly enqueued (no inline scripts)

### ✅ 17. Template Parts
- [x] Reusable template parts using `get_template_part()`:
  - [x] `template-parts/book-card.php` - Book card component
  - [x] `template-parts/content.php` - Post content template
  - [x] `template-parts/related-books.php` - Related books section
  - [x] `template-parts/related-posts.php` - Related posts section

### ✅ 18. Code Quality
- [x] Proper PHP comments and documentation
- [x] WordPress coding standards followed
- [x] Output escaping with `esc_html()`, `esc_url()`, `wp_kses_post()`
- [x] Input sanitization where applicable
- [x] Proper use of WordPress functions and hooks

## File Structure

```
/bookstore-theme
├── style.css                           # Theme information header
├── functions.php                       # Theme setup & configuration
├── header.php                          # Header template
├── footer.php                          # Footer template
├── sidebar.php                         # Sidebar template
├── index.php                           # Main index template
├── front-page.php                      # Homepage template
├── single.php                          # Single post template
├── single-book.php                     # Single book template
├── archive.php                         # Generic archive template
├── archive-book.php                    # Book archive template
├── taxonomy-genre.php                  # Genre archive template
├── taxonomy-author.php                 # Author archive template
├── page-about.php                      # About page template
├── page-contact.php                    # Contact page template
├── page-blog.php                       # Blog page template
├── 404.php                             # 404 error page
│
├── template-parts/
│   ├── book-card.php                   # Book card component
│   ├── content.php                     # Post content template
│   ├── related-books.php               # Related books section
│   └── related-posts.php               # Related posts section
│
└── assets/
    ├── css/
    │   └── style.css                   # Main stylesheet (850+ lines)
    └── js/
        └── main.js                     # Main JavaScript file
```

## Installation Instructions

1. **Copy the theme folder** to `wp-content/themes/`
2. **Login to WordPress Admin**
3. **Go to Appearance → Themes**
4. **Activate "Bookstore Theme"**
5. **Configure theme settings:**
   - Set a static front page
   - Create menus and assign to menu locations
   - Add widgets to sidebars
6. **Create content:**
   - Add books via Books menu
   - Create categories and taxonomies
   - Set featured images

## Creating Content

### Create Books
1. Go to **Posts → Books** in WordPress Admin
2. Click **Add New Book**
3. Fill in the book details:
   - Title
   - Description (in editor)
   - Featured Image (book cover)
   - Select Genres, Authors, and Formats
4. Publish

### Create Menus
1. Go to **Appearance → Menus**
2. Create a new menu (e.g., "Main Menu")
3. Add pages and books to the menu
4. Set menu location (Primary Menu)

### Create Widgets
1. Go to **Appearance → Widgets**
2. Add widgets to:
   - Primary Sidebar
   - Footer Widget Areas

## Customization Guide

### Modifying Colors
Edit `assets/css/style.css` and change the color values:
- Primary color: `#0066cc`
- Secondary color: `#6c757d`
- Background: `#ffffff`

### Customizing Fonts
Update the `body` font-family in `assets/css/style.css` or link Google Fonts in `functions.php`:

```php
wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=YOUR_FONT' );
```

### Adding Custom Fields
Use Advanced Custom Fields (ACF) plugin or native WordPress meta fields:

```php
add_post_meta( get_the_ID(), 'book_price', '19.99' );
```

## Theme Hooks & Filters

### Available Actions
- `after_setup_theme` - Theme setup
- `wp_enqueue_scripts` - Enqueue styles/scripts
- `widgets_init` - Register sidebars

### Available Filters
- `body_class` - Custom body classes
- `wp_nav_menu` - Menu output

## Browser Compatibility

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Optimization

The theme is optimized for performance:
- CSS file sizes (~850 lines of modular CSS)
- JavaScript loaded in footer (non-blocking)
- Responsive images (mobile-first)
- No unnecessary dependencies

## Accessibility Features

- Semantic HTML structure
- ARIA labels for navigation
- Skip-to-content link
- Keyboard navigation support
- Screen reader friendly

## Credits

- Developed as a custom WordPress theme
- Follows WordPress coding standards
- Uses WordPress built-in functions and hooks

## License

GNU General Public License v2 or later

## Support & Documentation

For more information, refer to:
- [WordPress Theme Developer Handbook](https://developer.wordpress.org/themes/)
- [WordPress Plugin API](https://developer.wordpress.org/plugins/)
- Theme source code comments

## Version History

### Version 1.0.0
- Initial release
- Complete theme setup with all features
- Custom post types and taxonomies
- Multiple page templates
- Responsive design
- Accessible markup
