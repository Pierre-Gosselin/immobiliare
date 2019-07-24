<?php
function immobiliare_enqueue_styles() {
    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.3.1.slim.min.js',[],false,true);
    wp_enqueue_script('popper.js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js',[],false,true);
    wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js',[],false,true);
}


// On attache la fonction 'immobiliare_enqueue_styles' au hook 'wp_enqueue_scripts'
add_action( 'wp_enqueue_scripts', 'immobiliare_enqueue_styles' );


function register_my_menu() {
    register_nav_menu('main-menu', 'Menu principal');
}

add_action( 'init', 'register_my_menu' );

// Register Custom Navigation Walker
require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';

add_theme_support( 'post-thumbnails' );

function the_image()
{
    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
    $image_url = $large_image_url[0] ?? null;
    // $image_url = isset($large_image_url[0])? $large_image_url[0]: null;
    echo '<img src="'.$image_url.'" class="img-fluid">';
}


function register_my_cpt() {
    register_post_type('project', [
        'label' => 'Projets',
        'labels' => [
            'name' => 'Projets',
            'singular_name' => 'Projet',
            'all_items' => 'Tous les projets',
            'add_new_item' => 'Ajouter un projet',
            'edit_item' => 'Éditer le projet',
            'new_item' => 'Nouveau projet',
            'view_item' => 'Voir le projet',
            'search_items' => 'Rechercher parmi les projets',
            'not_found' => 'Pas de projet trouvé',
            'not_found_in_trash' => 'Pas de projet dans la corbeille'
        ],
        'public' => true,
        'supports' => ['title', 'editor', 'author', 'thumbnail'],
        'has_archive' => true,
        'show_in_rest' => true, // Si on veut activer Gutenberg
    ]);
}

add_action( 'init', 'register_my_cpt' );