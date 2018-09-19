<?php

function get_map_site() {
    return dynamic_sidebar('footer-links');
}
add_action( 'rest_api_init', function () {
    register_rest_route( 'sidebars/v2', '/map-site', array(
        'methods' => 'GET',
        'callback' => 'get_map_site',
    ) );
} );
