<?php get_header(); ?>

<?php while(have_posts()) : the_post(); ?>
  <div>
    <?php the_title(); ?>
  </div>
  <section class="entry-content cf">
    <?php the_content(); ?>
  </section>
<?php endwhile; ?>
<?php get_footer(); ?>
