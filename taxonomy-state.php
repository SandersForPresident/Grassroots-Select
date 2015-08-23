<?php while(have_posts()): the_post(); ?>
  <div>
    <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
  </div>
<?php endwhile; ?>
