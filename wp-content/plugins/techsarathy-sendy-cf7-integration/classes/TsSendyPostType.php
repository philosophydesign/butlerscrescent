<?php
/**
 * TsSendyPostType creates a post type specifically designed for
 * sendy lists 
 *
 * @since 1.0.0
 * @author: Rahul Taiwala
 */

class TsSendyPostType
{
    /** @var string $nonceAction */
	static $nonceAction = 'tssendy-nonceAction';
	/** @var string $nonceName */
	static $nonceName = 'tssendy-nonceName';
	/** @var string $postType */
	static $postType = 'tssendy';
	/**
	 * @since 1.3.0
	 */
	static function init()
	{
		add_action('init'                 , array(__CLASS__, 'registerPostType'));
		add_action('save_post'            , array(__CLASS__, 'save'));
		//add_action('admin_enqueue_scripts', array('SlideshowPluginSlideInserter', 'localizeScript'), 11);

		//add_action('admin_action_slideshow_jquery_image_gallery_duplicate_slideshow', array(__CLASS__, 'duplicateSlideshow'), 11);

		add_filter('post_updated_messages', array(__CLASS__, 'alterMessages'));
        add_filter('manage_'.self::$postType.'_posts_columns', array(__CLASS__,'TS_columns_head_only_sendy'), 10);
        add_action('manage_'.self::$postType.'_posts_custom_column', array(__CLASS__,'TS_columns_content_only_sendy'), 10, 2);
		//add_filter('post_row_actions'     , array(__CLASS__, 'duplicateSlideshowActionLink'), 10, 2);
	}

	/**
	 
	 * @since 1.0.0
	 */
	static function registerPostType()
	{
		global $wp_version;

		register_post_type(
			self::$postType,
			array(
				'labels'               => array(
					'name'               => __('Sendy List', 'ts_sendy'),
					'singular_name'      => __('Add Sendy List', 'ts_sendy'),
					'add_new_item'       => __('Add New Sendy List', 'ts_sendy'),
					'edit_item'          => __('Edit Sendy List', 'ts_sendy'),
					'new_item'           => __('New Sendy List', 'ts_sendy'),
					'view_item'          => __('View Sendy List', 'ts_sendy'),
					'search_items'       => __('Search Sendy List', 'ts_sendy'),
					'not_found'          => __('No Sendy List found', 'ts_sendy'),
					'not_found_in_trash' => __('No Sendy List found', 'ts_sendy')
				),
				'public'               => false,
				'publicly_queryable'   => false,
				'show_ui'              => true,
				'query_var'            => true,
				'rewrite'              => true,
				'capability_type'      => 'post',
				'has_archive'          => true,
				'hierarchical'         => false,
				'menu_position'        => null,
				'menu_icon'            => version_compare($wp_version, '3.8', '>') ? TsSendy::getPluginUrl() . '/images/adminIcon.png' : 'dashicons-format-gallery',
				'supports'             => array('title','revisions'),
				'register_meta_box_cb' => array(__CLASS__, 'registerMetaBoxes')
			)
		);
	}
    
    
 
