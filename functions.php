<?php
function immobiliare_enqueue_styles() {
    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.3.1.slim.min.js',[],false,true);
    wp_enqueue_script('popper.js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js',[],false,true);
    wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js',[],false,true);
    wp_enqueue_script('app', get_template_directory_uri().'/assets/js/app.js',[],false,true);
}


// On attache la fonction 'immobiliare_enqueue_styles' au hook 'wp_enqueue_scripts'
add_action( 'wp_enqueue_scripts', 'immobiliare_enqueue_styles' );


function register_my_menu() {
    register_nav_menu('main-menu', 'Menu principal');
}

add_action( 'init', 'register_my_menu' );

// Register Custom Navigation Walker
require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';

// Images à la une
add_theme_support( 'post-thumbnails' );

function the_image()
{
    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
    $image_url = $large_image_url[0] ?? null;
    // $image_url = isset($large_image_url[0])? $large_image_url[0]: null;
    echo '<img src="'.$image_url.'" class="img-fluid">';
}

// Custom post type
function register_housing() {
    register_post_type('housing', [
        'label' => 'Logements',
        'labels' => [
            'name' => 'Logements',
            'singular_name' => 'Logement',
            'all_items' => 'Tous les logements',
            'add_new_item' => 'Ajouter un logement',
            'edit_item' => 'Éditer le logement',
            'new_item' => 'Nouveau logement',
            'view_item' => 'Voir le logement',
            'search_items' => 'Rechercher parmi les logements',
            'not_found' => 'Pas de logement trouvé',
            'not_found_in_trash' => 'Pas de logement dans la corbeille'
        ],
        'public' => true,
        'supports' => ['title', 'editor', 'author', 'thumbnail'],
        'has_archive' => true,
        'show_in_rest' => true, // Si on veut activer Gutenberg
    ]);
}


add_action( 'init', 'register_housing' );

// Ajouter des villes
function register_city(){
    register_taxonomy('city', 'housing', [
        'label' => 'Villes',
        'labels' => [
            'name' => 'Villes',
            'singular_name' => 'Ville',
            'all_items' => 'Tous les villes',
            'edit_item' => 'Éditer le ville',
            'view_item' => 'Voir le ville',
            'update_item' => 'Mettre à jour le ville',
            'add_new_item' => 'Ajouter un ville',
            'new_item_name' => 'Nouveau ville',
            'search_items' => 'Rechercher parmi les villes',
            'popular_items' => 'villes les plus utilisés'
        ],
        'hierarchical' => true,
        'has_archive' => true,
        'show_in_rest' => true, // Pour Gutenberg
    ]);
}

add_action( 'init', 'register_city' );

// Ajout des types
function register_type(){
    register_taxonomy('size', 'housing', [
        'label' => 'Types',
        'labels' => [
            'name' => 'Types',
            'singular_name' => 'Type',
            'all_items' => 'Tous les types',
            'edit_item' => 'Éditer le type',
            'view_item' => 'Voir le type',
            'update_item' => 'Mettre à jour le type',
            'add_new_item' => 'Ajouter un type',
            'new_item_name' => 'Nouveau type',
            'search_items' => 'Rechercher parmi les types',
            'popular_items' => 'Types les plus utilisés'
        ],
        'hierarchical' => true,
        'show_in_rest' => true, // Pour Gutenberg
    ]);
}

add_action( 'init', 'register_type' );

/*

CREATE TABLE `wordpress`.`wp_contact` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `reference` VARCHAR(255) NOT NULL , `housing_id` INT NOT NULL , `lastname` VARCHAR(255) NOT NULL , `firstname` VARCHAR(255) NOT NULL , `message` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

*/


// Ce hook est executé au moment ou le back office de WP est chargé
add_action( 'admin_menu', 'contact_menu' );

/** Step 1. */
function contact_menu() {
	add_menu_page( 'Demandes de contact', 'Demandes de contact', 'manage_options', 'demande-de-contact', 'contact_page','',2 );
}

/** Step 3. */
function contact_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    echo '<div class="wrap">';
    
    global $wpdb;
	// Récupère tous les articles (Tableau d'objets WP_Post)
    $contacts = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contact");
    ?>
    <style>

    </style>
    <h1>Demandes de contact</h1>
    <table class="table wp-list-table widefat fixed striped posts">
        <thead>
            <tr>
                <th width="50">#</th>
                <th width="150">Référence</th>
                <th width="150">Annonce</th>
                <th width="150">Image</th>
                <th width="150">Nom</th>
                <th width="150">Prenom</th>
                <th width="300">Message</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?= $contact->id; ?></td>
                <td><?= $contact->reference; ?></td>
                <td>
                    <a href="<?php the_permalink($contact->housing_id)?>" target="_blank"><?= $contact->housing_id; ?></a>
                </td>
                <?php
                the_post();
                $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
                $image_url = $large_image_url[0] ?? null;           
                ?>
                <td><img src="<?= $image_url ?>" width="200" height="200"></td>
                <td><?= $contact->lastname; ?></td>
                <td><?= $contact->firstname; ?></td>
                <td><?= $contact->message; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php
	echo '</div>';
}