<?php
/**
 * Loop Name: Content Condo
 */
$image          = get_field('front_thumbnail', get_the_ID());
$pricingStart   = get_field('pricing_start', get_the_ID());
$color          = get_field('color', get_the_ID());
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('content-item -minimal -condo'); ?>>
    <div class="pic">
        <a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark">
            <?php
                if(!empty($image)) {
                    echo wp_get_attachment_image( $image, "condo", "", array( "class" => "img-responsive" ) );
                }
                elseif (has_post_thumbnail()) {
                   the_post_thumbnail('condo');
                } else {
                   echo '<img src="' . esc_url(get_template_directory_uri()) .'/img/thumb.jpg" alt="'. get_the_title() .'" />';
                }
            ?>
        </a>
    </div>
    <div class="info">
        <header class="entry-header">
            <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
            <?php if ('post' === get_post_type()) : ?>
            <div class="entry-meta">
                <?php seed_posted_on(); ?>
            </div>
            <?php endif; ?>
        </header>

        <div class="entry-summary">
            <?php the_excerpt();?>
        </div>

        <?php if(!empty($pricingStart)): ?>
        <div class="pricing-start" style="background: <?php echo $color; ?>;">
            <?php echo $pricingStart; ?> ล้าน
        </div>
        <?php endif; ?>

        <footer class="entry-footer">
            <?php seed_entry_footer(); ?>
        </footer>
    </div>
</article>