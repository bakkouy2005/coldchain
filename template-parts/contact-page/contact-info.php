<?php 
$info = get_field('contact_info');
if( $info && isset($info['info_items']) && is_array($info['info_items']) ): ?>
<section class="py-8 bg-white">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
        <?php foreach($info['info_items'] as $item): 
            $icon = $item['icon_class'];
            $title = $item['info_title'];
            $value = $item['info_value'];
            $link = $item['info_link'];
        ?>
        <div class="p-4 bg-gray-100 rounded shadow">
            <?php if($icon): ?>
                <div class="text-2xl text-blue-600 mb-2">
                    <i class="<?php echo esc_attr($icon); ?>"></i>
                </div>
            <?php endif; ?>

            <?php if($title): ?>
                <h4 class="font-bold mb-1"><?php echo esc_html($title); ?></h4>
            <?php endif; ?>

            <?php if($link): ?>
                <a href="<?php echo esc_url($link); ?>" class="text-blue-600">
                    <?php echo esc_html($value); ?>
                </a>
            <?php else: ?>
                <p><?php echo esc_html($value); ?></p>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
