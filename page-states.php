<?php
  /* Template Name: States */
  get_header();
  $taxonomyTerms = get_terms('state', array(
    'orderby' => 'name',
    'order' => 'asc',
    'hide_empty' => false
  ));
?>

<div id="infowindow">
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
<div id="tooltip">
  District Name: <span></span>
</div>
<div id="map" style="width: 100%; height: 800px;"></div>


<style type="text/css">
#infowindow {
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
#tooltip {
  position: absolute;
  display: none;
  padding: 5px;
  background-color: white;
  border-radius: 2px;
  box-shadow: 0 2px 0 0 rgba(0,0,0,0.3);
  font-size: 14px;
}

path {
  stroke-linejoin: round;
  stroke-linecap: round;
}
svg {
  cursor: pointer;
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
