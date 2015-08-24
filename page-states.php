<?php
  /* Template Name: States */
  get_header();
?>

<?php
  wp_list_categories(array(
    'taxonomy' => 'state'
  ));
?>

<?php get_footer(); ?>
