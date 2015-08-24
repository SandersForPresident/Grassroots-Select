<?php
  get_header();
  use GrassrootsSelect\Models\DistrictModel;
  global $post;

  $districts = array();
  while (have_posts()) {
    the_post();
    $districts[] = new DistrictModel($post);
  }

?>
<?php foreach($districts as $district): ?>
<div>
  <h2><a href="<?php echo $district->getPermalink(); ?>"><?php echo $district->getTitle(); ?></a></h2>
</div>
<?php endforeach; ?>

<?php get_footer(); ?>
