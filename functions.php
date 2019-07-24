<?php
function immobiliare_enqueue_styles() {
    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
}

// On attache la fonction 'immobiliare_enqueue_styles' au hook 'wp_enqueue_scripts'
add_action( 'wp_enqueue_scripts', 'immobiliare_enqueue_styles' );