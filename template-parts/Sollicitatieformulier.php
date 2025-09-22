<?php

get_header();
?>

<!-- Hele pagina achtergrond -->
<div class="w-full min-h-screen flex flex-col bg-[#0A131F]">

    <!-- Container uitgelijnd met header/footer -->
    <div class="container mx-auto px-4 py-12 flex-1">

        <?php
        $sollicitatieformulier = get_field('sollicitatieformulier');

        $text1 = $sollicitatieformulier['text1'] ?? '';
        $text_area1 = $sollicitatieformulier['text_area1'] ?? '';
        $img = $sollicitatieformulier['img'] ?? '';
        $text2 = $sollicitatieformulier['text2'] ?? '';
        $text_area2 = $sollicitatieformulier['text_area2'] ?? '';
        ?>

        <!-- Titel en beschrijving -->
        <?php if($text1): ?>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4"><?php echo esc_html($text1); ?></h2>
        <?php endif; ?>
        <?php if($text_area1): ?>
            <p class="text-gray-300 mb-10 text-lg md:text-xl"><?php echo esc_html($text_area1); ?></p>
        <?php endif; ?>

        <!-- Formulier + afbeelding rechts -->
        <div class="md:flex md:gap-8 items-start">

            <!-- Formuliervelden links -->
            <form id="sollicitatie-form" class="flex-1 space-y-6 mb-8">

                <!-- Rij 1: Voor- en Achternaam + E-mailadres -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-white font-medium mb-2">Voor- en Achternaam</label>
                        <input type="text" name="naam" class="w-full p-3 rounded-lg bg-[#1C273B] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm transition-all duration-200" placeholder="Uw naam" required>
                    </div>
                    <div>
                        <label class="block text-white font-medium mb-2">E-mailadres</label>
                        <input type="email" name="email" class="w-full p-3 rounded-lg bg-[#1C273B] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm transition-all duration-200" placeholder="Uw e-mailadres" required>
                    </div>
                </div>

                <!-- Rij 2: Woonplaats + Telefoonnummer -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-white font-medium mb-2">Woonplaats</label>
                        <input type="text" name="woonplaats" class="w-full p-3 rounded-lg bg-[#1C273B] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm transition-all duration-200" placeholder="Uw woonplaats">
                    </div>
                    <div>
                        <label class="block text-white font-medium mb-2">Telefoonnummer</label>
                        <input type="text" name="telefoon" class="w-full p-3 rounded-lg bg-[#1C273B] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm transition-all duration-200" placeholder="Uw telefoonnummer">
                    </div>
                </div>

                <!-- CV upload -->
                <div>
                    <label class="block text-white font-medium mb-2">CV Upload</label>
                    <input type="file" name="cv" class="w-full p-3 rounded-lg bg-[#1C273B] text-white placeholder-gray-400 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm transition-all duration-200">
                </div>

                <!-- Bericht -->
                <div class="md:w-3/4">
                    <label class="block text-white font-medium mb-2">Bericht</label>
                    <textarea name="bericht" class="w-full p-3 rounded-lg bg-[#1C273B] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm transition-all duration-200 min-h-[160px]" rows="6" placeholder="Uw bericht"></textarea>
                </div>

                <!-- Checkbox "Hoe mogen we u contacteren?" -->
                <div class="mb-6">
                    <p class="text-white font-medium mb-3">Hoe mogen we u contacteren?</p>
                    <div class="flex gap-6">
                        <?php
                        $contact_options = ['Telefoon', 'Email', 'WhatsApp'];
                        foreach($contact_options as $option): ?>
                            <label class="flex items-center gap-2 text-white cursor-pointer hover:text-yellow-400 transition-colors">
                                <input type="checkbox" name="contact_method[]" value="<?php echo strtolower($option); ?>" class="accent-blue-500 w-4 h-4">
                                <span class="select-none"><?php echo $option; ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Verstuur knop -->
                <div>
                    <button type="submit" class="px-8 py-2 rounded-lg font-bold text-white bg-[#004DFF] hover:bg-[#FDB314] transition-all duration-300 shadow-md hover:shadow-lg">Verstuur</button>
                </div>
            </form>

            <!-- Afbeelding + tip rechts -->
            <div class="mt-6 md:mt-0 md:w-1/3 space-y-6">
                <?php if($img): ?>
                    <div class="rounded-lg overflow-hidden shadow-lg">
                        <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" class="w-full h-auto">
                    </div>
                <?php endif; ?>

                <?php if($text2 || $text_area2): ?>
                    <div class="bg-gray-800 p-4 rounded-lg shadow-md">
                        <?php if($text2): ?>
                            <h3 class="text-white font-semibold mb-2 text-lg"><?php echo esc_html($text2); ?></h3>
                        <?php endif; ?>
                        <?php if($text_area2): ?>
                            <p class="text-gray-300 text-sm"><?php echo esc_html($text_area2); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<!-- Popup Modal -->
<div id="popup" class="fixed inset-0 bg-[#0A131F] bg-opacity-95 hidden items-center justify-center z-50 transition-opacity duration-500 ease-out">
    <div id="popupContent" class="transform translate-y-10 opacity-0 rounded-lg shadow-lg max-w-md w-full p-6 text-center border border-gray-700 transition-all duration-500 ease-out">
        <!-- Blauw vinkje -->
        <div class="flex justify-center mb-4">
            <svg class="w-16 h-16 text-[#004DFF]" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M20.707 5.293a1 1 0 010 1.414L10.414 17l-5.121-5.121a1 1 0 011.414-1.414L10.414 14.172l9.879-9.879a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-white mb-4">Bedankt - Uw sollicitatie is verzonden</h2>
        <p class="text-gray-300 mb-6">We sturen u een bevestiging per e-mail. Wij nemen binnen 5 werkdagen contact met u op.</p>
        <button id="closePopup" class="px-6 py-2 rounded-lg font-bold text-white bg-[#004DFF] hover:bg-[#FDB314] transition-colors duration-300">Sluiten</button>
    </div>
</div>

<script>
document.getElementById('sollicitatie-form').addEventListener('submit', function(e) {
    e.preventDefault(); // voorkom echte submit voor demo
    const popup = document.getElementById('popup');
    const content = document.getElementById('popupContent');

    // toon overlay
    popup.classList.remove('hidden');
    popup.classList.add('flex');

    // kleine vertraging voor animatie
    setTimeout(() => {
        content.classList.remove('translate-y-10', 'opacity-0');
        content.classList.add('translate-y-0', 'opacity-100');
    }, 50);
});

// Sluit knop
document.getElementById('closePopup').addEventListener('click', function() {
    const popup = document.getElementById('popup');
    const content = document.getElementById('popupContent');

    // terug animatie
    content.classList.add('translate-y-10', 'opacity-0');
    content.classList.remove('translate-y-0', 'opacity-100');

    // na animatie overlay verbergen en pagina refresh
    setTimeout(() => {
        popup.classList.add('hidden');
        popup.classList.remove('flex');
        location.reload(); // refresh de pagina
    }, 500);
});
</script>


<?php get_footer(); ?>
