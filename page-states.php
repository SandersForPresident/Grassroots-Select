<?php
  /* Template Name: States */
  get_header();
  $taxonomyTerms = get_terms('state', array(
    'orderby' => 'name',
    'order' => 'asc',
    'hide_empty' => false
  ));
?>

<?php foreach ($taxonomyTerms as $term): ?>
  <div>
    <h2><a href="<?php echo get_term_link($term); ?>"><?php echo $term->name; ?></a></h2>
  </div>
<?php endforeach; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/topojson/1.6.19/topojson.min.js"></script>

<?php get_footer(); ?>
