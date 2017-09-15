<?php
function property_func( $atts ) {
	global $wpdb, $post, $query; // this is how you get access to the database
	
	//$propertydate = array();
	//$html_output = "";
	
	//$fields = array("PLOT NO.","NO. OF BEDS","TYPE","NAME","FLOOR","AVAILABILITY","ASKING PRICE","DETAILS");
	$printed_fields = false;

	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	
	$args = array(
		'post_type' => 'property',
		'order' => 'ASC',
		'paged' => $paged
	);
	
	if( isset($atts['post_status']) ) $args['post_status'] = $atts['post_status'];
	//'post_status' => 'publish',

	$query = new WP_Query( $args );
	
	while( $query->have_posts()) : $query->the_post();
		
		$category = get_the_terms( get_the_ID(), 'property_category');
		$tag = get_the_terms( get_the_ID(), 'property_tag' );
		
		$missing = "N/A";
		
		//if( !($type = get_post_meta( get_the_ID(), 'type', true )) ) $type = $missing;
		if( !($beds = get_post_meta( get_the_ID(), 'beds', true )) ) $beds = $missing;
		if( !($floor = get_post_meta( get_the_ID(), 'floor', true )) ) $floor = $missing;
		if( !($asking_price = get_post_meta( get_the_ID(), 'asking_price', true )) ) $asking_price = $missing;
		
		$permalink = esc_url( get_permalink(get_the_ID()) );
		$details_link = '<a href="' . $permalink . '">View Plot</a>';
		
		/*$row = array(
			'id'=>get_the_ID(),
			'status'=>$post->post_status,
			'title'=>get_the_title(),
			'excerpt'=>get_the_excerpt(),
			'category' => $category,
			'tag' => $tag
		);
		
		if ( isset($category) && count($category) > 0 ) {
			$row['category'] = array();
			for($i = 0; $i <= count($category)-1; $i++){
				if($category[$i]->name && $category[$i]->name != "")array_push($row['category'],$category[$i]->name);
			}
			if( count($row['category']) < 1) unset($row['category']);
		}
		
		if ( isset($tag) && count($tag) > 0 ) {
			$row['tag'] = array();
			for($i = 0; $i <= count($tag)-1; $i++){
				if($tag[$i]->name && $tag[$i]->name != "")array_push($row['tag'],$tag[$i]->name);
			}
			if( count($row['tag']) < 1) unset($row['tag']);
		}
		
		*/

		switch ($post->post_status) {
			case "draft":
				$availability = "Unreleased";
				break;
			
			case "publish":
				$availability = "Available";
				break;
				
			case "reserved":
				$availability = "Reserved";
				break;
			
			case "sold":
				$availability = "Sold";
				break;
		}

		$row = array(
			'PLOT NO'=>get_the_title(),
			'NO. OF BEDS'=>$beds,
			'TYPE'=>$tag,
			'NAME'=>$category,
			'FLOOR'=>$floor,
			'AVAILABILITY'=>$availability,
			'ASKING PRICE'=>$asking_price,
			'DETAILS'=>$details_link
		);
?>
<div class="vc_row wpb_row vc_inner vc_row-fluid result-fields">
<?php 
if($printed_fields == false):
	foreach(array_keys($row) AS $f): ?>
		<div class="wpb_column vc_column_container vc_col-md-1 vc_col-sm-1 vc_hidden-sm vc_hidden-xs">
			<div class="vc_column-inner ">
				<div class="wpb_wrapper">
					<div class="wpb_text_column wpb_content_element ">
						<div class="wpb_wrapper">
							<?php echo $f; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php endforeach;
$printed_fields = true;
endif;
?>
</div>
<?php
		//$propertydate[] = $row;
		//$html_output.= "";?>
<div class="vc_row wpb_row vc_inner vc_row-fluid">
<?php 

$rows = count($row) - 1;
$row_count = 0;

?>
<?php foreach($row AS $k=>$v): ?>
	<div class="wpb_column vc_column_container vc_hidden-lg vc_hidden-md vc_col-sm-6 vc_col-xs-6">
		<div class="vc_column-inner ">
			<div class="wpb_wrapper">
				<div class="wpb_text_column wpb_content_element ">
					<div class="wpb_wrapper">
						<p><?php echo $k . ':'; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wpb_column vc_column_container vc_col-md-1 vc_col-sm-6 vc_col-xs-6">
		<div class="vc_column-inner ">
			<div class="wpb_wrapper">
				<div class="wpb_text_column wpb_content_element ">
					<div class="wpb_wrapper">
						<?php if( is_array($v) ):
							for ($x = 0; $x <= count($v) -1 ; $x++) {
								//echo "The number is: $x <br>";
								if( isset( $v[$x]->name ) )
								{
									echo $v[$x]->name;
								}
								else
								{
									if(!empty($v[$x]) && $v[$x] != ""){
										echo '<pre>';
										print_r($v[$x]);
										echo '</pre>';
									} else echo 'N/A';
								}
								if( $x < count($v) - 1 ) echo ', ';
							}
							//echo '<pre>'; print_r($v); echo '</pre>';
						else: ?>
						<p><?php echo $v; ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	endforeach;
	
	if( $row_count + 1 < $rows ) echo '<hr class="vc_hidden-lg vc_hidden-md" />';
	
	$row_count++;
	?>
	
</div>
<?php
	endwhile;

	
	/*echo '<pre>';
	var_dump($propertydate);
	echo '</pre>';*/
	
	//return $html_output;
}
add_shortcode( 'property-list', 'property_func' );