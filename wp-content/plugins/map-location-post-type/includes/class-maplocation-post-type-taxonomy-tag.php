<?php
/**
 * Map location Post Type
 *
 * @package   Map_location_Post_Type
 * @license   GPL-2.0+
 */

/**
 * Jobsubscriber tag taxonomy.
 *
 * @package Map_location_Post_Type

 */
class Maplocation_Post_Type_Taxonomy_Tag extends Gamajo_Taxonomy2 {
	/**
	 * Taxonomy ID.
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	protected $taxonomy = 'maplocation_tag';

	/**
	 * Return taxonomy default arguments.
	 *
	 * @since 1.0.0
	 *
	 * @return array Taxonomy default arguments.
	 */
	protected function default_args() {
		$labels = array(
			'name'                       => __( 'Location Tags', 'maplocation-post-type' ),
			'singular_name'              => __( 'Location Tag', 'maplocation-post-type' ),
			'menu_name'                  => __( 'Location Tags', 'maplocation-post-type' ),
			'edit_item'                  => __( 'Edit Location Tag', 'maplocation-post-type' ),
			'update_item'                => __( 'Update Location Tag', 'maplocation-post-type' ),
			'add_new_item'               => __( 'Add New Location Tag', 'maplocation-post-type' ),
			'new_item_name'              => __( 'New Location Tag Name', 'maplocation-post-type' ),
			'parent_item'                => __( 'Parent Location Tag', 'maplocation-post-type' ),
			'parent_item_colon'          => __( 'Parent Location Tag:', 'maplocation-post-type' ),
			'all_items'                  => __( 'All Location Tags', 'maplocation-post-type' ),
			'search_items'               => __( 'Search Location Tags', 'maplocation-post-type' ),
			'popular_items'              => __( 'Popular Location Tags', 'maplocation-post-type' ),
			'separate_items_with_commas' => __( 'Separate Location tags with commas', 'maplocation-post-type' ),
			'add_or_remove_items'        => __( 'Add or remove location tags', 'maplocation-post-type' ),
			'choose_from_most_used'      => __( 'Choose from the most used location tags', 'maplocation-post-type' ),
			'not_found'                  => __( 'No location tags found.', 'maplocation-post-type' ),
			'items_list_navigation'      => __( 'Location tags list navigation', 'maplocation-post-type' ),
			'items_list'                 => __( 'Location tags list', 'maplocation-post-type' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => 'maplocation_tag' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		return apply_filters( 'maplocation_posttype_tag_args', $args );
	}
}