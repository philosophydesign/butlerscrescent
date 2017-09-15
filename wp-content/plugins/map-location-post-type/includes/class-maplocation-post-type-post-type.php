<?php
/**
 * Map location Post Type
 *
 * @package   Map_location_Post_Type
 * @license   GPL-2.0+
 */

/**
 * Map location post type.
 *
 * @package Map location_Post_Type
 */
class Maplocation_Post_Type_Post_Type extends Gamajo_Post_Type2 {
	/**
	 * Post type ID.
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	protected $post_type = 'maplocation';

	/**
	 * Return post type default arguments.
	 *
	 * @since 1.0.0
	 *
	 * @return array Post type default arguments.
	 */
	protected function default_args() {
		$labels = array(
			'name'                  => __( 'Locations', 'maplocation-post-type' ),
			'singular_name'         => __( 'Location Item', 'maplocation-post-type' ),
			'menu_name'             => _x( 'Locations', 'admin menu', 'maplocation-post-type' ),
			'name_admin_bar'        => _x( 'Location Item', 'add new on admin bar', 'maplocation-post-type' ),
			'add_new'               => __( 'Add New Location', 'maplocation-post-type' ),
			'add_new_item'          => __( 'Add New Location', 'maplocation-post-type' ),
			'new_item'              => __( 'Add New Location', 'maplocation-post-type' ),
			'edit_item'             => __( 'Edit Location', 'maplocation-post-type' ),
			'view_item'             => __( 'View Location', 'maplocation-post-type' ),
			'all_items'             => __( 'All Locations', 'maplocation-post-type' ),
			'search_items'          => __( 'Search Locations', 'maplocation-post-type' ),
			'parent_item_colon'     => __( 'Parent Location Item:', 'maplocation-post-type' ),
			'not_found'             => __( 'No location items found', 'maplocation-post-type' ),
			'not_found_in_trash'    => __( 'No location items found in trash', 'maplocation-post-type' ),
			'filter_items_list'     => __( 'Filter location items list', 'maplocation-post-type' ),
			'items_list_navigation' => __( 'Location list navigation', 'maplocation-post-type' ),
			'items_list'            => __( 'Location list', 'maplocation-post-type' ),
		);

		$supports = array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
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
			//'exclude_from_search' => true,
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => false,
			'query_var'           => false,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'neighbourhood/all', ), // Permalinks format
			'menu_position'   => 5,
			'menu_icon'       => ( version_compare( $GLOBALS['wp_version'], '3.8', '>=' ) ) ? 'dashicons-location' : false ,
			'has_archive'     => true,
		);

		return apply_filters( 'maplocation_posttype_args', $args );
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
			1  => __( 'Map location item updated.', 'maplocation-post-type' ),
			2  => __( 'Custom field updated.', 'maplocation-post-type' ),
			3  => __( 'Custom field deleted.', 'maplocation-post-type' ),
			4  => __( 'Map location item updated.', 'maplocation-post-type' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'maplocation item restored to revision from %s', 'maplocation-post-type' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Map location item published.', 'maplocation-post-type' ),
			7  => __( 'Map location item saved.', 'maplocation-post-type' ),
			8  => __( 'Map location item submitted.', 'maplocation-post-type' ),
			9  => sprintf(
				__( 'Maplocation item scheduled for: <strong>%1$s</strong>.', 'maplocation-post-type' ),
				/* translators: Publish box date format, see http://php.net/date */
				date_i18n( __( 'M j, Y @ G:i', 'maplocation-post-type' ), strtotime( $post->post_date ) )
			),
			10 => __( 'maplocation item draft updated.', 'maplocation-post-type' ),
		);

		if ( $post_type_object->publicly_queryable ) {
			$permalink         = get_permalink( $post->ID );
			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );

			$view_link    = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View map location item', 'maplocation-post-type' ) );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview map location item', 'maplocation-post-type' ) );

			$messages[1]  .= $view_link;
			$messages[6]  .= $view_link;
			$messages[9]  .= $view_link;
			$messages[8]  .= $preview_link;
			$messages[10] .= $preview_link;
		}

		return $messages;
	}
}