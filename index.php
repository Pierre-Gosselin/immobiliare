<?php
// Equivalent d'un include "header.php"
get_header();
?>

<h1 class="text-center my-5">Bienvenue sur le site</h1>
<p><?php bloginfo('description'); ?></p>
<div class="content">

    <?php 
    if (have_posts())
    {
    // S'il y a des articles, on exécute cette partie -->
        while (have_posts())
        {
            //Pour chaque article, on affiche ceci
            the_post();
            echo "<h2>".the_title()."</h2><br>";
            echo "<p>".the_content()."</p>";

        }
    }
    else
    {
    // S'il n'y a pas d'articles, on affiche ceci

    }
    ?>

</div>
<?php
get_footer();
