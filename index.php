<?php
// Traitement du formulaire

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    
    $errors=[];

    $reference = isset($_POST['reference'])? trim(htmlentities($_POST['reference'])): null;
    $lastname = isset($_POST['lastname'])? trim(htmlentities($_POST['lastname'])): null;
    $firstname = isset($_POST['firstname'])? trim(htmlentities($_POST['firstname'])): null;
    $message = isset($_POST['message'])? trim(htmlentities($_POST['message'])): null;
    $housing_id = isset($_POST['housing_id'])? trim(htmlentities($_POST['housing_id'])):null;
    
    if (strlen($reference) == 0)
    {
        $errors['reference'] = "La reference doit contenir au moins 10 caractères";
    }
    if (strlen($lastname) < 2)
    {
        $errors['lastname'] = "Votre nom doit contenir au moins 2 caractères";
    }
    if (strlen($firstname) < 2)
    {
        $errors['firstname'] = "Votre prenom doit contenir au moins 2 caractères";
    }
    if (strlen($message) < 10)
    {
        $errors['message'] = "Votre message doit contenir au moins 10 caractères";
    }

    if (empty($errors))
    {
        // Requète SQL pou insérerla demande de contact
        global $wpdb;

        // Préfixe de la base : $wpdb->prefix = wp_
        $wpdb->insert($wpdb->prefix.'contact',[
            'reference' => $reference,
            'housing_id' => $housing_id,
            'lastname' => $lastname,
            'firstname' => $firstname,
            'message' => $message
        ]);

        $success = 'Votre demande à até envoyé.';

    }
}

?>
<?php get_header(); ?>
        
            <h1 class="text-center my-4">Bienvenue sur <?php bloginfo('name'); ?></h1>
            <p><?php bloginfo('description'); ?></p>
      
    <?php if (!empty($errors)):?>
        <?php foreach ($errors as $key => $error):?>
            <div class="alert alert-danger" role="alert">
                <?php echo $key." : ".$error;?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($success)):?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif;?>


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
                            <?php if (!is_home()): ?>
                                <p>Surface : <?php echo get_post_meta($post->ID, 'surface',true); ?> m²</p>
                                <p>Prix : <?php echo get_post_meta($post->ID, 'prix',true); ?> &euro;</p>
                                <p><?php the_terms( $post->ID, 'city', 'Ville : ' ); ?></p>
                                <p><?php the_terms( $post->ID, 'size', 'Type : ' ); ?></p>
                            <?php endif; ?>
                            <p><?php the_excerpt(); ?></p>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-title="<?php the_title(); ?>" data-id="<?php the_ID(); ?>">
                                Nous contacter
                            </button>
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
     <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="reference" class="reference">      
                        <input type="hidden" name="housing_id" class="id_housing">
                        <div class="form-group">
                            <label for="lastname">Nom</label>
                            <input type="text" class="form-control" id="lastname" name="lastname">
                        </div>
                        <div class="form-group">
                            <label for="firstname">Prenom</label>
                            <input type="text" class="form-control" id="firstname" name="firstname">
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  
    

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>

<?php get_footer(); ?>