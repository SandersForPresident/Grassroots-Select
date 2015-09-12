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

      echo "<a href=\"?post_type={$_REQUEST['post_type']}&district_id={$district->post->ID}\">";
      echo $district->getTitle();
      echo "</a>";
      if (!empty($district->state)) {
        echo ", <a href=\"?post_type={$_REQUEST['post_type']}&state_id={$district->state->term_id}\">";
        echo $district->state->name;
        echo "</a>";
      }
    } else {
      echo '--';
    }
  }
}

function candidate_district_query_filter ($join) {
  global $wp_query, $wpdb;
  if (is_admin() && $wp_query->query['post_type'] == 'candidate' && !empty($_GET['district_id'] && intval($_GET['district_id']))) {
    $districtID = intval($_GET['district_id']);
    $join .= "JOIN {$wpdb->postmeta} DPM ON DPM.meta_value LIKE CONCAT('%\"', $wpdb->posts.ID, '\"%') AND DPM.meta_key = 'candidates' ";
    $join .= "AND DPM.post_id = {$districtID}";
  } else if (is_admin() && $wp_query->query['post_type'] == 'candidate' && !empty($_GET['state_id'] && intval($_GET['state_id']))) {
    $stateID = intval($_GET['state_id']);
    $join .= "JOIN {$wpdb->postmeta} DPM ON DPM.meta_value LIKE CONCAT('%\"', $wpdb->posts.ID, '\"%') AND DPM.meta_key = 'candidates' ";
    $join .= "JOIN {$wpdb->term_relationships} CDR ON CDR.object_id = DPM.post_id ";
    $join .= "JOIN {$wpdb->term_taxonomy} ST ON ST.term_taxonomy_id = CDR.term_taxonomy_id AND ST.taxonomy = 'state' AND ST.term_id = '$stateID' ";
  }
  return $join;
}

function restrict_candidate_states () {
  global $typenow;
  $args = array('public' => true, '_builtin' => false);
  $post_types = get_post_types($args);
  if ($typenow == 'candidate') {
    $tax_obj = get_taxonomy('state');
    wp_dropdown_categories(array(
      'show_option_all' => 'Show all States',
      'taxonomy' => 'state',
      'name' => 'state_id',
      'orderby' => 'term_order',
      'selected' => $_GET['state_id'],
      'hierarchical' => $tax_obj->hierarchical,
      'show_count' => false,
      'hide_empty' => false
    ));
  }
}

add_filter('manage_posts_columns', __NAMESPACE__ . '\\candidate_custom_column_headers');
add_action('manage_posts_custom_column', __NAMESPACE__ . '\\candidate_custom_column_content', 10, 2);
add_filter('posts_join', __NAMESPACE__ . '\\candidate_district_query_filter');
add_action('restrict_manage_posts', __NAMESPACE__ . '\\restrict_candidate_states');
