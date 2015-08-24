<?php
  get_header();
  use GrassrootsSelect\Models\DistrictModel;

  global $post;
  $state = $wp_query->queried_object;
  $districts = array();

  while (have_posts()) {
    the_post();
    $districts[] = new DistrictModel($post);
  }
?>
<div>
  <h1>State: <?php echo $state->name; ?></h1>
</div>


<?php foreach($districts as $district): ?>
<div>
  <h2><a href="<?php echo $district->getPermalink(); ?>"><?php echo $district->getTitle(); ?></a></h2>
  <h3>Party: <?php echo $district->party->name; ?></h3>
  <h3>PVI: <?php echo $district->pvi; ?></h3>
  <h3>Candidates:</h3>
  <div>
    <?php foreach($district->candidates as $candidate): ?>
      <div
        style="padding: 10px; margin: 20px; display: inline-block; margin: 20px; background-color:<?php if ($candidate->isDemocrat()) {echo 'blue';} ?> <?php if ($candidate->isRepublican()) {echo 'red';} ?>;">
        <h3><?php echo $candidate->getTitle(); ?></h3>
          <img src="<?php echo $candidate->featuredImage ?: 'http://placehold.it/100x100' ?>" style="width: 100px;" />
      </div>
    <?php endforeach; ?>
  </div>


</div>
<?php endforeach; ?>

<?php get_footer(); ?>
