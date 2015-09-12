<?php
namespace GrassrootsSelect\Init;

add_theme_support('post-thumbnails');

function rewrite_rules($rules) {
  $newRules = array();
  $newRules['states/(.+)/(.+?)$'] = 'index.php?district=$matches[2]';
  return array_merge($newRules, $rules);
}
add_filter('rewrite_rules_array', __NAMESPACE__ . '\\rewrite_rules');

function custom_post_types() {
  register_post_type('candidate',
    array(
      'labels' => array(
        'name' => 'Candidates',
        'singular_name' => 'Candidate',
      ),
      'supports' => array('title', 'editor', 'thumbnail'),
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
      'supports' => array('title', 'editor'),
      'public' => true,
      // 'has_archive' => 'states',
      'has_archive' => true,
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
      'name' => 'State',
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
    'meta_box_cb' => 'GrassrootsSelect\\TaxonomyDropdownMetabox\\dropdown_metabox',
    'rewrite' => array(
      'slug' => 'states',
      'with_front' => false
    )
  ));

  register_taxonomy('party', array('candidate', 'district'), array(
    'labels' => array(
      'name' => 'Political Party',
      'singular_name' => 'Political Party'
    ),
    'public' => true,
    'show_admin_column' => true,
    'hierarchical' => true,
    'meta_box_cb' => 'GrassrootsSelect\\TaxonomyDropdownMetabox\\dropdown_metabox'
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
