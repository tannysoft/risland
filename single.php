<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package seed
 */

get_header(); ?>

<?php 
	$singleclass ='';
	if ($GLOBALS['s_blog_layout_single'] == 'full-width') {
		$singleclass = 'single-area';
	} 
?>
<?php while ( have_posts() ) : the_post(); ?>

<div class="main-header -minimal">
	<div class="s-container">
		<div class="main-title _heading">
			<div class="title">ONLINE BOOKING</div>
		</div>
	</div>
</div>

<div class="prop-navigation">
	<div class="s-container">
		<ul>
			<li class="active"><a href="#">คอนโดมิเนียม</a></li>
			<li><a href="#">บ้าน</a></li>
		</ul>
	</div>
</div>

<div class="single-pic">
	<div class="s-container">
		<a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark">
			<?php if(has_post_thumbnail()) { the_post_thumbnail('full');} else { echo '<img src="' . esc_url( get_template_directory_uri()) .'/img/thumb.jpg" alt="'. get_the_title() .'" />'; }?>
		</a>
	</div>
</div>

<div class="s-container main-body <?php echo($singleclass);?> <?php echo '-rightbar';?>">

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php get_template_part( 'template-parts/content-single', get_post_type() ); ?>

            <?php if ( comments_open() || get_comments_number() ) { comments_template(); } ?>

            <?php wp_reset_postdata(); ?>

        </main>
    </div>

	<aside id="rightbar" class="widget-area _heading">
		<div class="side-reserve" style="background:<?php the_field('color', get_the_ID()); ?>">
			<div class="reserve">
				<div class="title">จองเพียง</div>
				<div class="pricing"><?php echo number_format(get_field('reserve_price', get_the_ID())); ?></div>
			</div>
			<div class="detail">
				<div class="s-grid -d2">
					<div class="unit">ยูนิต : SKV23-606</div>
					<div class="size">ขนาด : 29.4 ตร.ม.</div>
				</div>
				<div class="pricing">ราคา : 5,990,000 บาท</div>
			</div>
			<div class="form-reserve">
				<div class="agreement">	
					<input type="checkbox" id="agree" name="agree" value="agree">
					<label for="agree"> ยอมรับเงื่อนไขของยูนิต และการจองออนไลน์</label>
				</div>
				<div class="buttons">
					<a href="#" class="btn">จองเลย</a>
					<a href="#" class="btn">ติดต่อเจ้าหน้าที่</a>
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