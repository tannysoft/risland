<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package seed
 */

get_header();

// $propertyType = get_field('property_type', get_the_ID());
// foreach ($propertyType as $key => $value) {
// 	$propertyId		= get_term($value)->term_id;
// 	$propertySlug	= get_term($value)->slug;
// 	$propertyName	= get_term($value)->name;
// }
// $color = get_field('color', get_the_ID());
// $secondary_color = get_field('secondary_color', get_the_ID());

?>
<?php while ( have_posts() ) : the_post(); ?>

<?php if(!is_front_page() && is_checkout() == false) seed_banner_title(get_the_ID()); ?>

<?php if(is_checkout() == true): ?>
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
			<li<?php echo ($propertySlug == 'condominium') ? ' class="active"' : ''; ?>><a href="#">คอนโดมิเนียม</a></li>
			<li<?php echo ($propertySlug == 'home') ? ' class="active"' : ''; ?>><a href="#">บ้าน</a></li>
		</ul>
	</div>
</div>
<?php endif; ?>
<?php

foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
    $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
        $projectId = get_field('project', $cart_item['product_id']);
        echo '<div class="s-container">';
        echo '<div class="checkout-image">';
        echo get_the_post_thumbnail( $projectId, 'post_thumbnail', array( 'class' => 'img-responsive' ) );
        echo '</div>';
        echo '</div>';
    }
}

?>

<div class="s-container main-body">

    <div id="primary" class="content-area">
        <main id="main" class="site-main hide-title">

            <?php get_template_part( 'template-parts/content', 'page' ); ?>
            <?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>
            <?php wp_reset_postdata(); ?>

        </main>
    </div>
</div>
<?php endwhile; ?>
<?php get_footer(); ?>