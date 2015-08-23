<?php
add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'candidate',
    array(
      'labels' => array(
        'name' => 'Candidates',
        'singular_name' => 'Candidate',
      ),
      'public' => true,
      'has_archive' => true,
    )
  );

  register_post_type( 'states',
    array(
      'labels' => array(
        'name' => 'States',
        'singular_name' => 'State',
        'edit' => 'Edit'
      ),
      'hierarchical' => true,
      'supports' => array('title', 'page-attributes'),
      'public' => true,
      'has_archive' => true,
    )
  );
}
