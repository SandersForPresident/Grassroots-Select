<?php
namespace GrassrootsSelect\Init;

function custom_post_types() {
  register_post_type('candidate',
    array(
      'labels' => array(
        'name' => 'Candidates',
        'singular_name' => 'Candidate',
      ),
      'public' => true,
      'has_archive' => true,
    )
  );

  register_post_type('district',
    array(
      'labels' => array(
        'name' => 'Districts',
        'singular_name' => 'Districts'
      ),
      'hierarchical' => true,
      'supports' => array('title', 'page-attributes'),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array(
        'with_front' => true
      )
    )
  );
}
add_action('init', __NAMESPACE__ . '\\custom_post_types');

function custom_taxonomies() {
  register_taxonomy('state', 'district', array(
    'labels' => array(
      'name' => 'States',
      'singular_name' => 'State',
      'search_items' => 'Search States',
      'all_items' => 'All States',
      'parent_item' => 'Parent State',
      'parent_item_colon' => 'Parent State:',
      'edit_item' => 'Edit State',
      'update_item' => 'Update State',
      'add_new_item' => 'Add New State',
      'new_item_name' => 'New State',
      'menu_name' => 'States'
    ),
    'public' => true,
    'show_admin_column' => true,
    'hierarchical' => true,
    'query_var' => true,
    'rewrite' => array(
      'hierarchical' => true,
      'with_front' => true
    )
  ));

  register_taxonomy('party', 'candidate', array(
    'labels' => array(
      'name' => 'Political Parties',
      'singular_name' => 'Political Party'
    ),
    'public' => true,
    'show_admin_column' => true,
    'hierarchical' => true
  ));
}
add_action('init', __NAMESPACE__ . '\\custom_taxonomies');
