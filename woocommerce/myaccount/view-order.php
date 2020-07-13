<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

$notes = $order->get_customer_order_notes();
?>
<p>
<?php
printf(
	/* translators: 1: order number 2: order date 3: order status */
	esc_html__( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce' ),
	'<mark class="order-number">' . $order->get_order_number() . '</mark>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	'<mark class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</mark>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	'<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
);
?>
</p>

<?php if ( $notes ) : ?>
	<h2><?php esc_html_e( 'Order updates', 'woocommerce' ); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="woocommerce-OrderUpdate comment note">
			<div class="woocommerce-OrderUpdate-inner comment_container">
				<div class="woocommerce-OrderUpdate-text comment-text">
					<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n( esc_html__( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<div class="woocommerce-OrderUpdate-description description">
						<?php echo wpautop( wptexturize( $note->comment_content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<section class="woocommerce-order-details">

	<h2 class="woocommerce-order-details__title">รายละเอียดการสั่งซื้อ</h2>

	<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">

		<thead>
			<tr>
				<th class="woocommerce-table__product-name product-name">สินค้า</th>
				<th class="woocommerce-table__product-table product-total">รวม</th>
			</tr>
		</thead>

		<?php
		$order				= wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
		$item_count			= $order->get_item_count() - $order->get_item_count_refunded();
		
		$payment_method		= $order->get_payment_method_title();
		$billing_address	= $order->get_formatted_billing_address();

		$phone				= $order->billing_phone;
		$email				= $order->billing_email;

		$birthday			= get_post_meta( $order->get_id(), 'birthday', true );
		$id_card			= get_post_meta( $order->get_id(), 'id_card', true );

		foreach ( $order->get_items() as $item_id => $item ):
			$product_id		= $item->get_product_id();
			$variation_id	= $item->get_variation_id();
			$product		= $item->get_product();
			$product_price	= $product->get_price();
			$name			= $item->get_name();
			$quantity		= $item->get_quantity();
			$subtotal		= $item->get_subtotal();
			$total			= $item->get_total();
			$tax			= $item->get_subtotal_tax();
			$taxclass		= $item->get_tax_class();
			$taxstat		= $item->get_tax_status();
			$allmeta		= $item->get_meta_data();
			// $somemeta = $item->get_meta( '_whatever', true );
			$type			= $item->get_type();
			$projectId		= (int)get_field('project', $product_id);
		?>
		<tbody>
			<tr class="woocommerce-table__line-item order_item">
				<td class="woocommerce-table__product-name product-name">
					<?php echo $name; ?> <strong class="product-quantity">×&nbsp;<?php echo $quantity; ?></strong>
				</td>

				<td class="woocommerce-table__product-total product-total">
					<span class="woocommerce-Price-amount amount"><?php echo $product_price; ?><span class="woocommerce-Price-currencySymbol">฿</span></span>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th scope="row">รวม:</th>
				<td><span class="woocommerce-Price-amount amount"><?php echo $subtotal; ?><span class="woocommerce-Price-currencySymbol">฿</span></span></td>
			</tr>
			<tr>
				<th scope="row">วิธีการชำระเงิน:</th>
				<td><?php echo $payment_method; ?></td>
			</tr>
			<tr>
				<th scope="row">รวมทั้งหมด:</th>
				<td><span class="woocommerce-Price-amount amount"><?php echo $total; ?><span class="woocommerce-Price-currencySymbol">฿</span></span></td>
			</tr>
		</tfoot>
		<?php
			
		endforeach;
	
		
		?>
		
	</table>

</section>

<section class="woocommerce-customer-details">

	<h2 class="woocommerce-column__title">ที่อยู่ในใบเสร็จ</h2>


	<address>
		<?php echo $billing_address; ?>
		<?php if(!empty($phone)): ?>
		<p class="woocommerce-customer-details--phone"><?php echo $phone; ?></p>
		<?php endif; ?>
		<?php if(!empty($email)): ?>
		<p class="woocommerce-customer-details--email"><?php echo $email; ?></p>
		<?php endif; ?>
	</address>
	<br />
	<dl>
		<dt>&nbsp;วัน/เดือน/ปีเกิด</dt>
		<dd><?php echo $birthday; ?></dd>
		<dt>&nbsp;เลขบัตรประชาชน</dt>
		<dd><?php echo $id_card; ?></dd>
	</dl>
	
</section>

<?php // do_action( 'woocommerce_view_order', $order_id ); ?>
