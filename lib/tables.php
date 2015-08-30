<?php
namespace GrassrootsSelect\Tables;
use GrassrootsSelect\Service;

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
        'show_count' => false,
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

function candidate_custom_column_headers () {
  $columns = array();
  $columns['title'] = 'Title';
  $columns['taxonomy-party'] = 'Political Party';
  $columns['state'] = 'State / District';
  $columns['date'] = 'Date';
  return $columns;
}

function candidate_custom_column_content ($column, $postID) {
  if ($column == 'state') {
    $service = new Service();
    $district = $service->getDistrictByCandidate($postID);
    if (!empty($district)) {
      if (!empty($district->state)) {
        echo $district->state->name . ' - ';
      }
      echo $district->getTitle();
    } else {
      echo '--';
    }
  }
}

add_filter('manage_posts_columns', __NAMESPACE__ . '\\candidate_custom_column_headers');
add_action('manage_posts_custom_column', __NAMESPACE__ . '\\candidate_custom_column_content', 10, 2);
