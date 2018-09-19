<?php

function set_data() {
	$data = new stdClass();
	$data->siteUrl = constant('SITE_URL');
	$data->main_menu_id = constant('MAIN_MENU_ID');
	$data->footer_menu_id = constant('FOOTER_MENU_ID');
	$data->facebook = get_option('facebook-plugin');
	$data->homePage = (int)get_option( 'page_on_front' );
	$data->referencesPage = get_page_by_title( 'referencje' )->ID;
	$data->contactPage = get_page_by_title( 'kontakt' )->ID;
	$data->galleryPage = get_page_by_title( 'galeria' )->ID;
	$data->recommendPage = get_page_by_title( 'polecamy' )->ID;
	$data->routes = set_routes();
	return json_encode($data, false);
}

function set_routes(){
    $routes = array();
    $args = array(
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'hierarchical' => 1,
        'exclude' => '',
        'include' => '',
        'meta_key' => '',
        'meta_value' => '',
        'authors' => '',
        'child_of' => 0,
        'parent' => -1,
        'exclude_tree' => '',
        'number' => '',
        'offset' => 0,
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $pages = get_pages($args);
    foreach ($pages as $page){
        $route = new stdClass();
        $route->ID = $page->ID;
        $route->name = strtolower($page->post_title);
        $route->link = get_page_link($page->ID);
        $route->path = str_replace(constant('SITE_URL'), '', $route->link);
        $route->component = get_field('layout', $page->ID);
        $route->site_title = get_field('site_title', $page->ID);
        $route->meta_title = get_field('seo_title', $page->ID);
        $route->meta_desc = get_field('seo_desc', $page->ID);
        $route->view_title = get_field('view_title', $page->ID);
        array_push($routes, $route);
    }
    return $routes;
}
