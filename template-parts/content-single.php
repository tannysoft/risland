<?php
/**
 * Loop Name: Content Post Detail
 */
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
        <div class="project-description">
            <div class="item">
                <div class="title">จำนวนอาคาร</div>
                <div class="desc"><?php the_field('buildings', get_the_ID()); ?></div>
            </div>
            <div class="item">
                <div class="title">ยูนิตทั้งหมด</div>
                <div class="desc"><?php the_field('units', get_the_ID()); ?></div>
            </div>
            <div class="item">
                <div class="title">พื้นที่โครงการ</div>
                <div class="desc"><?php the_field('area', get_the_ID()); ?></div>
            </div>
            <div class="item">
                <div class="title">ที่จอดรถ</div>
                <div class="desc"><?php the_field('park', get_the_ID()); ?></div>
            </div>
        </div>
        <div class="room-description">
            <?php if( have_rows('room_type') ): ?>
                <div class="item">
                    <div class="title">ประเภทห้อง</div>
                </div>
                <?php while( have_rows('room_type') ): the_row(); 
                    // vars
                    $name = get_sub_field('name');
                    $size = get_sub_field('size');
                ?>
                    <div class="item">
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

        <div class="photo-gallery">
            <figure class="wp-block-image size-full">
                <img src="<?php echo get_template_directory_uri(); ?>/img/demo-room1.jpg" alt="" />
            </figure>
        </div>

        <div class="floor-plan-gallery">
            <figure class="wp-block-image size-full">
            <img src="<?php echo get_template_directory_uri(); ?>/img/demo-plan1.jpg" alt="" />
            </figure>
        </div>

        <div class="price-description">
            <div class="item">
                <div class="s-grid -c3-c9">
                    <div class="title">โปรโมชั่น</div>
                    <div class="desc"><?php the_field('promotion', get_the_ID()); ?></div>
                </div>
            </div>
            <div class="item -pricing">
                <div class="s-grid -c3-c9 -middle">
                    <div class="title">แผนการชำระเงิน</div>
                    <div class="desc">
                        <div class="s-grid -m2 -d3">
                            <div class="item">
                                <div class="label">เงินจอง</div>
                                <div class="pricing"><?php echo number_format(get_field('reserve_price', get_the_ID())); ?></div>
                            </div>
                            <div class="item">
                                <div class="label">ทำสัญญา</div>
                                <div class="pricing"><?php echo number_format(get_field('contract', get_the_ID())); ?></div>
                            </div>
                            <div class="item">
                                <div class="label">เงินดาวน์</div>
                                <div class="pricing"><?php echo number_format(get_field('deposit_price', get_the_ID())); ?></div>
                            </div>
                            <div class="item">
                                <div class="label">งวดดาวน์</div>
                                <div class="pricing"><?php echo number_format(get_field('deposit_period', get_the_ID())); ?> งวด</div>
                            </div>
                            <div class="item">
                                <div class="label">เงินโอน</div>
                                <div class="pricing"><?php echo number_format(get_field('transfer', get_the_ID())); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item -pricing">
                <div class="s-grid -c3-c9 -middle">
                    <div class="title">รายละเอียดเงินดาวน์</div>
                    <div class="desc">
                        <div class="s-grid -m2 -d3">
                            <div class="item">
                                <div class="label">งวดละ</div>
                                <div class="pricing"><?php echo number_format(get_field('per_period', get_the_ID())); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="more-condition">
                <p><a href="#">เงื่อนไขของยูนิต</a></p>
                <p><a href="#">เงื่อนไขการจองออนไลน์</a></p>
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