<?php
/**
 * Property_Post_Type
 *
 * @package   Property_Post_Type
 * @license   GPL-2.0+
 * @link      http://wptheming.com/portfolio-post-type/
 */

/**
 * Property category taxonomy.
 *
 * @package Property_Post_Type
 */
class Property_Post_Type_Taxonomy_Category extends Gamajo_Taxonomy3 {
	/**
	 * Taxonomy ID.
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	protected $taxonomy = 'property_category'; //
	/**
	 * Return taxonomy default arguments.
	 *
	 * @since 1.0.0
	 *
	 * @return array Taxonomy default arguments.
	 */
	protected function default_args() {
		$labels = array(
			'name'                       => __( 'Property Name', 'property-post-type' ),
			'singular_name'              => __( 'Property Category', 'property-post-type' ),
			'menu_name'                  => __( 'Property  Categories', 'property-post-type' ),
			'edit_item'                  => __( 'Edit Property Category', 'property-post-type' ),
			'update_item'                => __( 'Update Property Category', 'property-post-type' ),
			'add_new_item'               => __( 'Add New Property Category', 'property-post-type' ),
			'new_item_name'              => __( 'New Property Category Name', 'property-post-type' ),
			'parent_item'                => __( 'Parent Property  Category', 'property-post-type' ),
			'parent_item_colon'          => __( 'Parent Property Category:', 'property-post-type' ),
			'all_items'                  => __( 'All Property Categories', 'property-post-type' ),
			'search_items'               => __( 'Search Property Categories', 'property-post-type' ),
			'popular_items'              => __( 'Popular Property Categories', 'property-post-type' ),
			'separate_items_with_commas' => __( 'Separate property categories with commas', 'property-post-type' ),
			'add_or_remove_items'        => __( 'Add or remove property categories', 'property-post-type' ),
			'choose_from_most_used'      => __( 'Choose from the most used property subscriber categories', 'property-post-type' ),
			'not_found'                  => __( 'No property categories found.', 'property-post-type' ),
			'items_list_navigation'      => __( 'Property categories list navigation', 'property-post-type' ),
			'items_list'                 => __( 'Property categories list', 'property-post-type' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'property_category' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		return apply_filters( 'property_posttype_category_args', $args );
	}
}