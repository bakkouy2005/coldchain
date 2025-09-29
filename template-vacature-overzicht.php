<?php
/* Template Name: Vacature_overzicht_pagina */
get_header();


?>

  <div class="container mx-auto px-4">
<?php
$vacatures = new WP_Query([
  'post_type' => 'vacature',
  'posts_per_page' => -1
]);

if ($vacatures->have_posts()) :
  echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">';
  while ($vacatures->have_posts()) : $vacatures->the_post();
    $id = get_the_ID();
    $functie = get_field('text1', $id);
    $omschrijving = get_field('text_area', $id);
    $img = get_field('img', $id);
    ?>
    
    <div class="bg-white rounded-2xl shadow-md overflow-hidden flex flex-col h-full">
      <?php if ($img): ?>
        <img src="<?php echo esc_url($img['url']); ?>" alt="" class="w-full h-48 object-cover">
      <?php endif; ?>

      <div class="p-6 flex-1 flex flex-col">
        <h3 class="text-xl font-semibold mb-3">
          <?php echo esc_html($functie ?: get_the_title()); ?>
        </h3>
        <?php if (!empty($omschrijving)) : ?>
          <?php
            $max_len = 200;
            $plain = wp_strip_all_tags($omschrijving);
            if (function_exists('mb_strlen') && function_exists('mb_substr')) {
              $display = mb_strlen($plain) > $max_len ? mb_substr($plain, 0, $max_len) . '…' : $plain;
            } else {
              $display = strlen($plain) > $max_len ? substr($plain, 0, $max_len) . '…' : $plain;
            }
          ?>
          <p class="text-gray-700 mb-4 min-h-16"><?php echo esc_html($display); ?></p>
        <?php endif; ?>
        <a href="<?php echo site_url('/vacatures-pagina?id=' . get_the_ID()); ?>"
           class="mt-auto inline-block bg-blue-900 text-white px-5 py-3 rounded-lg shadow hover:bg-blue-800">
          Solliciteer nu
        </a>
      </div>
    </div>
    
    <?php
  endwhile;
  echo '</div>';
  wp_reset_postdata();
endif;
?>
  </div>
  


<?php


get_footer();

?>