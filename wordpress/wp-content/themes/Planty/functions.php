<?php

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css');
}

function ajouter_lien_admin_menu($items, $args) {
    $items_array = explode('</li>', $items);
    array_pop($items_array); // Supprime le dernier élément vide après l'explosion

    // Vérifier si l'utilisateur est connecté
    if (is_user_logged_in()) {
        $lien_admin = '<li class="menu-item"><a href="' . admin_url() . '">Admin</a></li>';

        // Insérer le bouton Admin après "Nous rencontrer"
        foreach ($items_array as $index => $item) {
            if (strpos($item, 'Nous rencontrer') !== false) {
                array_splice($items_array, $index + 1, 0, $lien_admin);
                break;
            }
        }
    }

    // Reconstruire le menu et retourner
    $items = implode('</li>', $items_array) . '</li>';
    return $items;
}

add_filter('wp_nav_menu_items', 'ajouter_lien_admin_menu', 10, 2);
