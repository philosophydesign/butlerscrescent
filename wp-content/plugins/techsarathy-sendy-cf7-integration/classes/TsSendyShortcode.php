<?php
/**
 * @since 1.1.0
 * @author: Rahul Taiwala
 */
class TsSendyShortcode
{
	/** @var string $shortCode */
	public static $shortCode = 'tssendy';
	/**
	 * Initializes the shortcode
	 *
	 * @since 1.0.0
	 */
	static function init()
	{
		// Initialization code
		
		
	}
    static function wpcf7_hook(){
        
        if (!function_exists('wpcf7_add_shortcode')) {
            return false;
        }
        wpcf7_add_shortcode(self::$shortCode, array(__CLASS__, 'tssendy_short'));
    }
	/**
	 * Function tssendy_short Outputs the Sendy List
	 *
	 * @since 1.1.0
	 * @param mixed $attributes
	 * @return String $output
	 */
	static function tssendy_short($atts)
	{
		
		$output   = '';
        $output = self::prepare($atts);
		

		// Return output
		return $output;
	}

	/**
	 * Function prepare returns the code for the Canvas Paint .
	 *
	 * @since 1.0.0
	 * 
	 * @return String $content
	 */
	static function prepare($atts)
	{ 
        $attr=$atts;
        if(!array_key_exists('listID', $atts) && !empty($atts['options'])){
            $options=$atts['options'];
            $values=$atts['values'];
            
            $attr=array_combine($options,$values);
        }
        extract( shortcode_atts( array('listID' => ''), $attr ) );
        if(''==$listID){
            $lists=TsSendyPostType::getSendyLists();
        }else{
            $lists=TsSendyPostType::getSendyLists($listID);
        }
        
		$output = '';
		ob_start();
		include(TsSendy::getPluginPath() . '/views/' . __CLASS__ . '/sendy.php');
		$output .= ob_get_clean();

		return $output;
	}
    
    static function subscribe_from_cf7($args=null) {
        
        // get the contact form object
        if(isset($_POST['ts_sendy_hidden']) && $_POST['ts_sendy_hidden']==true){
            $wpcf = WPCF7_ContactForm::get_current();

            // if you wanna check the ID of the Form $wpcf->id

            if(isset($_POST['list'])&&!empty($_POST['list'])){
            // If you want to skip mailing the data, you can do it...  
            $wpcf->skip_mail = TsSendySettings::getSettingByKey('skip_mail')=='true'?true:false;
            $oldMSG=$wpcf->prop('messages');
            $oldMSG['mail_sent_ok']=TsSendySettings::getSettingByKey('response_msg');
            
            $wpcf->set_properties(array('messages'=>$oldMSG));
            
            //////////////
            $sendyUrl = rtrim(TsSendySettings::getSettingByKey('inst_url'),'/')."/subscribe";
            //POST variables
            $postData=array();
            foreach($_POST as $key=>$val){
                if (strpos($key, 'ts_') === 0) {
                    // value starts with book_
                    $postData[mb_strtolower(str_replace('ts_','',$key))]=$val;
                }

            }
            
            //$name = $_POST['name'];
            //$email = $_POST['email'];
            $lists = $_POST['list'];
            $postData['boolean'] = 'true';
            //error_log( print_r( $postData, true ),3,"my-errors.log" );
            //error_log( print_r( $args, true ),3,"my-errors.log" );
            //error_log( print_r( $wpcf, true ),3,"my-errors.log" );
            try {
                //Loop through the checkboxes and add them to Sendy if checked
                foreach ($lists as $list)
                {
                    //-------- Subscribe --------//
                    $postData['list']=$list;
                    $postdata = http_build_query($postData);
                    /*
                        array(
                        'name' => $name,
                        'email' => $email,
                        'list' => $list,
                        'boolean' => 'true'
                        )
                    */
                    $opts = array('http' => array(
                        'method'  => 'POST',
                        'header'  => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $postdata
                    ));
                    $context  = stream_context_create($opts);
                    $result = file_get_contents($sendyUrl, false, $context);
                    
                    if($result=="Already subscribed."){
                        $MSG=$wpcf->prop('messages');
                        $MSG['mail_sent_ng']="Already Subscribed";
                        $wpcf->set_properties(array('messages'=>$MSG));
                    }else if (!$result) {
                        //throw new Exception("There was a probleming adding you to the mailing list");
                        $MSG=$wpcf->prop('messages');
                        $MSG['mail_sent_ng']="There was a probleming adding you to the mailing list";
                        $wpcf->set_properties(array('messages'=>$MSG));
                    }
                }
                
                return $wpcf;
            } catch (Exception $e) {
                echo "<script>jQuery('.wpcf7-response-output').html('".$e->getMessage()."').show(); </script>";
            }
        }
            return $wpcf;
        }
    }
	

	
}