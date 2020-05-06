<?php
/**
 * Loop Name: Content Post Detail
 */
$propertyType = get_field('property_type', get_the_ID());
foreach ($propertyType as $key => $value) {
	$propertyId		= get_term($value)->term_id;
	$propertySlug	= get_term($value)->slug;
	$propertyName	= get_term($value)->name;
}
$color = get_field('color', get_the_ID());
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-single'); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header>

    <div class="entry-content">
        <p class="entry-meta">
            <?php
            if ( 'post' === get_post_type() ) {
                if ( function_exists('yoast_breadcrumb') ) { 
                    $breadcrumb = yoast_breadcrumb( '<span id="breadcrumbs" class="bc">','</span>', false);    
                } else {
                $categories_list = get_the_category_list( esc_html__( ', ', 'seed' ) );
                    if ( $categories_list ) {
                        printf( '<span class="cat-links"><i class="si-folder"></i> ' . esc_html__( '%1$s', 'seed' ) . '</span>', $categories_list );
                    } 
                }
            }
            ?>
        </p>
        <?php the_content(); ?>
        <div class="photo-gallery">
            <?php 
            $images = get_field('gallery');
            $size = 'full'; // (thumbnail, medium, large, full or custom size)
            if( $images ): ?>
                <div class="s-slider -dots-in">
                    <?php foreach( $images as $image_id ): ?>
                        <div class="slider">
                            <?php echo wp_get_attachment_image( $image_id, $size ); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="floor-plan-gallery content-waiting">
            <figure id="pic-floorplan" class="wp-block-image size-full" style="background-color: <?php echo $color; ?>;"></figure>
        </div>

        <div class="s-grid project-description-container -d2">

            <div class="project-description">
                <div class="item">
                    <div class="title"><?php echo ($propertySlug == 'condominium') ? 'จำนวนอาคาร' : 'จำนวนเฟส'; ?></div>
                    <div class="desc"><?php the_field('buildings', get_the_ID()); ?></div>
                </div>
                <div class="item">
                    <div class="title">ยูนิตทั้งหมด</div>
                    <div class="desc"><?php the_field('units', get_the_ID()); ?> ยูนิต</div>
                </div>
                <div class="item">
                    <div class="title">พื้นที่โครงการ</div>
                    <div class="desc"><?php the_field('area', get_the_ID()); ?></div>
                </div>
                <?php if($propertySlug == 'condominium'): ?>
                <div class="item">
                    <div class="title">ที่จอดรถ</div>
                    <div class="desc"><?php the_field('park', get_the_ID()); ?></div>
                </div>
                <?php endif; ?>
                <div class="item -bottom">
                    <div class="title">คาดการ<br />โครงการแล้วเสร็จ</div>
                    <div class="desc"><?php the_field('completion_expected', get_the_ID()); ?></div>
                </div>
            </div>

            <div class="room-description">
                <?php if( have_rows('room_type') ): ?>
                    <div class="item">
                        <div class="title"><?php echo ($propertySlug == 'condominium') ? 'ประเภทห้อง' : 'ประเภทบ้าน'; ?></div>
                    </div>
                    <?php while( have_rows('room_type') ): the_row(); 
                        // vars
                        $name = get_sub_field('name');
                        $size = get_sub_field('size');
                    ?>
                        <div class="item<?php echo ($propertySlug == 'home') ? ' -home' : ''; ?>">
                            <?php if( $name ): ?>
                                <div class="title"><?php echo $name; ?></div>
                            <?php endif; ?>
                            <?php if( $size ): ?>
                                <div class="desc"><?php echo $size; ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

        </div>

        <div class="s-grid">
            <div class="facility-description">
                <div class="item">
                    <div class="title">สิ่งอำนวยความสะดวก</div>
                    <div class="desc"><?php the_field('facility', get_the_ID()); ?></div>
                </div>
            </div>
        </div>
        <div class="s-grid">
            <div class="maps-description">
                <div class="item">
                    <div class="title">แผนที่</div>
                    <?php echo get_field('maps', get_the_id()); ?>
                </div>
            </div>
        </div>

        <div class="price-description">
            <div class="item content-waiting -promotion" style="background-color: <?php echo $color; ?>;">
                <div class="s-grid -c3-c9">
                    <div class="title">โปรโมชั่น</div>
                    <div id="label-promotion" class="desc"><?php //the_field('promotion', get_the_ID()); ?></div>
                </div>
            </div>
            <div class="item content-waiting -pricing">
                <div class="s-grid -c3-c9 -middle">
                    <div class="title">แผนการชำระเงิน</div>
                    <div class="desc">
                        <div class="s-grid -m2 -d3">
                            <div class="item">
                                <div class="label">เงินจอง</div>
                                <div id="label-reserve-price" class="pricing"></div>
                            </div>
                            <div class="item">
                                <div class="label">ทำสัญญา</div>
                                <div id="label-contract" class="pricing"></div>
                            </div>
                            <div class="item">
                                <div class="label">เงินดาวน์</div>
                                <div id="label-deposit-price" class="pricing"></div>
                            </div>
                            <div class="item">
                                <div class="label">งวดดาวน์</div>
                                <div id="label-deposit-period" class="pricing"> งวด</div>
                            </div>
                            <div class="item">
                                <div class="label">เงินโอน</div>
                                <div id="label-transfer" class="pricing"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item content-waiting -pricing">
                <div class="s-grid -c3-c9 -middle">
                    <div class="title">รายละเอียดเงินดาวน์</div>
                    <div class="desc">
                        <div id="label-per-period" class="s-grid -m2 -d3"></div>
                    </div>
                </div>
            </div>
            <div class="more-condition">
                <p class="title">เงื่อนไขของยูนิต</p>
                <?php the_field('unit_conditions', get_the_ID()); ?>
                <p class="title online">เงื่อนไขการจองออนไลน์</p>
                <p><a href="<?php echo wp_get_attachment_url(get_field('booking_conditions', get_the_id())); ?>" class="download"><img src="<?php echo get_template_directory_uri(); ?>/img/icon-download2.svg"/><span>ดาวน์โหลดเอกสาร</span></a></p>
            </div>
        </div>
        <?php wp_link_pages( array('before' => '<div class="page-links">' . esc_html__( 'Pages:', 'seed' ),'after'  => '</div>') ); ?>

        <?php if($GLOBALS['s_blog_profile'] == 'enable') :?>
        <div class="entry-author">
            <div class="pic">
                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"
                    rel="author"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'author_bio_avatar_size', 160 ) ); ?></a>
            </div>
            <div class="info">
                <h2 class="name">
                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"
                        rel="author"><?php the_author(); ?></a>
                </h2>
                <?php if(get_the_author_meta( 'description' )) {
                    echo '<div class="desc">'. get_the_author_meta( 'description' ). '</div>';
                }
                ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <footer class="entry-footer">
        <?php seed_entry_footer(); ?>
    </footer>
</article>