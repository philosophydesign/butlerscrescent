<?php

class Property_Post_Type_Admin {

	protected $registration_handler;

	public function __construct( $registration_handler ) {
		$this->registration_handler = $registration_handler;
	}

	public function init() {

		// Add thumbnail support for this post type
		$supported = get_theme_support( 'post-thumbnails' );
		if ( $supported !== true ) {

			if ( is_array( $supported ) ) {
				array_push( $supported, $this->registration_handler->post_type );
			} else {
				$supported = array( $this->registration_handler->post_type );
			}

			add_theme_support( 'post-thumbnails', $supported );
		}

		// Add thumbnails to column view
		/*add_filter( 'manage_edit-' . $this->registration_handler->post_type . '_columns', array( $this, 'add_thumbnail_column'), 10, 1 );
		add_action( 'manage_posts_custom_column', array( $this, 'display_thumbnail' ), 10, 1 );*/

		// Add floor to column view
		add_filter( 'manage_edit-' . $this->registration_handler->post_type . '_columns', array( $this, 'add_floor_column'), 10, 1 );
		add_action( 'manage_posts_custom_column', array( $this, 'display_floor' ), 10, 1 );		
		
		// Add beds to column view
		add_filter( 'manage_edit-' . $this->registration_handler->post_type . '_columns', array( $this, 'add_beds_column'), 10, 1 );
		add_action( 'manage_posts_custom_column', array( $this, 'display_beds' ), 10, 1 );
		
		// Add price to column view
		add_filter( 'manage_edit-' . $this->registration_handler->post_type . '_columns', array( $this, 'add_price_column'), 10, 1 );
		add_action( 'manage_posts_custom_column', array( $this, 'display_price' ), 10, 1 );

		// Allow filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'add_taxonomy_filters' ) );

		// Show post counts in the dashboard
		add_action( 'right_now_content_table_end', array( $this, 'add_rightnow_counts' ) );
		add_action( 'dashboard_glance_items', array( $this, 'add_glance_counts' ) );

		// Adds menu icons
		add_action( 'admin_head', array( $this, 'add_icons' ) );
	}

	/**
	 * Add columns to post type list screen.
	 *
	 * @link http://wptheming.com/2010/07/column-edit-pages/
	 *
	 * @param array $columns Existing columns.
	 *
	 * @return array Amended columns.
	 */
	public function add_thumbnail_column( $columns ) {
		$column_thumbnail = array( 'thumbnail' => __( 'Thumbnail', 'property-post-type' ) );
		return array_slice( $columns, 0, 1, true ) + $column_thumbnail + array_slice( $columns, 1, null, true );
	}
	
	public function add_floor_column( $columns ) {
		$column_floor = array( 'floor' => __( 'Floor', 'property-post-type' ) );
		return array_slice( $columns, 0, 4, true ) + $column_floor + array_slice( $columns, 1, null, true );
	}
	
	public function add_beds_column( $columns ) {
		$column_beds = array( 'beds' => __( 'Beds', 'property-post-type' ) );
		return array_slice( $columns, 0, 5, true ) + $column_beds + array_slice( $columns, 1, null, true );
	}
	
	public function add_price_column( $columns ) {
		$column_price = array( 'price' => __( 'Asking Price', 'property-post-type' ) );
		return array_slice( $columns, 0, 6, true ) + $column_price + array_slice( $columns, 1, null, true );
	}

	/**
	 * Custom column callback
	 *
	 * @global stdClass $post Post object.
	 *
	 * @param string $column Column ID.
	 */
	public function display_thumbnail( $column ) {
		switch ( $column ) {
			case 'thumbnail':
				echo get_the_post_thumbnail( get_the_ID(), array( 150, 57 ) );
				break;
		}
	}
	
	public function display_floor( $column ) {
		switch ( $column ) {
			case 'floor':
				echo get_metadata('post', get_the_ID(), 'floor', true);
				break;
		}
	}
	
	public function display_beds( $column ) {
		switch ( $column ) {
			case 'beds':
				echo get_metadata('post', get_the_ID(), 'beds', true);
				break;
		}
	}
	
