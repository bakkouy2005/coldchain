<?php 
$vacature_text = get_field('vacature_text');

if( $vacature_text ):
    $text1 = $vacature_text['text1'] ?? '';
    $repeater1 = $vacature_text['repeater1'] ?? [];
    $text2 = $vacature_text['text2'] ?? '';
    $repeater2 = $vacature_text['repeater2'] ?? [];
?>

<section class="relative bg-white overflow-hidden">
  <div class="container mx-auto relative z-10 px-6 md:px-12 py-16">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

      <!-- LEFT COLUMN: TEXT1 + REPEATER1 -->
      <div>
        <?php if( !empty($text1) ): ?>
          <h3 class="text-2xl md:text-3xl font-bold leading-tight text-gray-900 mb-4">
            <?php echo esc_html($text1); ?>
          </h3>
        <?php endif; ?>

        <?php if( !empty($repeater1) && is_array($repeater1) ): ?>
          <div class="flex flex-col space-y-4">
            <?php foreach( $repeater1 as $item ): 
                $text_area1 = $item['text_area1'] ?? '';
                $icon_class1 = $item['icon_class'] ?? '';
                if(empty($text_area1)) continue;
            ?>
              <div class="flex items-center space-x-3 text-base md:text-lg leading-relaxed p-2">
                <?php if(!empty($icon_class1)): ?>
                  <i class="<?php echo esc_attr($icon_class1); ?>"></i>
                <?php endif; ?>
                <div>
                  <?php echo wp_kses_post($text_area1); ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- RIGHT COLUMN: TEXT2 + REPEATER2 -->
      <div>
        <?php if( !empty($text2) ): ?>
          <h3 class="text-2xl md:text-3xl font-bold leading-tight text-gray-900 mb-4">
            <?php echo esc_html($text2); ?>
          </h3>
        <?php endif; ?>

        <?php if( !empty($repeater2) && is_array($repeater2) ): ?>
          <div class="flex flex-col space-y-4">
            <?php foreach( $repeater2 as $item ): 
                $text_area2 = $item['text_area2'] ?? '';
                $icon_class2 = $item['icon_class'] ?? '';
                if(empty($text_area2)) continue;
            ?>
              <div class="flex items-center space-x-3 text-base md:text-lg leading-relaxed p-2">
                <?php if(!empty($icon_class2)): ?>
                  <i class="<?php echo esc_attr($icon_class2); ?>"></i>
                <?php endif; ?>
                <div>
                  <?php echo wp_kses_post($text_area2); ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>

<?php endif; ?>
