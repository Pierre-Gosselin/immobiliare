<?php get_header();
the_post();
$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
$image_url = $large_image_url[0] ?? null;
?>

<h1 class="text-center my-5"><?php the_title(); ?></h1>
<em class="text-center"><?php the_category(); ?></em>

<div class="row">
    <div class="offset-md-2 col-lg-8 col-md-10 col-12 article-image" style="background-image:url(<?= $image_url ?>);height:400px;">
        
    </div>
</div>

<div><?php the_content(); ?></div>


<?php get_footer(); ?>