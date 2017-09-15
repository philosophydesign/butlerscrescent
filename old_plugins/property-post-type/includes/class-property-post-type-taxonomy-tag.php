<?php
/**
 * Property Post Type
 *
 * @package   Property_Post_Type
 * @license   GPL-2.0+
 */

/**
 * Property tag taxonomy.
 *
 * @package Property_Post_Type

 */
class Property_Post_Type_Taxonomy_Tag extends Gamajo_Taxonomy3 {
	/**
	 * Taxonomy ID.
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	protected $taxonomy = 'property_tag';

	/**
	 * Return taxonomy default arguments.
	 *
	 * @since 1.0.0
	 *
	 * @return array Taxonomy default arguments.
	 */
	protected function default_args() {
		$labels = array(
			'name'                       => __( 'Property Type', 'property-post-type' ),
			'singular_name'              => __( 'Property Tag', 'property-post-type' ),
			'menu_name'                  => __( 'Property Tags', 'property-post-type' ),
			'edit_item'                  => __( 'Edit Property Tag', 'property-post-type' ),
			'update_item'                => __( 'Update Property Tag', 'property-post-type' ),
			'add_new_item'               => __( 'Add New Property Tag', 'property-post-type' ),
			'new_item_name'              => __( 'New Property Tag Name', 'property-post-type' ),
			'parent_item'                => __( 'Parent Property Tag', 'property-post-type' ),
			'parent_item_colon'          => __( 'Parent Property Tag:', 'property-post-type' ),
			'all_items'                  => __( 'All Property Tags', 'property-post-type' ),
			'search_items'               => __( 'Search Property Tags', 'property-post-type' ),
			'popular_items'              => __( 'Popular Property Tags', 'property-post-type' ),
			'separate_items_with_commas' => __( 'Separate Property tags with commas', 'property-post-type' ),
			'add_or_remove_items'        => __( 'Add or remove property tags', 'property-post-type' ),
			'choose_from_most_used'      => __( 'Choose from the most used property tags', 'property-post-type' ),
			'not_found'                  => __( 'No property tags found.', 'property-post-type' ),
			'items_list_navigation'      => __( 'Property tags list navigation', 'property-post-type' ),
			'items_list'                 => __( 'Property tags list', 'property-post-type' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => 'property_tag' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		return apply_filters( 'property_posttype_tag_args', $args );
	}
}