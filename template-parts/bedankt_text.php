<?php 
$bedankt_text = get_field('bedankt_text');

if ( $bedankt_text && is_array($bedankt_text) ) :        
    $text       = $bedankt_text['text'] ?? '';       
    $text_area  = $bedankt_text['text_area'] ?? ''; 
    $button     = $bedankt_text['button'] ?? ''; 
    $questions  = $bedankt_text['questions'] ?? [];
?>
<section class="w-full py-12 bg-white">
    <div class="container mx-auto px-4 md:px-6 lg:px-8 flex flex-col lg:flex-row gap-12">

        <!-- LINKERKANT -->
        <div class="lg:w-1/2 flex flex-col justify-center">
            <div class="max-w-lg">
                <?php if ($text) : ?>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        <?php echo esc_html($text); ?>
                    </h2>
                    <div class="w-12 h-1 bg-blue-700 mb-6"></div>
                <?php endif; ?>

                <?php if ($text_area) : ?>
                    <p class="text-base sm:text-lg text-gray-700 mb-4">
                        <?php echo esc_html($text_area); ?>
                    </p>
                <?php endif; ?>

                <?php if ($button) : ?>
                     <a href="<?php echo esc_url($button['url'] ?? '#'); ?>" 
                         class="inline-block text-white px-6 py-3 rounded w-max transition-colors duration-300"
                         style="background-color: #024D92;"
                         onmouseover="this.style.backgroundColor='#023b70';"
                         onmouseout="this.style.backgroundColor='#024D92';">
                     <?php echo esc_html($button['title'] ?? 'Contact opnemen'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- RECHTERKANT: Premium Accordion -->
        <div class="lg:w-1/2 flex flex-col gap-4">
            <?php if ($questions) : ?>
                <?php foreach ($questions as $index => $q) : 
                    $q_text = $q['text'] ?? '';
                    $q_text_area = $q['text_area'] ?? '';
                ?>
                    <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden transition-shadow duration-300 hover:shadow-xl">
                        <!-- Header -->
                        <button type="button"
                                class="w-full flex justify-between items-center p-4 cursor-pointer hover:bg-gray-50 focus:outline-none question-toggle"
                                data-index="<?php echo $index; ?>">
                            <h3 class="font-semibold text-gray-900 text-lg"><?php echo esc_html($q_text); ?></h3>
                            <i class="fa-solid fa-plus text-gray-500 transition-transform duration-500 ease-in-out transform toggle-icon"></i>
                        </button>

                        <!-- Content -->
                        <?php if ($q_text_area) : ?>
                            <div class="max-h-0 opacity-0 overflow-hidden text-area-<?php echo $index; ?> px-4">
                                <p class="text-gray-700 text-sm mt-2 transition-opacity duration-500 ease-in-out opacity-0"><?php echo esc_html($q_text_area); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.question-toggle');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const index = toggle.dataset.index;
            const textArea = document.querySelector('.text-area-' + index);
            const icon = toggle.querySelector('.toggle-icon');
            const p = textArea.querySelector('p');

            if (textArea.classList.contains('open')) {
                // Close
                textArea.style.maxHeight = textArea.scrollHeight + "px"; 
                requestAnimationFrame(() => {
                    textArea.style.maxHeight = "0px";
                });
                textArea.classList.remove('open');
                textArea.classList.remove('opacity-100','pb-4');
                textArea.classList.add('opacity-0');
                p.classList.add('opacity-0');
                p.classList.remove('opacity-100');
                icon.classList.remove('fa-minus');
                icon.classList.add('fa-plus');
                icon.style.transform = "rotate(0deg)";
            } else {
                // Open
                textArea.classList.add('open');
                textArea.classList.remove('opacity-0');
                textArea.classList.add('opacity-100','pb-4');
                p.classList.remove('opacity-0');
                p.classList.add('opacity-100');
                textArea.style.maxHeight = textArea.scrollHeight + "px";
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
                icon.style.transform = "rotate(180deg)";
            }

            icon.style.transition = "transform 0.35s ease";
            textArea.style.transition = "max-height 0.35s ease, opacity 0.35s ease";
        });
    });
});
</script>
<?php endif; ?>
