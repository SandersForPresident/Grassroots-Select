<?php get_header(); ?>
index
<?php while(have_posts()) : the_post(); ?>
  <div>
    <?php the_title(); ?>
  </div>
<?php endwhile; ?>
<?php get_footer(); ?>
