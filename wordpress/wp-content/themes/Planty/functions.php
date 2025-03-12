<?php

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css');
    //wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/theme.css', array(), filemtime(get_stylesheet_directory() . '/css/theme.css'));
}

function ajouter_lien_admin_menu($items, $args) {
    // Convertir les items du menu en tableau
    $items_array = explode('</li>', $items);
    
    // Supprime le dernier élément vide dû à explode
    array_pop($items_array);

    if (is_user_logged_in()) {
        // Si connecté, on ajoute "Admin" après "Nous rencontrer"
        $lien_admin = '<li class="menu-item"><a href="' . admin_url() . '">Admin</a></li>';
        $lien_logout = '<li class="menu-item"><a href="' . wp_logout_url(home_url()) . '">Déconnexion</a></li>';
        
        foreach ($items_array as $index => $item) {
            if (strpos($item, 'Nous rencontrer') !== false) {
                array_splice($items_array, $index + 1, 0, $lien_admin);
                break;
            }
        }

        // Ajouter le bouton de déconnexion à la fin du menu
        $items = implode('</li>', $items_array) . '</li>' . $lien_logout;
    } else {
        // Si déconnecté, on ajoute "Connexion" après "Nous rencontrer"
        $lien_login = '<li class="menu-item"><a href="' . wp_login_url() . '">Connexion</a></li>';
        
        foreach ($items_array as $index => $item) {
            if (strpos($item, 'Nous rencontrer') !== false) {
                array_splice($items_array, $index + 1, 0, $lien_login);
                break;
            }
        }

        // Réassembler le menu avec "Connexion" au bon endroit
        $items = implode('</li>', $items_array) . '</li>';
    }
    
    return $items;
}

add_filter('wp_nav_menu_items', 'ajouter_lien_admin_menu', 10, 2);
