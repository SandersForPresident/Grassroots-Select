<?php
  /* Template Name: States */
  get_header();
  $taxonomyTerms = get_terms('state', array(
    'orderby' => 'name',
    'order' => 'asc',
    'hide_empty' => false
  ));
?>

<div id="map" style="width: 1200px; height: 800px;"></div>
<style type="text/css">
path {
  stroke-linejoin: round;
  stroke-linecap: round;
}
svg.active .states path {
  visibility: hidden;
}
svg.active .states path.active {
  visibility: visible;
}

.districts {
  fill: blue;
  stroke: white;
  stroke-width: 0.5px;
}
.district.selected {
  fill: rgb(255,213,125);
}

.state-border {
  stroke: white;
  stroke-width: 1px;
  fill: none;
}
</style>

<?php foreach ($taxonomyTerms as $term): ?>
  <div>
    <h2><a href="<?php echo get_term_link($term); ?>"><?php echo $term->name; ?></a></h2>
  </div>
<?php endforeach; ?>

<?php get_footer(); ?>
