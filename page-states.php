<?php
  /* Template Name: States */
  get_header();
?>

<?php
  wp_list_categories(array(
    'taxonomy' => 'state',
    'hide_empty' => false
  ));
?>

<?php get_footer(); ?>
