<?php
/* Template Name: Vacature_overzicht_pagina */
get_header();
?>

<main id="content" class="min-h-screen bg-gray-50">

    <?php
    $hero = get_field('vacature_overzicht_hero');
    if ($hero):
        $hero_img   = $hero['img'];
        $hero_text  = $hero['text'];
        $hero_area  = $hero['text_area'];
    ?>
    <!-- Hero sectie -->
    <section id="vacature_overzicht_hero" class="relative w-full h-[250px] md:h-[350px] lg:h-[400px]">
        <?php if (!empty($hero_img)): ?>
            <img src="<?php echo esc_url($hero_img['url']); ?>" 
                 alt="<?php echo esc_attr($hero_text); ?>" 
                 class="absolute inset-0 w-full h-full object-cover">
        <?php endif; ?>

        <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
            <div class="text-center text-white px-6 max-w-3xl">
                <?php if (!empty($hero_text)): ?>
                    <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-4 drop-shadow-lg">
                        <?php echo esc_html($hero_text); ?>
                    </h1>
                <?php endif; ?>
                <?php if (!empty($hero_area)): ?>
                    <p class="text-lg md:text-xl lg:text-2xl font-light leading-relaxed opacity-90">
                        <?php echo esc_html($hero_area); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <div class="container mx-auto px-4 py-12">
        <?php
        // Vacatures ophalen
        $vacatures = new WP_Query([
            'post_type'      => 'vacature',
            'posts_per_page' => -1
        ]);

        $all_vacatures = [];
        if ($vacatures->have_posts()) :
            while ($vacatures->have_posts()) : $vacatures->the_post();
                $id = get_the_ID();
                $all_vacatures[] = [
                    'id'           => $id,
                    'titel'        => get_field('text', $id) ?: get_the_title(),
                    'omschrijving' => get_field('text_area', $id),
                    'img'          => get_field('img', $id)
                ];
            endwhile;
        endif;
        wp_reset_postdata();

        $total_vacatures = count($all_vacatures);
        ?>

        <?php if ($total_vacatures === 0): ?>
            <!-- Geen vacatures melding -->
            <section aria-labelledby="geen-vacatures-titel" class="flex items-center justify-center">
                <div class="w-full max-w-3xl bg-white rounded-2xl shadow-md p-8 md:p-12 text-center">
                    <!-- Icon -->
                    <div class="mx-auto mb-6 w-16 h-16 rounded-full bg-[#101E31]/10 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2Zm1 15h-2v-2h2Zm0-4h-2V7h2Z"/>
                        </svg>
                    </div>
                    <h2 id="geen-vacatures-titel" class="text-2xl md:text-3xl font-bold text-[#101E31] mb-3">
                        Momenteel zijn er geen vacatures
                    </h2>
                    <p class="text-gray-600 max-w-2xl mx-auto mb-8 leading-relaxed">
                        Op dit moment hebben we geen openstaande vacatures. Bezoek later nog eens
                        of ga terug naar de homepagina voor meer informatie over onze diensten.
                    </p>
                    <div class="flex justify-center">
                        <a href="<?php echo esc_url('http://test.coldchainlogisticservices.nl/'); ?>"
                           class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#101E31] text-white font-medium shadow transition-transform duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-[#101E31]/30">
                            <span>Terug naar home</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </section>
        <?php else: ?>
            <?php
            // Alleen slider + paginatie renderen als er wél vacatures zijn
            $cards_per_page = 9;
            $total_pages = (int) ceil($total_vacatures / $cards_per_page);
            ?>
            <!-- Vacature slider -->
            <div id="vacature-slider" class="relative">
                <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                    <div class="vacature-page <?php echo $page === 1 ? 'opacity-100 relative' : 'opacity-0 pointer-events-none absolute inset-0'; ?> transition-opacity duration-500" data-page="<?php echo $page; ?>">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php
                            $start = ($page - 1) * $cards_per_page;
                            $subset = array_slice($all_vacatures, $start, $cards_per_page);
                            foreach ($subset as $vacature):
                            ?>
                                <div class="bg-white rounded-2xl shadow-md overflow-hidden flex flex-col h-full transform transition duration-500 hover:scale-105 hover:shadow-xl">
                                    <?php if (!empty($vacature['img'])): ?>
                                        <img src="<?php echo esc_url($vacature['img']['url']); ?>" alt="" class="w-full h-48 object-cover">
                                    <?php endif; ?>
                                    <h3 class="text-xl font-semibold px-6 py-3 bg-[#101E31] text-white">
                                        <?php echo esc_html($vacature['titel']); ?>
                                    </h3>
                                    <div class="p-4 flex flex-col flex-1">
                                        <?php if (!empty($vacature['omschrijving'])):
                                            $plain = wp_strip_all_tags($vacature['omschrijving']);
                                            $display = mb_strlen($plain) > 200 ? mb_substr($plain, 0, 200) . '…' : $plain;
                                        ?>
                                            <p class="text-gray-700 mb-4 flex-1">
                                                <?php echo esc_html($display); ?>
                                            </p>
                                        <?php endif; ?>
                                        <div class="mt-auto flex justify-end">
                                            <a href="<?php echo esc_url(site_url('/vacatures-pagina?id=' . $vacature['id'])); ?>"
                                               class="w-14 h-14 bg-[#101E31] rounded-full flex items-center justify-center shadow transition-transform duration-300 hover:scale-110 hover:shadow-lg hover:-translate-y-1"
                                               aria-label="Bekijk vacature">
                                                <i class="fa-solid fa-circle-arrow-right text-white text-2xl"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endfor; ?>

                <!-- Paginatie -->
                <div class="pt-12">
                    <div id="pagination" class="flex justify-center flex-wrap gap-2"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php if ($total_vacatures > 0): ?>
