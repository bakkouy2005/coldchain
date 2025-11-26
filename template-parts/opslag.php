<?php 
// filepath: c:\laragon\www\coldchaintest\wp-content\themes\coldchain\template-parts\opslag.php

$opslag = get_field('opslag');

if ( $opslag && is_array($opslag) ) :        
    $text       = $opslag['text'] ?? '';       
    $text_area  = $opslag['text_area'] ?? ''; 
    $button1    = $opslag['button1'] ?? null; 
    $button2    = $opslag['button2'] ?? null; 
    $img        = $opslag['img'] ?? [];
?>

<section class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            <!-- Tekst kolom -->
            <div class="order-2 lg:order-1 lg:pr-8">
                <!-- klein label / eyebrow, kun je aanpassen of weghalen -->
                <p class="text-xs font-semibold tracking-[0.18em] uppercase text-slate-500 mb-3">
                    Opslag &amp; fulfilment
                </p>

                <?php if ( $text ) : ?>
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4 leading-tight">
                        <?php echo esc_html( $text ); ?>
                    </h2>
                <?php endif; ?>

                <!-- blauwe divider -->
                <div class="h-1 w-16 rounded-full mb-6" style="background-color:#243866;"></div>

                <?php if ( $text_area ) : ?>
                    <div class="prose prose-slate prose-lg max-w-none text-slate-700 mb-8">
                        <?php echo wp_kses_post( $text_area ); ?>
                    </div>
                <?php else : ?>
                    <!-- simpele fallback tekst als text_area leeg is -->
                    <p class="text-base text-slate-700 mb-8 leading-relaxed">
                        Norm tekst over de opslagdiensten. Deze tekst kun je invullen via het ACF veld “text_area”.
                    </p>
                <?php endif; ?>

                <!-- kleine, rustige highlights (optioneel, puur layout) -->
                <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    <div class="rounded-xl border border-slate-200 bg-white px-4 py-3">
                        <dt class="text-xs font-medium text-slate-500 mb-1">Temperaturen</dt>
                        <dd class="text-sm font-semibold text-slate-900">Koel, vries &amp; Ambient </dd>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-white px-4 py-3">
                        <dt class="text-xs font-medium text-slate-500 mb-1">Locaties</dt>
                        <dd class="text-sm font-semibold text-slate-900">Utrecht &amp; Breda</dd>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-white px-4 py-3">
                        <dt class="text-xs font-medium text-slate-500 mb-1">Beschikbaarheid</dt>
                        <dd class="text-sm font-semibold text-slate-900">24/7</dd>
                    </div>
                </dl>

                <!-- Buttons -->
                <?php if ( $button1 || $button2 ) : ?>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <?php if ( $button1 ) : ?>
                            <a href="<?php echo esc_url( $button1['url'] ); ?>" 
                               target="<?php echo esc_attr( $button1['target'] ?? '_self' ); ?>"
                               class="inline-flex items-center justify-center px-7 py-3 text-sm font-semibold text-white rounded-md shadow-sm hover:shadow-md transition-shadow duration-200"
                               style="background-color:#243866;">
                                <?php echo esc_html( $button1['text'] ); ?>
                            </a>
                        <?php endif; ?>

                        <?php if ( $button2 ) : ?>
                            <a href="<?php echo esc_url( $button2['url'] ); ?>" 
                               target="<?php echo esc_attr( $button2['target'] ?? '_self' ); ?>"
                               class="inline-flex items-center justify-center px-7 py-3 text-sm font-semibold rounded-md bg-white border hover:bg-slate-50 transition-colors duration-200"
                               style="color:#243866; border-color:#243866;">
                                <?php echo esc_html( $button2['text'] ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Afbeelding kolom -->
            <div class="order-1 lg:order-2">
                <?php if ( ! empty( $img['url'] ) ) : ?>
                    <div class="relative">
                        <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-200 bg-slate-100">
                            <img src="<?php echo esc_url( $img['url'] ); ?>" 
                                 alt="<?php echo esc_attr( $img['alt'] ?? $text ); ?>"
                                 class="w-full h-full object-cover">
                        </div>
                    </div>
                <?php else : ?>
                    <!-- eenvoudige placeholder als er geen afbeelding is -->
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-100/60 px-6 py-12 text-center text-slate-500">
                        <p class="font-medium mb-1">Afbeelding opslag</p>
                        <p class="text-sm">Kies een afbeelding in het ACF veld “img”.</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<?php endif; ?>
