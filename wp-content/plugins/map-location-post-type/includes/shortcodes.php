<?php
function maplocation_func( $atts ) {

//list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
$orderby = 'name';
$show_count = 0; // 1 for yes, 0 for no
$pad_counts = 0; // 1 for yes, 0 for no
$hierarchical = 1; // 1 for yes, 0 for no
$taxonomy = 'jobsubscriber_category';
$title = '';

$args = array(
  'orderby' => $orderby,
  'show_count' => $show_count,
  'pad_counts' => $pad_counts,
  'hierarchical' => $hierarchical,
  'taxonomy' => $taxonomy,
  'title_li' => $title
);

//echo '<ul>';
//wp_list_categories($args);
//echo '</ul>';

$categories = get_categories($args);

if( isset($_POST['categories']) ) {
	//wp-once
echo '<pre>';
var_dump($_POST);
echo '</pre>';
	
} else {
echo '<form method="post"><p>';
foreach($categories AS $c):
echo '<label for="'.$c->name.'">'.$c->name.'</label>&nbsp;<input type="checkbox" id="'.$c->name.'" name="categories[]" value="'.$c->cat_ID.'"/><br>';
endforeach;
echo '</p><p><input type="submit" value="submit"/></p>';
echo '</form>';
}
//return $output;

}
add_shortcode( 'maplocation', 'maplocation_func' );