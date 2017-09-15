<?php

// Path to the General Settings' views folder
// Default settings
$defaultSettings      = TsSendySettings::getDefaultSettings(true);

?>

<div class="wrap">
	<form method="post" action="options.php">
		<?php settings_fields(TsSendySettings::$settingsGroup); ?>

		
<div class="feature-filter">

	<h4><?php _e('Default Settings', 'ts_sendy'); ?></h4>

	<table>

		<?php $groups = array(); ?>
		<?php foreach($defaultSettings as $defaultSettingKey => $defaultSettingValue): ?>

		<?php if(!empty($defaultSettingValue['group']) && !isset($groups[$defaultSettingValue['group']])): $groups[$defaultSettingValue['group']] = true; ?>

		
		<?php endif; ?>
        
		<tr <?php if($defaultSettingValue['type']=='hidden'){ echo 'class="hidden"';};?>>
			<td>
				<?php echo $defaultSettingValue['description']; ?>
			</td>
			<td>
				<?php

				echo TsSendySettings::getInputField(
					TsSendySettings::$defaultSettings,
					$defaultSettingKey,
					$defaultSettingValue,
					false
				);

				?>
			</td>
		</tr>

		<?php endforeach; ?>
		<?php unset($groups); ?>

	</table>
</div>

		<p>
			<?php submit_button(null, 'primary', null, false); ?>
		</p>
	</form>
</div>