<?php
  /* Template Name: Coming Soon */
  get_header();
?>
<div class="coming-soon">
  <div class="coming-soon-content">
    <div class="header">
      <h1>Grassroots Select</h1>
      <h2>Coming Soon</h2>
    </div>
    <div class="newsletter">
      <?php echo(exec("whoami")); ?>
      <?php echo do_shortcode( '[mc4wp_form id="8"]' ); ?>
    </div>
  </div>
</div>


<?php get_footer(); ?>
