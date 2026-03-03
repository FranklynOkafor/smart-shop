<?php

/**
 * The main template file
 */

get_header();
?>

<main class="smartshop-main">
  <?php
  if (have_posts()) :
    while (have_posts()) : the_post();
      the_title('<h2>', '</h2>');
      the_content();
    endwhile;
  endif;
  ?>
</main>

<?php
get_footer();
