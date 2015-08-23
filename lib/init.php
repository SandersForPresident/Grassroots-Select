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
      'has_archive' => 'states',
      'rewrite' => array(
        'with_front' => false,
        'slug' => 'states/%show_category%'
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
      'slug' => 'states',
      // 'hierarchical' => true,
      'with_front' => false
    )
  ));

  register_taxonomy('party', array('candidate', 'district'), array(
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

function show_permalinks($post_link, $id=0) {
  $post = get_post($id);

  if (is_object($post) && $post->post_type == 'district') {
    $terms = wp_get_object_terms($post->ID, 'state');
    if ($terms) {
      return str_replace('%show_category%', $terms[0]->slug, $post_link);
    }
  }
  return $post_link;
}
add_filter('post_type_link', __NAMESPACE__ . '\\show_permalinks', 1, 2);
