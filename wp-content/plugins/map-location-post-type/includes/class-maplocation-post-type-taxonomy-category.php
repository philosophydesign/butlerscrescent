<?php
/**
 * Map_location_Post_Type
 *
 * @package   Jobsubscriber_Post_Type
 * @license   GPL-2.0+
 * @link      http://wptheming.com/portfolio-post-type/
 */

/**
 * Map location category taxonomy.
 *
 * @package Map_location_Post_Type
 */
class Maplocation_Post_Type_Taxonomy_Category extends Gamajo_Taxonomy2 {
	/**
	 * Taxonomy ID.
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	protected $taxonomy = 'maplocation_category'; //
	/**
	 * Return taxonomy default arguments.
	 *
	 * @since 1.0.0
	 *
	 * @return array Taxonomy default arguments.
	 */
	protected function default_args() {
		$labels = array(
			'name'                       => __( 'Location Categories', 'maplocation-post-type' ),
			'singular_name'              => __( 'Location Category', 'maplocation-post-type' ),
			'menu_name'                  => __( 'Location Categories', 'maplocation-post-type' ),
			'edit_item'                  => __( 'Edit Location Category', 'maplocation-post-type' ),
			'update_item'                => __( 'Update Location Category', 'maplocation-post-type' ),
			'add_new_item'               => __( 'Add New Location Category', 'maplocation-post-type' ),
			'new_item_name'              => __( 'New Location Category Name', 'maplocation-post-type' ),
			'parent_item'                => __( 'Parent Location Category', 'maplocation-post-type' ),
			'parent_item_colon'          => __( 'Parent Location Category:', 'maplocation-post-type' ),
			'all_items'                  => __( 'All Location Categories', 'maplocation-post-type' ),
			'search_items'               => __( 'Search Location Categories', 'maplocation-post-type' ),
			'popular_items'              => __( 'Popular Location Categories', 'maplocation-post-type' ),
			'separate_items_with_commas' => __( 'Separate location categories with commas', 'maplocation-post-type' ),
			'add_or_remove_items'        => __( 'Add or remove location categories', 'maplocation-post-type' ),
			'choose_from_most_used'      => __( 'Choose from the most used location subscriber categories', 'maplocation-post-type' ),
			'not_found'                  => __( 'No Location categories found.', 'maplocation-post-type' ),
			'items_list_navigation'      => __( 'Location categories list navigation', 'maplocation-post-type' ),
			'items_list'                 => __( 'Location categories list', 'maplocation-post-type' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'neighbourhood' ),//category
			'show_admin_column' => true,
			'query_var'         => true,
		);

		return apply_filters( 'maplocation_posttype_category_args', $args );
	}
}