    // CREATE TWO FUNCTIONS TO HANDLE THE COLUMN
    static function TS_columns_head_only_sendy($defaults) {
        $date = $defaults['date'];
        unset($defaults['date']);
        $defaults['shortcode'] = 'Shortcode';
        $defaults['subscribers'] = 'Subscribers';
        $defaults['date'] = $date;
        return $defaults;
    }
    static function TS_columns_content_only_sendy($column_name, $post_ID) {
        if ($column_name == 'subscribers') {
            // show subscribes count for the list column
            $listID=get_post_meta($post_ID,'ts_list_id',true);
            $api=TsSendySettings::getSettingByKey('api_key');
            $url=rtrim(TsSendySettings::getSettingByKey('inst_url'),'/').'/api/subscribers/active-subscriber-count.php';
            $postdata = http_build_query(
                    array(
                    'api_key' => $api,
                    'list_id' => $listID
                    )
            );
                $opts = array('http' => array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                ));
                $context  = stream_context_create($opts);
                $result = file_get_contents($url, false, $context);
                echo $result;
        }elseif($column_name == 'shortcode'){
            $shortCode = htmlentities(sprintf('[' . TsSendyShortcode::$shortCode . ' listID "%s"]', $post_ID));
            echo $shortCode;
        }
    }
	/**
	 
	 * @since 1.0.0
	 */
	static function registerMetaBoxes()
	{
		add_meta_box(
			'tsbtn',
			__('List information', 'ts_sendy'),
			array(__CLASS__, 'tsct_btnMetaBox'),
			self::$postType,
			'normal',
			'high'
		);
        
		
	}
    
    
	/**
	 * 
	 * @since 1.0.0
	 * @param mixed $messages
	 * @return mixed $messages
	 */
	static function alterMessages($messages)
	{
		if (!function_exists('get_current_screen'))
		{
			return $messages;
		}

		$currentScreen = get_current_screen();

		// Return 
		if ($currentScreen->post_type != TsSendyPostType::$postType)
		{
			return $messages;
		}

		$messageID = filter_input(INPUT_GET, 'message', FILTER_VALIDATE_INT);

		if (!$messageID)
		{
			return $messages;
		}

		switch ($messageID)
		{
			case 6:
				$messages[$currentScreen->base][$messageID] = __('Sendy List created', 'ts_sendy');
				break;

			default:
				$messages[$currentScreen->base][$messageID] = __('Sendy List updated', 'ts_sendy');
		}

		return $messages;
	}
    
	
	/**
	 *
	 *
	 * @since 1.0.0
	 */
	static function tsct_btnMetaBox()
	{
		global $post;
        wp_nonce_field(self::$nonceAction, self::$nonceName);
        $shortCode = htmlentities(sprintf('[' . TsSendyShortcode::$shortCode . ' listID "%s"]', $post->ID));
		?>
		<p><?php _e('To use this List in your website add this piece of shortcode to your posts or pages', 'ts_sendy'); ?>:</p>
<p><i><?php echo $shortCode; ?></i></p>
		<div class="row">
            <div class="input-field col s6">
                
                <input type="text" class="input-custom-field" name="ts_list_name" id="ts_list_name"  <?php if(''!=get_post_meta($post->ID, 'ts_list_name', true)){ ?>value="<?php echo get_post_meta($post->ID, 'ts_list_name', true) ?>"<?php }?>>
                <label class="ts-btn-lbl" for="ts_list_name"><?php _e('List Name:', 'ts_sendy') ?></label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                
                <input type="text" class="input-custom-field" name="ts_list_id" id="ts_list_id"  value="<?php echo get_post_meta($post->ID, 'ts_list_id', true) ?>">
                <label class="team-lbl" for="ts_list_id"><?php _e('List Id:', 'ts_sendy') ?></label>
            </div>
        </div>

		<?php

	}

	static function save($postId)
	{
		// Verify nonce, check if user has sufficient rights and return on auto-save.
		if (get_post_type($postId) != self::$postType ||
			(!isset($_POST[self::$nonceName]) || !wp_verify_nonce($_POST[self::$nonceName], self::$nonceAction)) ||
			(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE))
		{
			return $postId;
		}

		if ( ! current_user_can( 'edit_post', $postId ) )
            return $post_id; 

        if(isset($_POST['ts_list_name']))
            update_post_meta( $postId, 'ts_list_name', $_POST['ts_list_name'] );   
        if(isset($_POST['ts_list_id']))
            update_post_meta( $postId, 'ts_list_id', $_POST['ts_list_id'] ); 			
        
        
		return $postId;
	}
    
    static function getSendyLists($id=''){
        global $post;
        $tsbtns=array();
        $query = new WP_Query(array(
				'post_type' => self::$postType,
                'orderby' => 'modified',
				'order'   => 'DESC',
				'posts_per_page'   => -1,
			));
		if($query->have_posts()){
			while($query->have_posts()){
				$query->the_post();
                $tmp=array();
                if(''!==$id){
                    if($post->ID==$id){
                        array_push($tmp,get_post_meta($post->ID, 'ts_list_name', true));
                        array_push($tmp,get_post_meta($post->ID, 'ts_list_id', true));
                        array_push($tsbtns,self::fillArray($tmp));
                        break;
                    }
                }else{
                    array_push($tmp,get_post_meta($post->ID, 'ts_list_name', true));
                    array_push($tmp,get_post_meta($post->ID, 'ts_list_id', true));
                    array_push($tsbtns,self::fillArray($tmp));
                }
            }
        }
        return $tsbtns;
    }
    
    static function fillArray($b){
        $a = array('name', 'id');
        $c = array_combine($a, $b);
        return $c;
    }
}