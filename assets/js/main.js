/**
 * Bookstore Theme - Main JavaScript File
 *
 * This file contains all the custom JavaScript for the Bookstore Theme.
 *
 * @package BookstoreTheme
 */

(function() {
	'use strict';

	/**
	 * Mobile Menu Toggle
	 */
	function initMobileMenu() {
		const menuToggle = document.querySelector('.menu-toggle');
		const siteNav = document.querySelector('.site-navigation');

		if (!menuToggle || !siteNav) {
			return;
		}

		menuToggle.addEventListener('click', function() {
			siteNav.classList.toggle('active');
			const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
			menuToggle.setAttribute('aria-expanded', !isExpanded);
		});

		// Close menu when a link is clicked
		const navLinks = siteNav.querySelectorAll('a');
		navLinks.forEach(function(link) {
			link.addEventListener('click', function() {
				siteNav.classList.remove('active');
				menuToggle.setAttribute('aria-expanded', 'false');
			});
		});
	}

	/**
	 * Load More Books (AJAX functionality)
	 */
	function initLoadMoreBooks() {
		const loadMoreBtn = document.querySelector('.load-more-btn');

		if (!loadMoreBtn) {
			return;
		}

		loadMoreBtn.addEventListener('click', function(e) {
			e.preventDefault();

			const currentPage = parseInt(this.getAttribute('data-page'));
			const nextPage = currentPage + 1;
			const postsPerPage = parseInt(this.getAttribute('data-posts-per-page'));
			const container = document.querySelector('.books-grid');

			// Create FormData for AJAX request
			const formData = new FormData();
			formData.append('action', 'bookstore_load_more_books');
			formData.append('page', nextPage);
			formData.append('posts_per_page', postsPerPage);
			formData.append('nonce', bookstoreTheme.nonce);

			// Disable button during loading
			this.disabled = true;
			this.textContent = 'Loading...';

			// Make AJAX request
			fetch(bookstoreTheme.ajaxurl, {
				method: 'POST',
				body: formData
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Add new books to container
					container.insertAdjacentHTML('beforeend', data.html);
					
					// Update button
					this.setAttribute('data-page', nextPage);
					this.disabled = false;
					this.textContent = 'Load More Books';

					// Hide button if no more posts
					if (!data.hasMore) {
						this.style.display = 'none';
					}
				} else {
					this.disabled = false;
					this.textContent = 'Load More Books';
				}
			})
			.catch(error => {
				console.error('Error:', error);
				this.disabled = false;
				this.textContent = 'Load More Books';
			});
		});
	}

	/**
	 * Smooth Scroll for anchor links
	 */
	function initSmoothScroll() {
		document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
			anchor.addEventListener('click', function(e) {
				const href = this.getAttribute('href');
				if (href === '#') {
					return;
				}

				const target = document.querySelector(href);
				if (target) {
					e.preventDefault();
					target.scrollIntoView({
						behavior: 'smooth',
						block: 'start'
					});
				}
			});
		});
	}

	/**
	 * Book Grid Filtering (optional enhancement)
	 */
	function initBookFilters() {
		const filterBtns = document.querySelectorAll('.filter-btn');
		const books = document.querySelectorAll('.book-card');

		if (filterBtns.length === 0) {
			return;
		}

		filterBtns.forEach(function(btn) {
			btn.addEventListener('click', function() {
				const filter = this.getAttribute('data-filter');

				// Update active button
				filterBtns.forEach(b => b.classList.remove('active'));
				this.classList.add('active');

				// Filter books
				books.forEach(function(book) {
					if (filter === 'all' || book.classList.contains('filter-' + filter)) {
						book.style.display = 'block';
						// Trigger animation
						setTimeout(() => {
							book.classList.add('show');
						}, 10);
					} else {
						book.style.display = 'none';
						book.classList.remove('show');
					}
				});
			});
		});
	}

	/**
	 * Lightbox for featured images (optional)
	 */
	function initLightbox() {
		const images = document.querySelectorAll('.entry-image img, .book-card-image img');

		images.forEach(function(img) {
			img.addEventListener('click', function() {
				// Create a simple lightbox
				const lightbox = document.createElement('div');
				lightbox.className = 'lightbox';
				lightbox.innerHTML = `
					<div class="lightbox-content">
						<span class="lightbox-close">&times;</span>
						<img src="${this.src}" alt="${this.alt}" />
					</div>
				`;

				document.body.appendChild(lightbox);

				// Close lightbox
				lightbox.querySelector('.lightbox-close').addEventListener('click', function() {
					lightbox.remove();
				});

				lightbox.addEventListener('click', function(e) {
					if (e.target === this) {
						this.remove();
					}
				});
			});
		});
	}

	/**
	 * Initialize when DOM is ready
	 */
	document.addEventListener('DOMContentLoaded', function() {
		initMobileMenu();
		initLoadMoreBooks();
		initSmoothScroll();
		initBookFilters();
		initLightbox();

		console.log('Bookstore Theme: Scripts initialized');
	});
})();

/* ========================================
   LIGHTBOX STYLES (Inline for quick reference)
   ======================================== */
// Note: Add these styles to style.css if using lightbox
// .lightbox {
//   display: none;
//   position: fixed;
//   z-index: 9999;
//   left: 0;
//   top: 0;
//   width: 100%;
//   height: 100%;
//   background-color: rgba(0,0,0,0.8);
//   animation: fadeIn 0.3s ease;
// }
//
// .lightbox.show {
//   display: flex;
//   align-items: center;
//   justify-content: center;
// }
//
// .lightbox-content {
//   position: relative;
//   background-color: white;
//   padding: 20px;
//   max-width: 90%;
//   max-height: 90%;
//   border-radius: 8px;
// }
//
// .lightbox-content img {
//   max-width: 100%;
//   max-height: 100%;
// }
//
// .lightbox-close {
//   position: absolute;
//   right: 20px;
//   top: 10px;
//   font-size: 28px;
//   font-weight: bold;
//   color: #aaa;
//   cursor: pointer;
// }
//
// .lightbox-close:hover {
//   color: #000;
// }
