<?php

/*
 * Add support for useful stuff
 */

add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-formats', array( 'post' ) ); 
add_theme_support( 'custom-header' );
add_theme_support( 'custom-background' );
add_post_type_support( 'page', 'excerpt' );


/*
 * Remove junk
 */

add_filter('show_admin_bar', '__return_false');

remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'start_post_rel_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

function barebones_remove_comments_rss( $for_comments ) {
    return;
}

add_filter( 'post_comments_feed_link', 'barebones_remove_comments_rss' );


/*
 * jQuery the right way
 */

function barebones_scripts() {
  /*
   * For IE8 to play nice, you'll need to include your CSS here, for example:
   *
   * wp_enqueue_style( 'fonts', '//fonts.googleapis.com/css?family=Font+Family' );
   * wp_enqueue_style( 'icons', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' );
   */
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', false, '1.11.1', true );
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ), null, true );
}

add_action( 'wp_enqueue_scripts', 'barebones_scripts' );


/*
 * Nav menus
 */

if ( function_exists( 'register_nav_menus' ) ) {
  register_nav_menus(array(
    'header' => 'Header',
    'footer' => 'Footer'
  ));
}

function barebones_nav_menu_args( $args = '' ) {
  $args['container']       = false;
  $args['container_class'] = false;
  $args['menu_id']         = false;
  $args['items_wrap']      = '<ul class="%2$s">%3$s</ul>';
  return $args;
}

add_filter( 'wp_nav_menu_args', 'barebones_nav_menu_args' );


/*
 * Email
 */

function barebones_mail_from( $email ) {
  return get_option( 'admin_email' );
}
add_filter( 'wp_mail_from', 'barebones_mail_from' );

function barebones_mail_from_name( $name ) {
  return get_bloginfo( 'name' );
}

add_filter( 'wp_mail_from_name', 'barebones_mail_from_name' );
