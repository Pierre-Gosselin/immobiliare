<?php get_header(); ?>
      

        
            <h1 class="text-center my-4">Bienvenue sur <?php bloginfo('name'); ?></h1>
            <p><?php bloginfo('description'); ?></p>
      
    <div class="row">
    <?php 
    
        if(have_posts()){ // si on a des articles
            while (have_posts()){  the_post();// On parcourt les carticles ?>
                <div class="col-lg-4 col-sm-6">
                    <div class="card shadow my-4">
                        <div class="card-header">
                            <div class="card-title"><h2><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h2></div>
                        </div>
                        <?php the_image(); ?>
                        <div class="card-body">
                            Surface : <?php echo get_post_meta($post->ID, 'surface',true); ?> m²<br>
                            Prix : <?php echo get_post_meta($post->ID, 'prix',true); ?> €
                            <p><?php the_excerpt(); ?></p>
                        </div>    

                        <div class="card-footer text-muted">
                            <blockquote class="blockquote mb-0">        
                                <footer class="blockquote-footer">Publié le <?php echo get_the_date() ?></footer>
                            </blockquote>
                        </div>
                        
                    </div>
                </div>         
           <?php }
        }
    
    ?>
    </div>

<?php get_footer(); ?>