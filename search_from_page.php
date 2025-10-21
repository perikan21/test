<?php
/**
 * Template Name: Search Form Page
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */










get_header(); ?>
<style>
label {
	display: block;
	margin: 10px 0 10px 0;
}

</style>
	<div id="primary" class="site-content">
		<div id="content" role="main">

<form action="<?php bloginfo('url'); ?>/search-page/" method="post">
<p>
<label>Search for</label>
<input type="text" name="keyword" value="<?php echo (!empty($_POST['keyword']))? $_POST['keyword'] : ""; ?>" />
</p>
<p>
<label>Category</label>
<input type="text" name="team_category" value="<?php echo (!empty($_POST['team_category']))? $_POST['team_category'] : ""; ?>" />
</p>
<p>
<label>City</label>
<input type="text" name="city" value="<?php echo (!empty($_POST['city']))? $_POST['city'] : ""; ?>" />
</p>
<p>
<label>Age</label>
<input type="text" name="age" value="<?php echo (!empty($_POST['age']))? $_POST['age'] : ""; ?>" />
</p>

<br />

<p><input type="submit" name="submit" value="Search now" />


</form>


<?php
/*echo '<pre>';
print_r($_POST);
echo '</pre>';*/
//echo $_POST['keyword'];

unset($args);
unset($s);
unset($tax_query);

if(!empty($_POST['keyword'])){
$s =	$_POST['keyword'];
}


if(!empty($_POST['team_category'])){
$tax_query[] = array(
       'taxonomy' => 'team_cat',
       'field' => 'slug',
       'terms' => $_POST['team_category'],
    );
}

$meta_query['relation'] = 'AND';	
if(!empty($_POST['city'])){
$meta_query[] = array( 
'key'	  	=> 'city',	
'value'	  	=> $_POST['city'],
'compare' 	=> 'LIKE',
'type'      => 'string',
	 );
}
if(!empty($_POST['age'])){
$meta_query[] = array( 
'key'	  	=> 'age',	
'value'	  	=> $_POST['age'],
'compare' 	=> '=',
'type'      => 'numeric',
	 );
}




$args =	array(
    		
			'posts_per_page' 	=> -1,
			'post_type' 		=> 'team',
			's' => $s,
			'tax_query' => $tax_query,
			'meta_query' => $meta_query 
			); 


// The Query
$the_query1 = new WP_Query( $args );
 
// The Loop
if ( $the_query1->have_posts() ) {
   
    while ( $the_query1->have_posts() ) :
	$the_query1->the_post();
	
	
	?>
      <div class="service_block">
<?php 
//thumbnail,medium, large, full

$image_arr = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
$image_url = $image_arr[0];  ?>
 		
        
        	<h1> <?php the_title(); ?></h1>   
           	<div class="mimg"><img src="<?php echo $image_url; ?>" /></div>
		   	<div class="txt"><?php the_content(); ?></div>
           	<div style="clear:both;"></div> 
          
          
           <?php if(!empty(get_field('city'))){ ?>
           <p>City: <?php the_field('city'); ?></p>
         	<?php } ?>
           
		   
		   <?php if(!empty(get_field('age'))){ ?>
           <p>Age: <?php the_field('age'); ?></p>
         	<?php } ?>
        	</div>
  
  
  <?php  endwhile;
  
} 

else {
   
   
   
   
}

        ?>





		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
