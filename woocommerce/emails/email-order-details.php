<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$text_align = is_rtl() ? 'right' : 'left';

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<h2>
	<?php
	if ( $sent_to_admin ) {
		$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
		$after  = '</a>';
	} else {
		$before = '';
		$after  = '';
	}
	/* translators: %s: Order ID. */
	echo __('ข้อมูลการจอง');
	// echo wp_kses_post( $before . sprintf( __( '[Order #%s]', 'woocommerce' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) );
	?>
</h2>
<?php
	//var_dump($order->get_order_number());
	foreach ( $order->get_items() as $item_id => $item ) {
		$product_id = $item->get_product_id();
		$variation_id = $item->get_variation_id();
		$product = $item->get_product();
		$name = $item->get_name();
		$quantity = $item->get_quantity();
		$subtotal = $item->get_subtotal();
		$total = $item->get_total();
		$tax = $item->get_subtotal_tax();
		$taxclass = $item->get_tax_class();
		$taxstat = $item->get_tax_status();
		$allmeta = $item->get_meta_data();
		// $somemeta = $item->get_meta( '_whatever', true );
		$type = $item->get_type();
	}

	$projectId = (int)get_field('project', $product_id);

	$roomSize = get_the_terms( $product_id, 'room_size' );
	unset($roomSizeName);
	foreach($roomSize as $key => $value) {
		$roomSizeName = $value->name;
	}

	$floor = get_the_terms( $product_id, 'floor' );
	unset($floorName);
	foreach($floor as $key => $value) {
		$floorName = (int)$value->name;
	}

	$unitPrice = number_format((int)get_field('unit_price', $product_id));

	$total = $order->get_order_item_totals()['order_total']['value'];
	$strTotal = $total . ' บาท';
?>
<p style="padding-bottom: 30px; border-bottom-width: 1px; border-bottom-style: dashed; border-bottom-color: #e5e5e5;">
	<?php echo get_the_title($projectId); ?><br/>
	ยูนิต <?php echo $name; ?> ชั้น <?php echo $floorName; ?> ขนาด <?php echo $roomSizeName; ?> ตร.ม.<br/>
	<?php echo __('ค่าเงินจองที่ชำระ: '); ?> <?php echo $strTotal; ?><br/>
	ราคา <?php echo $unitPrice; ?> บาท<br /><br />
	<a href="<?php echo wp_get_attachment_url(get_field('booking_conditions', $projectId)); ?>">เงื่อนไขการจองออนไลน์</a>
</p>
<?php /*
<div style="margin-bottom: 40px;">
	<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
		<thead>
			<tr>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				$order,
				array(
					'show_sku'      => $sent_to_admin,
					'show_image'    => false,
					'image_size'    => array( 32, 32 ),
					'plain_text'    => $plain_text,
					'sent_to_admin' => $sent_to_admin,
				)
			);
			?>
		</tbody>
		<tfoot>
			<?php
			$item_totals = $order->get_order_item_totals();

			if ( $item_totals ) {
				$i = 0;
				foreach ( $item_totals as $total ) {
					$i++;
					?>
					<tr>
						<th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>"><?php echo wp_kses_post( $total['label'] ); ?></th>
						<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>"><?php echo wp_kses_post( $total['value'] ); ?></td>
					</tr>
					<?php
				}
			}
			if ( $order->get_customer_note() ) {
				?>
				<tr>
					<th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
					<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
				</tr>
				<?php
			}
			?>
		</tfoot>
	</table>
</div>
*/ ?>
<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
