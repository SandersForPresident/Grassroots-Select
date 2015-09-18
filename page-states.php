<?php
  /* Template Name: States */
  get_header();
  $taxonomyTerms = get_terms('state', array(
    'orderby' => 'name',
    'order' => 'asc',
    'hide_empty' => false
  ));
?>

<div id="tooltip">
  <h2>District Name: <span></span></h2>
  <br/>
  <h4>Candidate Name</h4>
  <p>
    Some information about the candidate
  </p>
  <br/>
  <h4>Candidate Name</h4>
  <p>
    Some information about the candidate
  </p>
  <br/>
  <h4>Candidate Name</h4>
  <p>
    Some information about the candidate
  </p>
</div>
<div id="map" style="width: 1200px; height: 800px;"></div>


<style type="text/css">
#tooltip {
  position: absolute;
  display: none;
  top: 20px;
  left: 20px;
  padding: 30px;
  width: 300px;
  background-color: #fff;
  -webkit-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.75);
  -moz-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.75);
  box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.75);
  display: none;
}

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
  fill: purple;
}
.district:hover {
  fill: #61A534;
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
