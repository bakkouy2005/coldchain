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
        $vacatures = new WP_Query([
            'post_type' => 'vacature',
            'posts_per_page' => -1
        ]);

        $all_vacatures = [];
        if ($vacatures->have_posts()) :
            while ($vacatures->have_posts()) : $vacatures->the_post();
                $id = get_the_ID();
                $all_vacatures[] = [
                    'id' => $id,
                    'titel' => get_field('text', $id) ?: get_the_title(),
                    'omschrijving' => get_field('text_area', $id),
                    'img' => get_field('img', $id)
                ];
            endwhile;
        endif;
        wp_reset_postdata();

        $total_vacatures = count($all_vacatures);
        $cards_per_page = 9;
        $total_pages = ceil($total_vacatures / $cards_per_page);
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
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden flex flex-col h-full transform transition duration-500 hover:scale-105 hover:shadow-xl hover:animate-card-pulse">
                                <?php if ($vacature['img']): ?>
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
                                        <a href="<?php echo site_url('/vacatures-pagina?id=' . $vacature['id']); ?>"
                                           class="w-14 h-14 bg-[#101E31] rounded-full flex items-center justify-center shadow transition-transform duration-300 hover:scale-110 hover:shadow-lg hover:-translate-y-1">
                                            <i class="fa-solid fa-circle-arrow-right text-white text-2xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endfor; ?>

            <!-- Paginatie met extra ruimte -->
            <div class="pt-12">
                <div id="pagination" class="flex justify-center space-x-2"></div>
            </div>
        </div>
    </div>
</main>



<script>
const slider = document.getElementById('vacature-slider');
const paginationContainer = document.getElementById('pagination');
let currentPage = 1;
const totalPages = <?php echo $total_pages; ?>;

function goToPage(page) {
    currentPage = page;
    document.querySelectorAll('.vacature-page').forEach(p => {
        if(p.dataset.page == page) {
            p.classList.remove('opacity-0', 'pointer-events-none', 'absolute');
            p.classList.add('opacity-100', 'relative');
        } else {
            p.classList.remove('opacity-100', 'relative');
            p.classList.add('opacity-0', 'pointer-events-none', 'absolute');
        }
    });
    slider.scrollIntoView({ behavior: 'smooth' });
    renderPagination();
}

function renderPagination() {
    paginationContainer.innerHTML = '';
    let visiblePages = [];
    if(totalPages <= 4){
        for(let i=1;i<=totalPages;i++) visiblePages.push(i);
    } else {
        if(currentPage <= 3){
            visiblePages = [1,2,3,4];
        } else if(currentPage >= totalPages){
            visiblePages = [1,totalPages-2,totalPages-1,totalPages];
        } else {
            visiblePages = [1,currentPage-1,currentPage,currentPage+1];
        }
    }

    visiblePages.forEach(p=>{
        const btn = document.createElement('button');
        btn.className = `w-10 h-10 flex items-center justify-center rounded-full bg-[#101E31] text-white transition-transform duration-300 hover:scale-110`;
        btn.innerText = p;
        btn.dataset.page = p;
        if(p==currentPage) btn.classList.add('scale-110');
        btn.addEventListener('click',()=>goToPage(p));
        paginationContainer.appendChild(btn);
    });
}

// Initial render
renderPagination();
</script>

<?php get_footer(); ?>
