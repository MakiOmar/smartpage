<?php if ( ! class_exists( 'Class__Cats_Walk' ) ) {
	class Class__Cats_Walk extends Walker_Category {
		public $tree_type = 'category';
				/**
				 * Start Level.
				 *
				 * @see Walker::start_lvl()
				 * @since 3.0.0
				 *
				 * @access public
				 * @param mixed $output Passed by reference. Used to append additional content.
				 * @param int   $depth (default: 0) Depth of page. Used for padding.
				 * @param array $args (default: array()) Arguments.
				 * @return void
				 */

				public function start_lvl( &$output, $depth = 0, $args = array() ) {
					$indent = str_repeat( "\t", $depth );
					$output .= "\n$indent<ul class = \"anony-dropdown\" style=\"display: none;\">\n";
				}

				public function start_el(  &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
					/** This filter is documented in wp-includes/category-template.php */
					$cat_name = apply_filters('list_cats',esc_attr( $category->name ),$category);

					// Don't generate an element if the category name is empty.
					if ( ! $cat_name ) {return;}

					$link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
					if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
						/**
						 * Filters the category description for display.
						 *
						 * @since 1.2.0
						 *
						 * @param string $description Category description.
						 * @param object $category    Category object.
						 */
						$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
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
							$alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
						} else {
							$alt = ' alt="' . $args['feed'] . '"';
							$name = $args['feed'];
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
					if ( 'list' == $args['style'] ) {
						$output .= "\t<li";
						$css_classes = array('cat-item','cat-item-' . $category->term_id);
						if($this->has_children){$css_classes[] = 'has-children';}

						if ( ! empty( $args['current_category'] ) ) {
							// 'current_category' can be an array, so we use `get_terms()`.
							$_current_terms = get_terms( $category->taxonomy, array(
								'include'    => $args['current_category'],
								'hide_empty' => false,
							) );

							foreach ( $_current_terms as $_current_term ) {
								if ( $category->term_id == $_current_term->term_id ) {
									$css_classes[] = 'current-cat';
								} elseif ( $category->term_id == $_current_term->parent ) {
									$css_classes[] = 'current-cat-parent';
								}
								while ( $_current_term->parent ) {
									if ( $category->term_id == $_current_term->parent ) {
										$css_classes[] =  'current-cat-ancestor';
										break;
									}
									$_current_term = get_term( $_current_term->parent, $category->taxonomy );
								}
							}
						}

						$css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );

						$output .=  ' class="' . $css_classes . '"';
						$output .= ">$link\n";
						if($this->has_children){
						$output .= '<span class="toggle-category"><i class="fa fa-plus" aria-hidden="true"></i></span>';
					 }
					} elseif ( isset( $args['separator'] ) ) {
						$output .= "\t$link" . $args['separator'] . "\n";
					} else {
						$output .= "\t$link<br />\n";
					}

				}

			}

	}
?>
