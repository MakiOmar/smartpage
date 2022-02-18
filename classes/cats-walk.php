<?php
/**
 * Categories menu walkker
 *
 * PHP version 7.3 Or Later
 *
 * @category WordPress
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

if ( ! class_exists( 'ANONY_Cats_Walk' ) ) {

	/**
	 * Categories menu walkker class
	 *
	 * @category   Walker
	 * @package    Walker
	 * @subpackage Category
	 * @author     Makiomar <info@makior.com>
	 * @license    https://makiomar.com SmartPage Licence
	 * @link       https://makiomar.com
	 */
	class ANONY_Cats_Walk extends Walker_Category {

		/**
		 * Tree type
		 *
		 * @var string
		 */
		public $tree_type = 'category';
		/**
		 * Starts the list before the elements are added.
		 *
		 * @param mixed $output Passed by reference. Used to append additional content.
		 * @param int   $depth  (default: 0) Depth of page. Used for padding.
		 * @param array $args   (default: array()) Arguments.
		 *
		 * @see    Walker::start_lvl()
		 * @since  1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent  = str_repeat( "\t", $depth );
			$output .= "\n$indent<ul class = \"anony-dropdown\">\n";
		}

		/**
		 * Starts the element output.
		 *
		 * @param string  $output   Used to append additional content (passed by reference).
		 * @param WP_Term $category Category data object.
		 * @param int     $depth    Optional. Depth of category in reference to parents. Default 0.
		 * @param array   $args     Optional. An array of arguments. See wp_list_categories().
		 *                          Default empty array.
		 * @param int     $id       Optional. ID of the current category. Default 0.
		 *
		 * @since 1.0.0
		 *
		 * @see   Walker::start_el()
		 * @return void
		 */
		public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
			/**
			 * This filter is documented in wp-includes/category-template.php
			 */
			$cat_name = apply_filters( 'list_cats', esc_attr( $category->name ), $category );

			// Don't generate an element if the category name is empty.
			if ( ! $cat_name ) {
				return;
			}

			$link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
			if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
				/**
				 * Filters the category description for display.
				 *
				 * @param string $description Category description.
				 * @param object $category    Category object.
				 *
				 * @since 1.2.0
				 */
				$link .= 'title="' . esc_attr(
					wp_strip_all_tags(
						apply_filters( 'category_description', $category->description, $category )
					)
				) . '"';
			}

			$link .= '>';
			$link .= $cat_name . '</a>';

			if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
				$link .= ' ';

				if ( empty( $args['feed_image'] ) ) {
					$link .= '(';
				}

				$link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';

				if ( empty( $args['feed'] ) ) {
					/* translators: %s: category name */
					$alt = ' alt="' . sprintf( esc_attr__( 'Feed for all posts filed under %s', 'smartpage' ), $cat_name ) . '"';
				} else {
					$alt   = ' alt="' . $args['feed'] . '"';
					$name  = $args['feed'];
					$link .= empty( $args['title'] ) ? '' : $args['title'];
				}

				$link .= '>';

				if ( empty( $args['feed_image'] ) ) {
					$link .= $name;
				} else {
					$link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
				}
				$link .= '</a>';

				if ( empty( $args['feed_image'] ) ) {
					$link .= ')';
				}
			}

			if ( ! empty( $args['show_count'] ) ) {
				$link .= ' (' . number_format_i18n( $category->count ) . ')';
			}
			if ( 'list' === $args['style'] ) {
				$output     .= "\t<li";
				$css_classes = array( 'cat-item', 'cat-item-' . $category->term_id );
				if ( $this->has_children ) {
					$css_classes[] = 'has-children';
				}

				if ( ! empty( $args['current_category'] ) ) {
					// 'current_category' can be an array, so we use `get_terms()`.
					$_current_terms = get_terms(
						$category->taxonomy,
						array(
							'include'    => $args['current_category'],
							'hide_empty' => false,
						)
					);

					foreach ( $_current_terms as $_current_term ) {
						if ( $category->term_id === $_current_term->term_id ) {
							$css_classes[] = 'current-cat';
						} elseif ( $category->term_id === $_current_term->parent ) {
							$css_classes[] = 'current-cat-parent';
						}
						while ( $_current_term->parent ) {
							if ( $category->term_id === $_current_term->parent ) {
								$css_classes[] = 'current-cat-ancestor';
								break;
							}
							$_current_term = get_term( $_current_term->parent, $category->taxonomy );
						}
					}
				}

				$css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );

				$output .= ' class="' . $css_classes . '"';
				$output .= ">$link\n";
			} elseif ( isset( $args['separator'] ) ) {
				$output .= "\t$link" . $args['separator'] . "\n";
			} else {
				$output .= "\t$link<br />\n";
			}

			if ( $this->has_children ) {
				$output .= '<span class="toggle-category" rel-id="anony-cat-dropdown-' . $category->term_id . '"><i class="fa fa-plus" aria-hidden="true"></i></span>';
			}
		}
	}
}
