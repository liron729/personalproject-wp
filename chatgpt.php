<!-- Below is a **highly detailed, copy-paste–ready prompt** you can give to **GitHub Copilot (or any AI code assistant)**.
It explicitly requires **every WordPress feature you listed** and is written like a real development brief so nothing is skipped.

---

## ✅ **Highly Detailed Prompt for Copilot (WordPress Custom Theme Project)**

> **Context / Role:**
> You are an expert WordPress theme developer. Your task is to build a **fully custom WordPress theme from scratch** (no premade themes, no theme frameworks) for a **Bookstore website**. The theme must strictly follow WordPress best practices, use the WordPress template hierarchy correctly, and demonstrate advanced theme development skills suitable for a university or portfolio project.

---

### 🔧 **Project Requirements (DO NOT SKIP ANY ITEM)**

#### 1. **Theme Setup**

* Create a custom theme named `bookstore-theme`
* Include proper `style.css` header comments (Theme Name, Author, Version, Description)
* Enqueue **custom CSS and JavaScript** files using `wp_enqueue_style()` and `wp_enqueue_script()`
* Use `wp_head()` and `wp_footer()` correctly

---

#### 2. **Theme Supports**

Use `add_theme_support()` to enable:

* `title-tag`
* `post-thumbnails`
* `custom-logo`
* `html5` support
* `post-formats` (aside, gallery, quote, video)
* `custom-background`
* `custom-header`
* `automatic-feed-links`

---

#### 3. **Custom Menus**

* Register **at least two menus**:

  * Primary Menu (Header)
  * Footer Menu
* Output menus using `wp_nav_menu()`
* Add menu support via `register_nav_menus()`

---

#### 4. **Body Class**

* Properly implement `body_class()` in `header.php`
* Add **custom body classes** using the `body_class` filter (e.g., `bookstore-theme`, `has-sidebar`, `single-book-page`)

---

#### 5. **Custom Post Type**

Create a **Custom Post Type** called `book` with:

* Public visibility
* Archive support
* Custom slug `/books`
* Support for title, editor, thumbnail, excerpt
* Custom rewrite rules
* Proper labels for admin UI

---

#### 6. **Custom Taxonomies**

Create custom taxonomies for the `book` post type:

* `genre` (hierarchical)
* `author` (non-hierarchical)
* `format` (eBook, Hardcover, Paperback)

---

#### 7. **Page Templates**

Create custom page templates:

* `front-page.php` (homepage layout)
* `page-about.php`
* `page-contact.php`
* `page-blog.php`

Each page template must:

* Use `get_header()` and `get_footer()`
* Follow semantic HTML structure

---

#### 8. **Custom Archive Templates**

* `archive-book.php` → custom layout for book archive
* `taxonomy-genre.php` → genre archive
* `taxonomy-author.php` → author archive
* Include pagination on archive pages

---

#### 9. **Single Post Templates**

* `single.php` for blog posts
* `single-book.php` for books
* Display:

  * Featured image
  * Title
  * Meta data (author, taxonomy terms)
  * Content

---

#### 10. **Post Loop**

* Use **The Loop** properly in all templates
* Include:

  * `have_posts()`
  * `the_post()`
  * `the_title()`
  * `the_content()`
  * `the_permalink()`
* Create reusable loops using `WP_Query`

---

#### 11. **Sidebar & Widgets**

* Register at least **one sidebar**
* Display sidebar using `dynamic_sidebar()`
* Add widget support via `register_sidebar()`

---

#### 12. **Pagination**

* Implement pagination for:

  * Blog archive
  * Book archive
* Use:

  * `the_posts_pagination()` or `paginate_links()`

---

#### 13. **Blog Info**

* Use `bloginfo()` and `get_bloginfo()` to display:

  * Site title
  * Tagline
  * Charset
  * Stylesheet URL

---

#### 14. **404 Page**

* Create a custom `404.php`
* Include:

  * Friendly message
  * Search form
  * Navigation link back to homepage

---

#### 15. **Custom CSS**

* Write structured CSS for:

  * Header
  * Navigation
  * Book grid
  * Single book layout
  * Sidebar
  * Footer
* Ensure responsive design (mobile-first)

---

#### 16. **Custom JavaScript**

* Add JavaScript for:

  * Mobile menu toggle
  * Optional “Load More Books” button
* Enqueue JS properly (no inline scripts)

---

#### 17. **Template Parts**

* Use `get_template_part()` for reusable components:

  * Book card
  * Header sections
  * Footer sections

---

#### 18. **Code Quality**

* Use proper PHP comments
* Follow WordPress coding standards
* Escape output (`esc_html()`, `esc_url()`)
* Sanitize input where applicable

---

### 📁 **Required File Structure**

Ensure the theme contains (at minimum):

```
/bookstore-theme
│── style.css
│── functions.php
│── index.php
│── header.php
│── footer.php
│── sidebar.php
│── front-page.php
│── single.php
│── single-book.php
│── archive.php
│── archive-book.php
│── taxonomy-genre.php
│── taxonomy-author.php
│── page-about.php
│── page-contact.php
│── 404.php
│
├── template-parts/
│   ├── book-card.php
│
├── assets/
│   ├── css/style.css
│   ├── js/main.js
```

---

### 🎯 **Final Output Expectation**

Generate **fully working WordPress theme code**, split by file, with clear comments explaining each section.
Do **not** omit any required feature.
The final theme must be installable and functional inside WordPress.

---

If you want, next I can:

* Review this prompt for **grading rubrics**
* Convert it into a **step-by-step build checklist**
* Help you **defend this project in an oral exam**
* Or generate **sample screenshots / wireframes**

Just tell me. -->
