<?php
/* Template Name: Meer informatie */
get_header();
?>

<main class="bg-white text-white py-20 px-6">
  <div class="max-w-6xl mx-auto">
    <h1 class="text-4xl font-bold mb-10 text-center text-[#5AA3D5]">Meer informatie</h1>
    
    <?php
    $args = array(
      'post_type'      => 'informatie',
      'posts_per_page' => -1,
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
    );
    $informatie_query = new WP_Query($args);
    ?>

    <?php if ($informatie_query->have_posts()) : ?>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php while ($informatie_query->have_posts()) : $informatie_query->the_post(); ?>
          <a href="<?php the_permalink(); ?>" class="group bg-white/10 backdrop-blur-md border border-white/10 hover:bg-[#5AA3D5]/20 hover:border-[#5AA3D5]/40 transition-all duration-300 rounded-xl p-6 flex flex-col justify-between min-h-[260px] shadow-lg hover:shadow-[#5AA3D5]/40">
            <?php if (has_post_thumbnail()) : ?>
              <div class="overflow-hidden rounded-lg mb-5">
                <?php the_post_thumbnail('medium', ['class' => 'rounded-lg w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500']); ?>
              </div>
            <?php endif; ?>
            <div>
              <h2 class="text-2xl font-semibold mb-2 text-[#5AA3D5]"><?php the_title(); ?></h2>
              <p class="text-sm text-zinc-900 group-hover:text-black/80"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
            </div>
          </a>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php else : ?>
      <p class="text-center text-zinc-400 text-lg">Er zijn momenteel geen informatiepagina’s beschikbaar.</p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>