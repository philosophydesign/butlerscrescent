<?php
/**
 * Property Post Type
 *
 * @package   Property_Post_Type
 * @license   GPL-2.0+
 */

/**
 * Property post type.
 *
 * @package Property_Post_Type
 */
class Property_Post_Type_Post_Type extends Gamajo_Post_Type3 {
	/**
	 * Post type ID.
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	protected $post_type = 'property';

	/**
	 * Return post type default arguments.
	 *
	 * @since 1.0.0
	 *
	 * @return array Post type default arguments.
	 */
	protected function default_args() {
		$labels = array(
			'name'                  => __( 'Properties', 'property-post-type' ),
			'singular_name'         => __( 'Property', 'property-post-type' ),
			'menu_name'             => _x( 'Properties', 'admin menu', 'property-post-type' ),
			'name_admin_bar'        => _x( 'Property', 'add new on admin bar', 'property-post-type' ),
			'add_new'               => __( 'Add New Property', 'property-post-type' ),
			'add_new_item'          => __( 'Add New Property', 'property-post-type' ),
			'new_item'              => __( 'Add New Property', 'property-post-type' ),
			'edit_item'             => __( 'Edit Property', 'property-post-type' ),
			'view_item'             => __( 'View Property', 'property-post-type' ),
			'all_items'             => __( 'All Properties', 'property-post-type' ),
			'search_items'          => __( 'Search Properties', 'property-post-type' ),
			'parent_item_colon'     => __( 'Parent Property:', 'property-post-type' ),
			'not_found'             => __( 'No properties found', 'property-post-type' ),
			'not_found_in_trash'    => __( 'No properties found in trash', 'property-post-type' ),
			'filter_items_list'     => __( 'Filter property list', 'property-post-type' ),
			'items_list_navigation' => __( 'Property list navigation', 'property-post-type' ),
			'items_list'            => __( 'Property list', 'property-post-type' ),
		);

		$supports = array(
			'title',
			'editor',
			//'excerpt',
			//'thumbnail',
			'page-attributes',
			//'comments',
			//'author',
			'custom-fields',
			//'revisions',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'exclude_from_search' => false,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'query_var'           => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'properties', ), // Permalinks format
			'menu_position'   => 5,
			'menu_icon'       => ( version_compare( $GLOBALS['wp_version'], '3.8', '>=' ) ) ? 'dashicons-portfolio' : false ,
			'has_archive'     => false,
		);

		return apply_filters( 'property_posttype_args', $args );
	}

	/**
	 * Return post type updated messages.
	 *
	 * @since 1.0.0
	 *
	 * @return array Post type updated messages.
	 */
	public function messages() {
		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$messages = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Property updated.', 'property-post-type' ),
			2  => __( 'Custom field updated.', 'property-post-type' ),
			3  => __( 'Custom field deleted.', 'property-post-type' ),
			4  => __( 'Property updated.', 'property-post-type' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Property restored to revision from %s', 'property-post-type' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Property published.', 'property-post-type' ),
			7  => __( 'Property saved.', 'property-post-type' ),
			8  => __( 'Property submitted.', 'property-post-type' ),
			9  => sprintf(
				__( 'Property scheduled for: <strong>%1$s</strong>.', 'property-post-type' ),
				/* translators: Publish box date format, see http://php.net/date */
				date_i18n( __( 'M j, Y @ G:i', 'property-post-type' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Property draft updated.', 'property-post-type' ),
		);

		if ( $post_type_object->publicly_queryable ) {
			$permalink         = get_permalink( $post->ID );
			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );

			$view_link    = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View property', 'property-post-type' ) );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview property', 'property-post-type' ) );

			$messages[1]  .= $view_link;
			$messages[6]  .= $view_link;
			$messages[9]  .= $view_link;
			$messages[8]  .= $preview_link;
			$messages[10] .= $preview_link;
		}

		return $messages;
	}

}