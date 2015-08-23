<?php
namespace GrassrootsSelect\Tables;

function restrict_listings_by_taxonomy() {
  global $typenow;
  $args = array('public' => true, '_builtin' => false);
  $post_types = get_post_types($args);
  if (in_array($typenow, $post_types)) {
    $filters = get_object_taxonomies($typenow);
    foreach ($filters as $tax_slug) {
      $tax_obj = get_taxonomy($tax_slug);
      wp_dropdown_categories(array(
        'show_option_all' => 'Show all ' . $tax_obj->label,
        'taxonomy' => $tax_slug,
        'name' => $tax_obj->name,
        'orderby' => 'term_order',
        'selected' => $_GET[$tax_obj->query_var],
        'hierarchical' => $tax_obj->hierarchical,
        'show_count' => true,
        'hide_empty' => false
      ));
    }
  }
}
add_action('restrict_manage_posts', __NAMESPACE__ . '\\restrict_listings_by_taxonomy');

function convert_taxonomy_id_to_taxonomy_term_in_query() {
  global $pagenow;
  global $typenow;
  if ($pagenow == 'edit.php') {
    $filters = get_object_taxonomies($typenow);
    foreach ($filters as $tax_slug) {
      $var = get_query_var($tax_slug);
      if (isset($var)) {
        $term = get_term_by('id', $var, $tax_slug);
        set_query_var($tax_slug, $term->slug);
      }
    }
  }
}
add_filter('parse_query', __NAMESPACE__ . '\\convert_taxonomy_id_to_taxonomy_term_in_query');
