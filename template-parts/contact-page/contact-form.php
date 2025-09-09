<?php 
$form = get_field('contact_form');
if( $form ):
    $title = $form['form_title'];
    $shortcode = $form['form_shortcode'];
    if ( empty( $shortcode ) ) {
        $shortcode = '[contact-form-7 id="7295444" title="Zonder titel"]';
    }
?>
<section class="py-12 bg-blue-900 text-white">
    <div class="container mx-auto max-w-xl">
        <?php if($title): ?>
            <h3 class="text-2xl font-bold mb-6"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>
        
        <?php if($shortcode): ?>
            <div class="bg-white p-6 rounded text-black">
                <?php echo do_shortcode($shortcode); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
