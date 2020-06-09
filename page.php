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

// if(!is_user_logged_in() && is_checkout()) {
//     wp_redirect( get_site_url() . '/my-account', 301 );
//     exit;
// }

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

<?php if(!is_front_page() && is_checkout() == false && !is_page('my-account') && !is_page('cart')) seed_banner_title(get_the_ID()); ?>

<?php /* if(is_checkout() == true || is_page('my-account')): ?>
    <div class="main-header -minimal">
	<div class="s-container">
        <div class="s-grid -d3">
            <div class="breadcrumbs">
				<?php
				if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
				}
				?>
			</div>
            <div class="main-title _heading">
                <div class="title">ONLINE BOOKING</div>
            </div>
        </div>
	</div>
</div>
<?php endif; */ ?>
<?php /* if(is_checkout() == true): ?>
<div class="prop-navigation">
	<div class="s-container">
		<ul>
			<li<?php echo ($propertySlug == 'condominium') ? ' class="active"' : ''; ?>><a href="#">คอนโดมิเนียม</a></li>
			<li<?php echo ($propertySlug == 'home') ? ' class="active"' : ''; ?>><a href="#">บ้าน</a></li>
		</ul>
	</div>
</div>
<?php endif; */ ?>
<?php
if(is_checkout() == true) {
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
            $projectId = (int)get_field('project', $cart_item['product_id']);

            $color = get_field('color', $projectId);
            $secondary_color = get_field('secondary_color', $projectId);

            $roomType = get_the_terms( $cart_item['product_id'], 'room_type' );
            unset($roomTypeName);
            foreach($roomType as $key => $value) {
                $roomTypeName = $value->name;
            }

            $direction = get_the_terms( $cart_item['product_id'], 'direction' );
            unset($directionName);
            foreach($direction as $key => $value) {
                $directionName = $value->name;
            }

            $roomSize = get_the_terms( $cart_item['product_id'], 'room_size' );
            unset($roomSizeName);
            foreach($roomSize as $key => $value) {
                $roomSizeName = $value->name;
            }

            $floor = get_the_terms( $cart_item['product_id'], 'floor' );
            unset($floorName);
            foreach($floor as $key => $value) {
                $floorName = (int)$value->name;
            }

            $unitPrice = number_format((int)get_field('unit_price', $cart_item['product_id']));

            echo '<div class="section-checkout">';
            echo '<div class="s-container">';

            echo '<div class="checkout-image">';
            echo get_the_post_thumbnail( $projectId, 'post_thumbnail', array( 'class' => 'img-responsive' ) );
            echo '</div>';

            if($floorName !== 0) {
                $floorString = '<span>ชั้น : ' . $floorName . '</span>';
            } else {
                $floorString = '';
            }

            echo '<div class="order-description" style="background-color: ' . $color . ';">';
            echo '<div class="title-confirm"><h2>ยืนยันการจอง</h2></div>';
            echo '<div class="title-confirm"><h3>' . $roomTypeName . ' - ' . get_the_title($projectId) . '</h3></div>';
            echo '<div class="title-confirm"><h4><span>ยูนิต : ' . $_product->get_name() . '&nbsp;' . $directionName . '</span><span>ขนาด : ' . $roomSizeName . ' ตร.ม.</span>' . $floorString . '<span>ราคา : ' . $unitPrice . ' บาท</span></h4></div>';
            echo '<div class="title-confirm"><h5 class="title-link"><a href="' . get_permalink($projectId) . '">แก้ไขข้อมูลการจอง</a></h5></div>';
            echo '<div class="order-line"></div>';
            echo '</div>';

            echo '</div>';
            echo '</div>';
        }
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