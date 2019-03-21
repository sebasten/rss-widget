<?php
/*
    Plugin Name: Plus de RSS
    Description: Un widget très basique qui permet d'afficher plus de flux rss avec un texte spécifique et sans modifier à la main le thème
    Version: 1.0
    Author: Sébastien Delahaye
    Author URI: https://github.com/sebasten/rss-widget/
    License: MIT
*/

define("RSS_TITRE","Plus de RSS"); //nom du plugin
define("RSS_ADMINFORM",'<p>Ce widget fait apparaître des liens vers des flux RSS selon la page où il est affiché</p>');
define("RSS_TITREWIDGET",'Flux RSS'); //titre affiché en haut du widget
define("RSS_FLUXPRINCIPAL","Flux RSS général");
define("RSS_FLUXBULLETINS","Flux RSS des bulletins");
define("RSS_FLUXCAT","Flux RSS de ce numéro");
define("RSS_FLUXTAG","Flux RSS de ce mot-clef");

class plusrss extends WP_Widget {

    public function __construct() {
        parent::__construct('plusrss',
            __(RSS_TITRE, 'text_domain'),
            array('customize_selective_refresh' => true,));
    }

    public function form($instance) {    
        echo RSS_ADMINFORM;
    }

    public function update($new_instance, $old_instance) {
        return $new_instance;
    }

    public function widget($args, $instance) {
        $feed = ((substr($_SERVER['REQUEST_URI'],-1) != '/')?'/':'').'feed/';
        echo $before_widget;
        echo '<h2 class="widget-title">'.
            RSS_TITREWIDGET.
            '</h2><div class="widget wp_widget_plugin_box"><ul>';
        echo '<li class="cat-item cat-item2"><a href="'.
            site_url($feed,'https').
            '">'.
            RSS_FLUXPRINCIPAL.
            '</a></li><li><class="cat-item cat-item2"><a href="'.
            site_url('/category/bulletins/'.$feed,'https').
            '">'.
            RSS_FLUXBULLETINS.
            '</a></li>';
        if (substr($_SERVER['REQUEST_URI'],-10) != 'bulletins/') {
            if (preg_match('/tag/',$_SERVER['REQUEST_URI'])) {
                echo '<li class="cat-item cat-item2"><a href="https://'.
                    $_SERVER[HTTP_HOST].
                    $_SERVER[REQUEST_URI].
                    $feed.
                    '">'.
                    RSS_FLUXTAG.
                    '</a></li>'; 
            } elseif (preg_match('/category/',$_SERVER['REQUEST_URI'])) {
                echo '<li class="cat-item cat-item2"><a href="https://'.
                    $_SERVER[HTTP_HOST].
                    $_SERVER[REQUEST_URI].
                    $feed.
                    '">'
                    .RSS_FLUXCAT.
                    '</a></li>'; 
            }
        }
        echo '</ul></div>';
        echo $after_widget;
    }
}

function mesrss() {
    register_widget('plusrss');
}
add_action('widgets_init', 'mesrss');
?>
