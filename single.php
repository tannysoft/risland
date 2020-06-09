<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package seed
 */

get_header();

$propertyType = get_field('property_type', get_the_ID());
foreach ($propertyType as $key => $value) {
	$propertyId		= get_term($value)->term_id;
	$propertySlug	= get_term($value)->slug;
	$propertyName	= get_term($value)->name;
}
$color = get_field('color', get_the_ID());
$secondary_color = get_field('secondary_color', get_the_ID());
?>


<?php
	$singleclass ='';
	if ($GLOBALS['s_blog_layout_single'] == 'full-width') {
		$singleclass = 'single-area';
	} 
?>
<?php while ( have_posts() ) : the_post(); ?>
<?php /*
<div class="prop-navigation">
	<div class="s-container">
		<ul>
			<li<?php echo ($propertySlug == 'condominium') ? ' class="active"' : ''; ?>><a href="#">คอนโดมิเนียม</a></li>
			<li<?php echo ($propertySlug == 'home') ? ' class="active"' : ''; ?>><a href="#">บ้าน</a></li>
		</ul>
	</div>
</div>
*/ ?>
<div class="project-option">
	<div class="option-roomtype" data-property-type="<?php echo $propertySlug; ?>">
		<div class="s-container">
			<div id="option-content" class="option-content -top" style="background-color: <?php echo $color; ?>;">
				<div class="option-room-type">
					<ul id="room-type"></ul>
				</div>
			<?php

			// $args = array(
			//     'meta_key'          => 'issue_date',
			//     'orderby'           => 'meta_value_num', 
			//     'order'             => 'DESC',
			//     'hide_empty'        => true,
			//     'number'            => '4', 
			//     'fields'            => 'all', 
			// ); 

			$args = array(
				'taxonomy'        	=> 'room_type',
				'hide_empty'        => true,
				// 'meta_query'		=> array(
				// 	'relation'		=> 'AND',
				// 	array(
				// 		'key'			=> 'project',
				// 		'value'			=> get_the_ID(),
				// 		'compare'		=> '='
				// 	)
				// )
				// 'meta_query'        => array(
				//   array(
				//     'key'           => 'project', // custom field
				//     'compare'       => '=',
				//     'value'         => get_the_ID()// match exactly "123"
				//   )
				// )
			);

			// $terms = get_terms("room_type", $args);

			// if ( !empty( $terms ) && !is_wp_error( $terms ) ){
			// 	echo "<ul>";
			// 	foreach ( $terms as $term ) {
			// 		echo "<li><a href=\"#\" class=\"room-type\" data-term-id=\"" . $term->term_id . "\">" . $term->name . "</a></li>";
			// 		the_field('issue_date', $term);
			// 	}
			// 	echo "</ul>";
			// }
			?>
			</div>
		</div>
	</div>

	<div class="option-unit">
		<div class="s-container">
			<div class="option-content -detail" style="background-color: <?php echo $secondary_color; ?>;">
				<div class="option-size">
					<div class="title"><?php echo ($propertySlug == 'condominium') ? 'ขนาดห้อง' : 'ขนาดบ้าน'; ?></div>
					<select id="select-size">
						<option value="">&nbsp;</option>
					</select>
				</div>
				<?php if($propertySlug == 'condominium'): ?>
				<div class="option-floor">
					<div class="title">ชั้นที่</div>
					<select id="select-floor">
						<option value="">&nbsp;</option>
					</select>
				</div>
				<?php endif; ?>
				<div class="option-unit">
					<div class="title">UNIT</div>
					<select id="select-unit">
						<option value="">&nbsp;</option>
					</select>
				</div>
			</div>
		</div>
	</div>

	<div class="single-pic">
		<div class="s-container">
			<a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark">
				<?php if(has_post_thumbnail()) { the_post_thumbnail('full');} else { echo '<img src="' . esc_url( get_template_directory_uri()) .'/img/thumb.jpg" alt="'. get_the_title() .'" />'; }?>
			</a>
		</div>
	</div>
</div>

<div class="s-container main-body <?php echo($singleclass);?> <?php echo '-rightbar';?>" data-project-id="<?php the_ID(); ?>">

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php get_template_part( 'template-parts/content-single', get_post_type() ); ?>

            <?php if ( comments_open() || get_comments_number() ) { comments_template(); } ?>

            <?php wp_reset_postdata(); ?>

        </main>
    </div>

	<aside id="rightbar" class="widget-area _heading">
		<div class="widget-area__inner">
			<div class="side-reserve content-waiting" style="background:<?php echo $color; ?>">
				<div class="reserve">
					<div class="title">จองเพียง</div>
					<div id="label-price" class="pricing"></div>
				</div>
				<div class="detail">
					<div class="item">
						<div class="unit">ยูนิต : <span id="label-unit"></span> | </div>
						<div class="size">ขนาด : <span id="label-size"></span> ตร.ม.</div>
					</div>
					<div class="item">
						<div class="title"><span id="label-direction"></span> | </div>
						<div class="pricing">ราคา : <span id="label-unit-price"></span> บาท</div>
					</div>
				</div>
				<div class="form-reserve">
					<div class="agreement">	
						<input type="checkbox" id="agree" name="agree" value="agree">
						<label for="agree"> ยอมรับเงื่อนไขของยูนิต และการจองออนไลน์</label>
					</div>
					<div class="buttons">
						<a href="#" id="btn-booking" class="btn">จองเลย</a>
						<a href="<?php echo get_field('contact_us_page', 'option'); ?>" class="btn">ติดต่อเจ้าหน้าที่</a>
					</div>
				</div>
			</div>
		</div>
	</aside>
    <?php 
	// get_sidebar('right'); 
	?>
</div>
<?php endwhile; ?>
<?php get_footer(); ?>