<?php
namespace GrassrootsSelect\States\Taxonomy;

function register_custom_taxonomy() {
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
    'meta_box_cb' => __NAMESPACE__ . '\\custom_metabox',
    'rewrite' => array(
      'slug' => 'states',
      // 'hierarchical' => true,
      'with_front' => false
    )
  ));
}

function custom_metabox() {

}
