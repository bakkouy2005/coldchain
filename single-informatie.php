

<?php get_header(); ?>

<main class="bg-white text-black py-20">
  <div class="container mx-auto px-4">
    <?php
    // Breadcrumb navigatie
    echo '<nav class="text-sm text-zinc-400 mb-4">';
    echo '<a href="' . home_url() . '" class="hover:text-[#5AA3D5]">Home</a> › ';
    echo '<a href="' . get_post_type_archive_link('informatie') . '" class="hover:text-[#5AA3D5]">Meer informatie</a> › ';
    echo '<span class="text-[#5AA3D5]">' . get_the_title() . '</span>';
    echo '</nav>';
    ?>
    <h1 class="text-5xl font-bold mb-8 text-[#5AA3D5]"><?php the_title(); ?></h1>
    <?php if (has_post_thumbnail()) : ?>
      <div class="mb-10">
        <?php the_post_thumbnail('large', ['class' => 'rounded-lg w-full h-auto object-cover']); ?>
      </div>
    <?php endif; ?>
    <div class="prose prose-invert max-w-none leading-relaxed text-black">
      <?php the_content(); ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>