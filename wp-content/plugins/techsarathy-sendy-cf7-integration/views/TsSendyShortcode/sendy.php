<?php
    $cnt=apply_filters('ts_sendy_list_count',count($lists),count($lists));
    foreach($lists as $list){
    ?>
        <input type="checkbox" name="list[]" value="<?php echo $list['id']?>" style="<?php echo 1==$cnt?'display:none;':'';?>" <?php echo 1==$cnt?'checked':'';?>><?php echo 1==$cnt?'':$list['name']?><br/>
    <?php
    }
?>