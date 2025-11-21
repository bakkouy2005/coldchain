<?php 
$opslag_aanvraag = get_field('opslag_aanvraag');

if ( $opslag_aanvraag && is_array( $opslag_aanvraag ) ) :        
    $text       = $opslag_aanvraag['text'] ?? '';       
    $text_area  = $opslag_aanvraag['text_area'] ?? ''; 
?>

<section class="py-16 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <!-- 2 kolommen: tekst links - formulier rechts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">

            <!-- LINKERKOLOM (nu verticaal gecentreerd) -->
            <div class="order-2 lg:order-1 flex flex-col justify-center h-full">

                <div class="max-w-xl">
                    <?php if ( $text ) : ?>
                        <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 leading-tight mb-4">
                            <?php echo esc_html( $text ); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ( $text_area ) : ?>
                        <div class="h-1 w-16 mb-5 rounded-full" style="background-color:#243866;"></div>
                        <div class="text-base lg:text-lg text-slate-700 leading-relaxed">
                            <?php echo wp_kses_post( $text_area ); ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <!-- RECHTERKOLOM: Formulier -->
            <div class="order-1 lg:order-2">
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 lg:p-8">

                    <!-- jouw formulier blijft exact hetzelfde -->
                    <form action="" method="post" class="space-y-6">

                        <!-- ... NIETS AANGEPAST AAN HET FORMULIER ... -->

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Naam</label>
                                <input type="text" name="naam" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="Uw naam" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Bedrijfsnaam</label>
                                <input type="text" name="bedrijf" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="Uw bedrijf">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">E-mailadres</label>
                                <input type="email" name="email" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="voorbeeld@bedrijf.nl" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Telefoonnummer</label>
                                <input type="tel" name="telefoon" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="+31 6 12345678">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Type goederen</label>
                                <input type="text" name="goederen" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="Bijv. koel, vries, pharma">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Benodigde opslagcapaciteit</label>
                                <input type="text" name="capaciteit" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="Bijv. aantal pallets / m³">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Toelichting / vraag</label>
                            <textarea name="bericht" rows="4" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:ring-1 focus:ring-slate-700" placeholder="Beschrijf kort uw situatie en wensen."></textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
                            <p class="text-xs text-slate-500">
                                Na verzending nemen wij zo snel mogelijk contact met u op over uw aanvraag.
                            </p>
                            <button type="submit" class="rounded-full px-7 py-3 text-sm font-semibold text-white shadow-md hover:shadow-lg transition duration-200" style="background-color:#243866;">
                                Verstuur aanvraag
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

<?php endif; ?>
