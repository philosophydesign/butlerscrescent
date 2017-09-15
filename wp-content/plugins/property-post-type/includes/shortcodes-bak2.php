<?php
function property_func( $atts ) {
	global $wpdb, $post, $query; // this is how you get access to the database
	
	$printed_fields = false;

	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	
	$args = array(
		'post_type' => 'property',
		'post_status' => 'publish',
		'order' => 'ASC',
		'paged' => $paged
	);
	
	//if( isset($atts['post_status']) ) $args['post_status'] = $atts['post_status'];
	//$atts['post_status'] = 'publish';

	$query = new WP_Query( $args );
	$posts = $query->found_posts - 1;
	$post_count = 0;
	
	while( $query->have_posts()) : $query->the_post();
		
		$category = get_the_terms( get_the_ID(), 'property_category');
		$tag = get_the_terms( get_the_ID(), 'property_tag' );
		
		$missing = "N/A";
		
		setlocale(LC_MONETARY, 'en_GB.UTF-8');
		
		//if( !($type = get_post_meta( get_the_ID(), 'type', true )) ) $type = $missing;
		if( !($beds = get_post_meta( get_the_ID(), 'beds', true )) ) $beds = $missing;
		if( !($floor = get_post_meta( get_the_ID(), 'floor', true )) ) $floor = $missing;
		if( !($asking_price = get_post_meta( get_the_ID(), 'asking_price', true )) ) $asking_price = $missing; else $asking_price = money_format('%.0n', $asking_price);
		
		$permalink = esc_url( get_permalink(get_the_ID()) );
		$details_link = '<a href="' . $permalink . '">View Plot</a>';

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
			'APPROX GROSS<BR/>INTERNAL SQ FT'=>$floor,
			'AVAILABILITY'=>$availability,
			'PRICE'=>$asking_price,
			'DETAILS'=>$details_link
		);
?>
<div class="vc_row wpb_row vc_inner vc_row-fluid field-names row-light-green">
<?php 
if(!$printed_fields):
	$rows = count(array_keys($row)) - 1;
	$row_count = 0;
	/*foreach(array_keys($row) AS $f):
		<div id="field-filters" class="wpb_column vc_column_container vc_col-md-1 vc_col-sm-1 vc_hidden-sm vc_hidden-xs<?php if( $row_count == $rows ): echo " last-col"; endif; if( $row_count == 0 ) echo " first-col"; ?>">
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
 
	/*$row_count++;
	endforeach;*/
?>

	<div id="field-filters" class="vc_row wpb_row vc_inner vc_row-fluid field-names row-light-green">
			<div class="wpb_column vc_column_container vc_col-md-1 vc_col-sm-12 vc_col-xs-12">
				<div class="vc_column-inner ">
					<div class="wpb_wrapper">
						<div class="wpb_text_column wpb_content_element ">
							<div class="wpb_wrapper">FIND A HOME</div>
						</div>
					</div>
				</div>
			</div>
			<div class="wpb_column vc_column_container vc_col-md-1 vc_col-sm-12 vc_col-xs-12">
				<div class="vc_column-inner ">
					<div class="wpb_wrapper">
						<div class="wpb_text_column wpb_content_element ">
							<div class="wpb_wrapper"><!--NO. OF BEDS--></div>
						</div>
					</div>
				</div>
			</div>
			<div class="wpb_column vc_column_container vc_col-md-1 vc_col-sm-12 vc_col-xs-12">
				<div class="vc_column-inner ">
					<div class="wpb_wrapper">
						<div class="wpb_text_column wpb_content_element ">
							<div class="wpb_wrapper"><!--TYPE--></div>
						</div>
					</div>
				</div>
			</div>
			<div class="wpb_column vc_column_container vc_col-md-1 vc_col-sm-12 vc_col-xs-12">
				<div class="vc_column-inner ">
					<div class="wpb_wrapper">
						<div class="wpb_text_column wpb_content_element ">
							<div class="wpb_wrapper"><!--NAME--></div>
						</div>
					</div>
				</div>
			</div>
			<div class="wpb_column vc_column_container vc_col-md-1 vc_col-sm-12 vc_col-xs-12">
				<div class="vc_column-inner ">
					<div class="wpb_wrapper">
						<div class="wpb_text_column wpb_content_element ">
							<div class="wpb_wrapper"><!--FLOOR--></div>
						</div>
					</div>
				</div>
			</div>
			<div class="wpb_column vc_column_container vc_col-md-1 vc_col-sm-12 vc_col-xs-12">
				<div class="vc_column-inner ">
					<div class="wpb_wrapper">
						<div class="wpb_text_column wpb_content_element ">
							<div class="wpb_wrapper"><!--AVAILABILITY--></div>
						</div>
					</div>
				</div>
			</div>
			<div class="wpb_column vc_column_container vc_col-md-1 vc_col-sm-12 vc_col-xs-12">
				<div class="vc_column-inner ">
					<div class="wpb_wrapper">
						<div class="wpb_text_column wpb_content_element ">
							<div class="wpb_wrapper"><!--ASKING PRICE--></div>
						</div>
					</div>
				</div>
			</div>
			<div class="wpb_column vc_column_container vc_col-md-1 vc_col-sm-12 vc_col-xs-12 last-col">
				<div class="vc_column-inner ">
					<div class="wpb_wrapper">
						<div class="wpb_text_column wpb_content_element ">
							<div class="wpb_wrapper"><!--SEARCH & CLEAR--></div>
						</div>
					</div>
				</div>
			</div>
	</div>