<script>
const slider = document.getElementById('vacature-slider');
const paginationContainer = document.getElementById('pagination');
let currentPage = 1;
const totalPages = <?php echo (int) ($total_vacatures > 0 ? ceil($total_vacatures / 9) : 0); ?>;

function goToPage(page) {
    currentPage = page;
    document.querySelectorAll('.vacature-page').forEach(p => {
        if (p.dataset.page == page) {
            p.classList.remove('opacity-0', 'pointer-events-none', 'absolute');
            p.classList.add('opacity-100', 'relative');
        } else {
            p.classList.remove('opacity-100', 'relative');
            p.classList.add('opacity-0', 'pointer-events-none', 'absolute');
        }
    });
    slider.scrollIntoView({ behavior: 'smooth', block: 'start' });
    renderPagination();
}

function renderPagination() {
    paginationContainer.innerHTML = '';
    let visiblePages = [];
    if (totalPages <= 4) {
        for (let i = 1; i <= totalPages; i++) visiblePages.push(i);
    } else {
        if (currentPage <= 3) {
            visiblePages = [1, 2, 3, 4];
        } else if (currentPage >= totalPages) {
            visiblePages = [1, totalPages - 2, totalPages - 1, totalPages];
        } else {
            visiblePages = [1, currentPage - 1, currentPage, currentPage + 1];
        }
    }

    visiblePages.forEach(p => {
        const btn = document.createElement('button');
        btn.className = 'w-10 h-10 flex items-center justify-center rounded-full bg-[#101E31] text-white transition-transform duration-300 hover:scale-110 focus:outline-none focus:ring-4 focus:ring-[#101E31]/30';
        btn.innerText = p;
        btn.dataset.page = p;
        if (p == currentPage) btn.classList.add('scale-110');
        btn.addEventListener('click', () => goToPage(p));
        paginationContainer.appendChild(btn);
    });
}

// Initial render
renderPagination();
</script>
<?php endif; ?>

<?php get_footer(); ?>
