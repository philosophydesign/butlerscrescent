<?php
/**
 * Property Post Type
 *
 * @package   Property_Post_Type
 * @license   GPL-2.0+
 */

/**
 * Register post types and taxonomies.
 *
 * @package Property_Post_Type
 */
class Property_Post_Type_Registrations {

	public $post_type;

	public $taxonomies;

	public function init() {
		// Add the property post type and taxonomies
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 */
	public function register() {
		global $property_post_type_post_type, $property_post_type_taxonomy_category, $property_post_type_taxonomy_tag;

		$property_post_type_post_type = new property_Post_Type_Post_Type;
		$property_post_type_post_type->register();
		$this->post_type = $property_post_type_post_type->get_post_type();
		
		$property_post_type_taxonomy_category = new Property_Post_Type_Taxonomy_Category;
		$property_post_type_taxonomy_category->register();
		$this->taxonomies[] = $property_post_type_taxonomy_category->get_taxonomy();
		
		register_taxonomy_for_object_type(
			$property_post_type_taxonomy_category->get_taxonomy(),
			$property_post_type_post_type->get_post_type()
		);
				
		$property_post_type_taxonomy_tag = new property_Post_Type_Taxonomy_Tag;
		$property_post_type_taxonomy_tag->register();
		$this->taxonomies[] = $property_post_type_taxonomy_tag->get_taxonomy();
		register_taxonomy_for_object_type(
			$property_post_type_taxonomy_tag->get_taxonomy(),
			$property_post_type_post_type->get_post_type()
		);
		
	}

	/**
	 * Unregister post type and taxonomies registrations.
	 */
	public function unregister() {
		global $property_post_type_post_type, $property_post_type_taxonomy_category, $property_post_type_taxonomy_tag;
		$property_post_type_post_type->unregister();
		$this->post_type = null;

		$property_post_type_taxonomy_category->unregister();
		unset( $this->taxonomies[ $property_post_type_taxonomy_category->get_taxonomy() ] );

		$property_post_type_taxonomy_tag->unregister();
		unset( $this->taxonomies[ $property_post_type_taxonomy_tag->get_taxonomy() ] );
	}
}
