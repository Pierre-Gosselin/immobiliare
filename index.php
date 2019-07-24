<?php get_header() ?>
      

        
            <h1 class="text-center my-4">Bienvenue sur <?php bloginfo('name'); ?></h1>
            <p><?php bloginfo('description'); ?></p>
      
    <?php 
    
        if(have_posts()){ // si on a des articles
            while (have_posts()){  the_post();// On parcourt les carticles ?>
                <h1><?php the_title(); ?> </h1>
              
           
           <?php }
        }
    
    ?>


<?php get_footer() ?>