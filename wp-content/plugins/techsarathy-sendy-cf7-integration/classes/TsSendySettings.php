<?php
/**
 * The general settings page is the page.
 *
 *
 * @since 1.0.0
 * @author Rahul Taiwala
 */
class TsSendySettings
{
	/** @var bool $isCurrentPage Flag that represents whether or not the general settings page is the current page */
	static $isCurrentPage = false;

	/** @var string $settingsGroup Settings group */
	static $settingsGroup = 'ts-sendy-settings-group';


	/** @var string $defaultSettings */
	static $defaultSettings = 'ts-sendy-settings';
	

	/**
	 * 
	 *
	 * @since 1.1.0
	 */
	static function init()
	{
		// Only initialize in admin
		if (!is_admin())
		{
			return;
		}

		if (isset($_GET['page']) && $_GET['page'] == 'ts_sendy_settings')
		{
			self::$isCurrentPage = true;
		}

		// Register settings
		add_action('admin_init', array(__CLASS__, 'registerSettings'));

		// Add sub menu
		add_action('admin_menu', array(__CLASS__, 'addSubMenuPage'),9);

		
	}

	/**
	 * 
	 *
	 * @since 1.1.0
	 */
	static function addSubMenuPage()
	{
		
		// Add  menu
		
        
        add_submenu_page('edit.php?post_type='.TsSendyPostType::$postType,
			__('Settings', 'ts_sendy'),
			__('Settings', 'ts_sendy'),
			'manage_options',
			'ts_sendy_settings',
			array(__CLASS__, 'generalSettings')
		);
	}
    
  
	/**
	 * Shows the general settings page.
	 *
	 * @since 1.1.0
	 */
	static function generalSettings()
	{
		// Include general settings page
		include TsSendy::getPluginPath() . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . __CLASS__ . DIRECTORY_SEPARATOR . 'general-settings.php';
	}

	/**
	 * Registers required settings into the WordPress settings API.
	 * Only performed when actually on the general settings page.
	 *
	 * @since 1.1.0
	 */
	static function registerSettings()
	{
		// Register settings only when the user is going through the options.php page
		$urlParts = explode('/', $_SERVER['PHP_SELF']);

		if (array_pop($urlParts) != 'options.php')
		{
			return;
		}

		
		// Register default settings
		register_setting(self::$settingsGroup, self::$defaultSettings);
		

	}
    static function getSettingByKey($key){
        $settings=self::getDefaultSettings();
        return isset($settings[$key])?$settings[$key]:'';
        
    }
    static function getDefaultSettings($fullDefinition = false, $fromDatabase = true)
	{
        $yes = __('Yes', 'ts_sendy');
		$no  = __('No', 'ts_sendy');
		// Default values
		$data = array(
			'api_key' => '',
			'inst_url' => '',
			'success_url' => '',
			'response_msg' => 'You are now subcsribed.',
			'skip_mail'    =>'true',
		);

		// Read defaults from database and merge with $data, when $fromDatabase is set to true
		if ($fromDatabase)
		{
			$data = array_merge(
				$data,
				$customData = get_option(TsSendySettings::$defaultSettings, array())
			);
		}
        ;
		// Full definition
		if ($fullDefinition)
		{
			$descriptions = array(
				'api_key'                   => __('Sendy API Key','ts_sendy'),
				'inst_url'                   => __('Sendy Installation URL','ts_sendy'),
				'success_url'                   => __('URL to redirect after successfull subscription','ts_sendy'),
				'response_msg'                   => __('Response message to be shown upon successfull subscription','ts_sendy'),
				'skip_mail'                   => __('Whether you want to skip sending the mail or not.By default mail is not sent. Set it to \'No\' if you want to send the mail.','ts_sendy'),
				
			);

			$data = array(
				'api_key'                   => 
                array('type' => 'text', 'default' => $data['api_key'] , 'description' => $descriptions['api_key'] , 'group' => __('Default', 'ts_sendy')),
				'inst_url'                   => 
                array('type' => 'text', 'default' => $data['inst_url'] , 'description' => $descriptions['inst_url'] , 'group' => __('Default', 'ts_sendy')),
				'success_url'                   => 
                array('type' => 'text', 'default' => $data['success_url'] , 'description' => $descriptions['success_url'] , 'group' => __('Default', 'ts_sendy')),
				'response_msg'                   => 
                array('type' => 'textarea', 'default' => $data['response_msg'] , 'description' => $descriptions['response_msg'] , 'group' => __('Default', 'ts_sendy')),
				'skip_mail'                   => 
                array('type' => 'radio', 'default' => $data['skip_mail'] , 'description' => $descriptions['skip_mail'] , 'group' => __('Default', 'ts_sendy'),'options' => array('true' => $yes, 'false' => $no)),
				
				);
		}

		// Return
		return $data;
	}
    
    
    
    static function getInputField($settingsKey, $settingsName, $settings, $hideDependentValues = true)
	{
		if (!is_array($settings) ||
			empty($settings) ||
			empty($settingsName))
		{
			return null;
		}

		$inputField   = '';
		$name         = $settingsKey . '[' . $settingsName . ']';
		$displayValue = (!isset($settings['value']) || (empty($settings['value']) && !is_numeric($settings['value'])) ? $settings['default'] : $settings['value']);
		$class        = ((isset($settings['dependsOn']) && $hideDependentValues)? 'depends-on-field-value ' . $settings['dependsOn'][0] . ' ' . $settings['dependsOn'][1] . ' ': '') . $settingsKey . '-' . $settingsName;

		switch($settings['type'])
		{
			case 'text':

				$inputField .= '<input
					type="text"
					name="' . $name . '"
					class="' . $class . '"
					value="' . $displayValue . '"
				/>';

				break;

            case 'hidden':

				$inputField .= '<input
					type="hidden"
					name="' . $name . '"
					class="' . $class . '"
					value="' . $displayValue . '"
				/>';

				break;

            
			case 'textarea':

				$inputField .= '<textarea
					name="' . $name . '"
					class="' . $class . '"
					rows="20"
					cols="60"
				>' . $displayValue . '</textarea>';

				break;

			case 'select':

				$inputField .= '<select name="' . $name . '" class="' . $class . '">';

				foreach ($settings['options'] as $optionKey => $optionValue)
				{
					$inputField .= '<option value="' . $optionKey . '" ' . selected($displayValue, $optionKey, false) . '>
						' . $optionValue . '
					</option>';
				}

				$inputField .= '</select>';

				break;

			case 'radio':

				foreach ($settings['options'] as $radioKey => $radioValue)
				{
					$inputField .= '<label style="padding-right: 10px;"><input
						type="radio"
						name="' . $name . '"
						class="' . $class . '"
						value="' . $radioKey . '" ' .
						checked($displayValue, $radioKey, false) .
						' />' . $radioValue . '</label>';
				}

				break;

			default:

				$inputField = null;

				break;
		};

		// Return
		return $inputField;
	}

	
}