	public function display_price( $column ) {
		switch ( $column ) {
			case 'price':
				setlocale(LC_MONETARY, 'en_GB.UTF-8');
				if( !($asking_price = get_metadata('post', get_the_ID(), 'asking_price', true )) ) $asking_price = "-"; else $asking_price = money_format('%.0n', $asking_price);
				echo $asking_price;
				break;
		}
	}
	
	/**
	 * Add taxonomy filters to the post type list page.
	 *
	 * Code artfully lifted from http://pippinsplugins.com/
	 *
	 * @global string $typenow
	 */
	public function add_taxonomy_filters() {
		global $typenow;

		// Must set this to the post type you want the filter(s) displayed on
		if ( $this->registration_handler->post_type !== $typenow ) {
			return;
		}

		foreach ( $this->registration_handler->taxonomies as $tax_slug ) {
			echo $this->build_taxonomy_filter( $tax_slug );
		}
	}

	/**
	 * Build an individual dropdown filter.
	 *
	 * @param  string $tax_slug Taxonomy slug to build filter for.
	 *
	 * @return string Markup, or empty string if taxonomy has no terms.
	 */
	protected function build_taxonomy_filter( $tax_slug ) {
		$terms = get_terms( $tax_slug );
		if ( 0 == count( $terms ) ) {
			return '';
		}

		$tax_name         = $this->get_taxonomy_name_from_slug( $tax_slug );
		$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;

		$filter  = '<select name="' . esc_attr( $tax_slug ) . '" id="' . esc_attr( $tax_slug ) . '" class="postform">';
		$filter .= '<option value="0">' . esc_html( $tax_name ) .'</option>';
		$filter .= $this->build_term_options( $terms, $current_tax_slug );
		$filter .= '</select>';

		return $filter;
	}

	/**
	 * Get the friendly taxonomy name, if given a taxonomy slug.
	 *
	 * @param  string $tax_slug Taxonomy slug.
	 *
	 * @return string Friendly name of taxonomy, or empty string if not a valid taxonomy.
	 */
	protected function get_taxonomy_name_from_slug( $tax_slug ) {
		$tax_obj = get_taxonomy( $tax_slug );
		if ( ! $tax_obj )
			return '';
		return $tax_obj->labels->name;
	}

	/**
	 * Build a series of option elements from an array.
	 *
	 * Also checks to see if one of the options is selected.
	 *
	 * @param  array  $terms            Array of term objects.
	 * @param  string $current_tax_slug Slug of currently selected term.
	 *
	 * @return string Markup.
	 */
	protected function build_term_options( $terms, $current_tax_slug ) {
		$options = '';
		foreach ( $terms as $term ) {
			$options .= sprintf(
				'<option value="%s"%s />%s</option>',
				esc_attr( $term->slug ),
				selected( $current_tax_slug, $term->slug, false ),
				esc_html( $term->name . ' (' . $term->count . ')' )
			);
		}
		return $options;
	}

	/**
	 * Add counts to "At a Glance" dashboard widget in WP 3.8+
	 *
	 * @since Unknown
	 */
	public function add_glance_counts() {
		$glancer = new Gamajo_Dashboard_Glancer;
		$glancer->add( $this->registration_handler->post_type, array( 'publish', 'pending' ) );
	}

	/**
	 * Add counts to "Right Now" dashboard widget in WP 3.7-.
	 *
	 * @since Unknown
	 */
	public function add_rightnow_counts() {
		$glancer = new Gamajo_Dashboard_RightNow;
		$glancer->add( $this->registration_handler->post_type, array( 'publish', 'pending' ) );
	}

	/**
	* Displays the portfolio icon in the glance view for version 3.8 and up.
	* Displays the custom post type icon in the dashboard for version 3.7 and below.
	*/
	public function add_icons() {
	
	if ( version_compare( $GLOBALS['wp_version'], '3.8', '>=' ) ) {
		// Styling only needed on dashboard page
			$screen = get_current_screen();
			if ( $screen->id != 'dashboard' ) {
				return;
			}
	?>
<style>
	#dashboard_right_now .property-count a:before {content: "\f322";}
</style>
	<?php 
		}
	}

}