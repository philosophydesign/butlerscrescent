<?php
/**
 * Map location Post Type
 *
 * @package   Map_location_Post_Type
 * @license   GPL-2.0+
 */

/**
 * Register post types and taxonomies.
 *
 * @package Map_location_Post_Type
 */
class Maplocation_Post_Type_Registrations {

	public $post_type;

	public $taxonomies;

	public function init() {
		// Add the maplocation post type and taxonomies
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 */
	public function register() {
		global $maplocation_post_type_post_type, $maplocation_post_type_taxonomy_category, $maplocation_post_type_taxonomy_tag;

		$maplocation_post_type_post_type = new maplocation_Post_Type_Post_Type;
		$maplocation_post_type_post_type->register();
		$this->post_type = $maplocation_post_type_post_type->get_post_type();
		
		$maplocation_post_type_taxonomy_category = new Maplocation_Post_Type_Taxonomy_Category;
		$maplocation_post_type_taxonomy_category->register();
		$this->taxonomies[] = $maplocation_post_type_taxonomy_category->get_taxonomy();
		
		register_taxonomy_for_object_type(
			$maplocation_post_type_taxonomy_category->get_taxonomy(),
			$maplocation_post_type_post_type->get_post_type()
		);
				
		/*$maplocation_post_type_taxonomy_tag = new maplocation_Post_Type_Taxonomy_Tag;
		$maplocation_post_type_taxonomy_tag->register();
		$this->taxonomies[] = $maplocation_post_type_taxonomy_tag->get_taxonomy();
		register_taxonomy_for_object_type(
			$maplocation_post_type_taxonomy_tag->get_taxonomy(),
			$maplocation_post_type_post_type->get_post_type()
		);*/
		
	}

	/**
	 * Unregister post type and taxonomies registrations.
	 */
	public function unregister() {
		global $maplocation_post_type_post_type, $maplocation_post_type_taxonomy_category, $maplocation_post_type_taxonomy_tag;
		$maplocation_post_type_post_type->unregister();
		$this->post_type = null;

		$maplocation_post_type_taxonomy_category->unregister();
		unset( $this->taxonomies[ $maplocation_post_type_taxonomy_category->get_taxonomy() ] );

		$maplocation_post_type_taxonomy_tag->unregister();
		unset( $this->taxonomies[ $maplocation_post_type_taxonomy_tag->get_taxonomy() ] );
	}
}
