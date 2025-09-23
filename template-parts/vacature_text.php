<?php 
$vacature_text = get_field('vacature_text');

if( $vacature_text ):
    $text1 = $vacature_text['text1'] ?? '';
    $repeater1 = $vacature_text['repeater1'] ?? [];
    $text2 = $vacature_text['text2'] ?? '';
    $repeater2 = $vacature_text['repeater2'] ?? [];
?>

<section class="relative bg-[#101E31] overflow-hidden">
  <div class="container mx-auto px-6 md:px-12 py-16">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-16">

      <!-- LEFT COLUMN -->
      <div>
        <?php if( !empty($text1) ): ?>
          <h3 class="text-center text-3xl md:text-4xl font-bold text-white mb-12">
            <?php echo esc_html($text1); ?>
          </h3>
        <?php endif; ?>

        <?php if( !empty($repeater1) && is_array($repeater1) ): ?>
          <div class="flex gap-12 justify-center">
            <?php foreach( array_chunk($repeater1, 4) as $chunk ): ?>
              <div class="flex flex-col space-y-5">
                <?php foreach( $chunk as $item ): 
                  $text_area1 = $item['text_area1'] ?? '';
                  $icon_class1 = $item['icon_class'] ?? '';
                  if(empty($text_area1)) continue;
                ?>
                  <div class="flex items-start space-x-3">
                    <?php if(!empty($icon_class1)): ?>
                      <i class="<?php echo esc_attr($icon_class1); ?> text-[#CACFD6] text-xl mt-1"></i>
                    <?php endif; ?>
                    <p class="text-[#CACFD6] text-lg md:text-xl leading-relaxed">
                      <?php echo wp_kses_post($text_area1); ?>
                    </p>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- RIGHT COLUMN -->
      <div>
        <?php if( !empty($text2) ): ?>
          <h3 class="text-center text-3xl md:text-4xl font-bold text-white mb-12">
            <?php echo esc_html($text2); ?>
          </h3>
        <?php endif; ?>

        <?php if( !empty($repeater2) && is_array($repeater2) ): ?>
          <div class="flex gap-12 justify-center">
            <?php foreach( array_chunk($repeater2, 4) as $chunk ): ?>
              <div class="flex flex-col space-y-5">
                <?php foreach( $chunk as $item ): 
                  $text_area2 = $item['text_area2'] ?? '';
                  $icon_class2 = $item['icon_class'] ?? '';
                  if(empty($text_area2)) continue;
                ?>
                  <div class="flex items-start space-x-3">
                    <?php if(!empty($icon_class2)): ?>
                      <i class="<?php echo esc_attr($icon_class2); ?> text-[#CACFD6] text-xl mt-1"></i>
                    <?php endif; ?>
                    <p class="text-[#CACFD6] text-lg md:text-xl leading-relaxed">
                      <?php echo wp_kses_post($text_area2); ?>
                    </p>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<?php endif; ?>
