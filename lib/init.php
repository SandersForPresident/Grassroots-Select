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
    )
  );
}
add_action('init', __NAMESPACE__ . '\\custom_post_types');
