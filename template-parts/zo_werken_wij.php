<?php
$zo_werken_wij = get_field('zo_werken_wij'); // Haal de hele group op
if( $zo_werken_wij ):
    $title = $zo_werken_wij['title'];
    $repeater = $zo_werken_wij['repeater'];
?>

<section class="bg-gradient-to-b from-[#243866] to-[#0A131F] py-20 px-6">
    <div class="max-w-7xl mx-auto">
        <?php if ($title): ?>
            <h2 class="text-4xl md:text-5xl font-bold text-white text-center mb-16">
                <?php echo esc_html($title); ?>
            </h2>
        <?php endif; ?>

        <?php if ($repeater): ?>
            <div class="max-w-4xl mx-auto">
                <?php 
                $count = 0;
                $total = count($repeater);
                foreach ($repeater as $item): 
                    $count++;
                    $text = $item['text'] ?? '';
                    $text_area = $item['text_area'] ?? '';
                    $icon = $item['icon'] ?? '';
                    $is_even = $count % 2 == 0;
                ?>
                    <div class="flex gap-8 items-start <?php echo $count !== $total ? 'mb-12' : ''; ?> group">
                        <!-- Left: Number circle with gradient and line -->
                        <div class="flex flex-col items-center flex-shrink-0 relative">
                            <!-- Glowing circle with number -->
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                                <div class="relative w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 flex items-center justify-center shadow-2xl border-4 border-white/20 group-hover:scale-110 group-hover:border-white/40 transition-all duration-300">
                                    <span class="text-3xl font-black text-white drop-shadow-lg"><?php echo $count; ?></span>
                                </div>
                            </div>
                            
                            <!-- Connecting line with gradient -->
                            <?php if ($count !== $total): ?>
                                <div class="w-0.5 h-28 bg-gradient-to-b from-blue-500 via-blue-400 to-blue-300 mt-4 opacity-40"></div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Right: Enhanced content card -->
                        <div class="flex-1 relative">
                            <!-- Subtle glow effect behind card -->
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-500/20 to-indigo-500/20 rounded-3xl blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <!-- Main card -->
                            <div class="relative bg-gradient-to-br from-white/8 to-white/4 backdrop-blur-md border border-white/10 rounded-2xl p-8 shadow-xl hover:shadow-2xl hover:border-blue-400/30 transition-all duration-500 overflow-hidden">
                                <!-- Decorative top accent -->
                                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-blue-400 to-transparent opacity-50"></div>
                                
                                <!-- Number badge in corner -->
                                <div class="absolute top-4 right-4 w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-300 text-xs font-bold border border-blue-400/30">
                                    <?php echo str_pad($count, 2, '0', STR_PAD_LEFT); ?>
                                </div>
                                
                                <?php if ($text): ?>
                                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-4 pr-12 leading-tight">
                                        <?php echo esc_html($text); ?>
                                    </h3>
                                <?php endif; ?>
                                
                                <?php if ($text_area): ?>
                                    <p class="text-gray-300 leading-relaxed text-base">
                                        <?php echo esc_html($text_area); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <!-- Decorative bottom corner element -->
                                <div class="absolute bottom-0 right-0 w-24 h-24 bg-gradient-to-tl from-blue-500/10 to-transparent rounded-tl-full"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php endif; ?>