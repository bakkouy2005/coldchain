<?php 
// Haal maximaal 3 informatieposts op
$info_query = new WP_Query([
    'post_type'      => 'informatie',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
?>

<section class="py-12 sm:py-16 bg-[#0a131f] text-white text-center">
  <div class="container mx-auto px-4">
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6 sm:mb-10">Meer informatie</h2>

    <?php if ($info_query->have_posts()): ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        <?php while ($info_query->have_posts()): $info_query->the_post(); ?>
          <div class="relative overflow-hidden bg-white text-black rounded-xl shadow p-6 sm:p-8 flex flex-col min-h-[240px] sm:min-h-[280px] lg:min_h-[320px] h-full text-left">
            <!-- Blauwe schuine hoek -->
            <?php $cc_icon = get_field('informatie_icon'); if (empty($cc_icon)) { $cc_icon = 'fa-solid fa-snowflake'; } ?>
            <div class="pointer-events-none absolute inset-y-0
                        right-[-0.75rem] xs:right-[-1rem] sm:right-[-1.25rem] md:right-[-1.75rem] lg:right-[-2rem] xl:right-[-3rem]
                        w-24 xs:w-28 sm:w-32 md:w-36 lg:w-44 xl:w-48
                        bg-[#166ADF]
                        skew-x-[-5deg] xs:skew-x-[-6deg] sm:skew-x-[-8deg] md:skew-x-[-5deg] lg:skew-x-[-10deg] xl:skew-x-[-12deg]
                        transform-gpu will-change-transform transition-all duration-300 ease-in-out"></div>
            <i class="<?php echo esc_attr($cc_icon); ?> absolute top-5 right-5 sm:top-6 sm:right-6 text-white text-xl sm:text-2xl lg:text-3xl z-20"></i>
            
            <h3 class="relative z-10 font-bold text-black text-xl sm:text-2xl lg:text-[28px] leading-tight mb-3 sm:mb-4 pr-16 sm:pr-24 lg:pr-28">
              <?php the_title(); ?>
            </h3>

            <p class="relative z-10 text-black text-sm sm:text-base leading-[1.7] mb-6 pr-16 sm:pr-24 lg:pr-28 max-w-[45ch]">
              <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
            </p>

            <a href="<?php the_permalink(); ?>" 
               class="inline-block self-start mt-auto bg-[#166ADF] text-white font-semibold rounded-md px-5 py-3 text-sm sm:text-base shadow hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-[#5AA3D5] focus:ring-offset-2 focus:ring-offset-[#0a131f] transition">
              Meer info
            </a>

          </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php else: ?>
      <p class="text-white/60">Geen informatie beschikbaar.</p>
    <?php endif; ?>
  </div>
</section>