<?php	
	foreach(array_keys($row) AS $f): ?>
		<div class="wpb_column vc_column_container vc_col-md-1 vc_col-sm-1 vc_hidden-sm vc_hidden-xs<?php if( $row_count == $rows ): echo " last-col"; endif; if( $row_count == 0 ) echo " first-col"; ?>">
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
<?php 
	$row_count++;
	endforeach;
	
$printed_fields = true;
endif;
?>
</div>

<div class="vc_row wpb_row vc_inner vc_row-fluid<?php /* odd/even - row-light-green */ if( $post_count % 2) echo ' row-light-green'; ?>">
<?php 

$rows = count($row) - 1;
$row_count = 0;

?>
<?php foreach($row AS $k=>$v): ?>
	<div class="wpb_column vc_column_container vc_hidden-lg vc_hidden-md vc_col-sm-6 vc_col-xs-offset-1 vc_col-sm-offset-0 vc_col-xs-6<?php if( $k=="DETAILS" ): echo " vc_hidden-xs vc_hidden-sm last-col"; endif; if( $k=="PLOT NO" ) echo " first-col";?>">
		<div class="vc_column-inner ">
			<div class="wpb_wrapper">
				<div class="wpb_text_column wpb_content_element">
					<div class="wpb_wrapper">
						<p><?php echo $k . ':'; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wpb_column vc_column_container vc_col-md-1 vc_col-sm-6 vc_col-xs-4 field-values<?php if( $k=="DETAILS" ) echo " vc_hidden-xs vc_hidden-sm last-col"; if( $k=="PLOT NO" ) echo " first-col"; ?>">
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
	<?php if( $k=="DETAILS" ): ?>
	<div class="wpb_column vc_column_container vc_col-sm-12 vc_col-xs-12 field-values vc_hidden-lg vc_hidden-md">
		<div class="vc_column-inner ">
			<div class="wpb_wrapper">
				<div class="wpb_text_column wpb_content_element ">
					<div class="wpb_wrapper">
						<p><?php echo $v; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
<?php
	endforeach;
	
	if( $row_count + 1 <= $rows ) echo '<hr class="vc_hidden-lg vc_hidden-md" />';
	
	$row_count++;
	?>
	
</div>
<?php
		$post_count++;
	endwhile;

	
	/*echo '<pre>';
	var_dump($propertydate);
	echo '</pre>';*/
	
	//return $html_output;
}
add_shortcode( 'property-list', 'property_func' );

function property_cat_func( $atts ) {
	global $post;
	$post_categories = wp_get_object_terms($post->ID, 'property_category');
	return $post_categories[0]->name;
}
add_shortcode( 'property-cat', 'property_cat_func' );

function property_no_func( $atts ) {
	global $post;
	return $post->post_title;
}
add_shortcode( 'property-no', 'property_no_func' );

function property_beds_func( $atts ) {
	global $post;
	return get_post_meta( $post->ID, 'beds', true );
}

add_shortcode( 'property-beds', 'property_beds_func' );

function property_links_func( $atts ) {
	global $post;
	
	$spec_pdf =  get_field('spec_pdf');
	$spec_pdf['size'] = size_format($spec_pdf['id'], 2);
	
	$floorp_pdf = get_field('floorp_pdf');
	$floorp_pdf['size'] = size_format($floorp_pdf['id'], 2);

	/*$data = array( 
			"spec_pdf" => $spec_pdf,
			"floorp_pdf" => $floorp_pdf
		);
		
	echo '<pre>';
	var_dump($data);
	echo '</pre>';*/
	
	$html = '<a target="_blank" href="'.$spec_pdf['url'].'"><i class="vc_btn3-icon fa fa-chevron-down"></i> Download '.$spec_pdf['title'].' ('.$spec_pdf['size'].')</a><br/>';
	$html.= '<a target="_blank" href="'.$floorp_pdf['url'].'"><i class="vc_btn3-icon fa fa-chevron-down"></i> Download '.$floorp_pdf['title'].' ('.$floorp_pdf['size'].')</a>';
	
	return $html;
}

add_shortcode( 'property-links', 'property_links_func' );