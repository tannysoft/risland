<?php
/**
 * Loop Name: Content Card
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('content-item -card'); ?>>
    <div class="pic">
        <a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark">
            <?php if(has_post_thumbnail()) { the_post_thumbnail();} else { echo '<img src="' . esc_url( get_template_directory_uri()) .'/img/thumb.jpg" alt="'. get_the_title() .'" />'; }?>
        </a>
    </div>
    <div class="info">
        <header class="entry-header">
            <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        </header>

        <?php if($GLOBALS['s_blog_archive_profile'] == 'disable') {echo '<div class="entry-meta">' . get_seed_posted_on() . '</div>';} ?>

        <div class="entry-summary">
            <?php the_excerpt();?>
        </div>
    </div>
    <?php seed_author(get_the_author_meta('ID'));?>
</article>