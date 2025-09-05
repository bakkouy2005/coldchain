<?php
$vacatures_group = get_field('vacatures_group');

if ( $vacatures_group ) :
    $section_title = $vacatures_group['section_title'];
    $cards = $vacatures_group['cards']; // zonder $
?>
<section class="py-16 bg-white">
  <div class="container mx-auto px-4">
    <?php if ($section_title) : ?>
      <h2 class="text-3xl font-bold text-center mb-12">
        <?php echo esc_html($section_title); ?>
      </h2>
    <?php endif; ?>

    <?php if ($cards) : ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($cards as $card) : 
          $img = $card['img'];
          $title = $card['text'];
          $text_area = $card['text_area'];
          $button = $card['button'];
        ?>
          <div class="bg-white rounded-2xl shadow-md overflow-hidden flex flex-col">
            <?php if ($img) : ?>
              <div class="h-48 w-full overflow-hidden">
                <img 
                  src="<?php echo esc_url($img['url']); ?>" 
                  alt="<?php echo esc_attr($img['alt']); ?>" 
                  class="w-full h-full object-cover"
                >
              </div>
            <?php endif; ?>

            <div class="p-6 flex flex-col flex-grow">
              <?php if ($title) : ?>
                <h3 class="text-xl font-semibold mb-3"><?php echo esc_html($title); ?></h3>
              <?php endif; ?>

              <?php if ($text_area) : ?>
                <p class="text-gray-600 mb-6 flex-grow"><?php echo esc_html($text_area); ?></p>
              <?php endif; ?>

              <?php if($button && $button['text'] && $button['url']): ?>
                <a href="<?php echo esc_url($button['url']); ?>"
                   class="mt-auto inline-block bg-blue-900 text-white font-medium px-5 py-3 rounded-lg shadow hover:bg-blue-800 transition duration-300 ease-in-out">
                    <?php echo esc_html($button['text']); ?>
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>
