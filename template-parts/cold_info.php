<?php
$cold_info = get_field('cold_info');

if ( $cold_info ):
    $people = $cold_info['repeater'] ?? [];

    if ( $people ):
?>
<section class="bg-white py-20">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-gray-900 text-3xl md:text-4xl font-semibold tracking-tight mb-12">
      Ons team
    </h2>

    <div class="flex flex-wrap justify-center gap-10">
      <?php foreach ( $people as $p ):
        $functie   = $p['functie'] ?? '';
        $naam      = $p['naam'] ?? '';
        $mail      = $p['mail'] ?? '';
        $telefoon  = $p['telefoon'] ?? '';
        $tel_href  = preg_replace('/\s+/', '', $telefoon);
      ?>
      <article class="w-full sm:w-[500px] md:w-[560px] lg:w-[620px]
                     min-h-[220px] flex flex-col justify-between
                     rounded-2xl bg-gradient-to-br from-blue-50 via-white to-blue-100
                     border border-blue-100 shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2
                     p-8 text-gray-800 text-left">
        <div>
          <?php if ( $functie ): ?>
            <p class="text-[#3056D3] text-base uppercase font-semibold tracking-wide mb-2">
              <?php echo esc_html($functie); ?>
            </p>
          <?php endif; ?>

          <?php if ( $naam ): ?>
            <h3 class="text-2xl font-bold mb-4 text-gray-900">
              <?php echo esc_html($naam); ?>
            </h3>
          <?php endif; ?>

          <dl class="space-y-1 text-base">
            <?php if ( $telefoon ): ?>
              <div class="flex items-center justify-between gap-3">
                <dt class="text-gray-600">Telefoon</dt>
                <dd>
                  <a href="tel:<?php echo esc_attr($tel_href); ?>"
                     class="text-gray-900 hover:text-[#3056D3] transition font-medium">
                    <?php echo esc_html($telefoon); ?>
                  </a>
                </dd>
              </div>
            <?php endif; ?>

            <?php if ( $mail ): ?>
              <div class="flex items-center justify-between gap-3">
                <dt class="text-gray-600">E-mail</dt>
                <dd>
                  <a href="mailto:<?php echo esc_attr( antispambot($mail) ); ?>"
                     class="text-gray-900 hover:text-[#3056D3] transition font-medium break-all">
                    <?php echo esc_html( antispambot($mail) ); ?>
                  </a>
                </dd>
              </div>
            <?php endif; ?>
          </dl>
        </div>

        <?php if ( $mail || $telefoon ): ?>
          <div class="mt-6 text-center">
            <a href="<?php echo $mail ? 'mailto:' . esc_attr( antispambot($mail) ) : ( $telefoon ? 'tel:' . esc_attr($tel_href) : '#' ); ?>"
               class="inline-flex items-center justify-center rounded-xl px-6 py-2.5 text-base font-medium
                      text-white bg-[#3056D3] hover:bg-[#2347BF] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3056D3] transition">
              Neem contact op
            </a>
          </div>
        <?php endif; ?>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php
    endif;
endif;
?>
