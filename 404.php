<?php
/* 404 Template */
get_header();
?>

<main class="bg-white py-24 lg:py-40">
  <div class="container mx-auto px-4">

    <!-- Hele grote titel -->
    <h1 class="text-[120px] md:text-[180px] font-extrabold leading-none mb-10" style="color:#243866;">
        404
    </h1>

    <!-- Subtitel -->
    <h2 class="text-6xl md:text-8xl font-bold mb-10 text-gray-900">
        Pagina niet gevonden
    </h2>

    <!-- Tekstvlak -->
    <div class="max-w-5xl text-3xl md:text-4xl text-gray-700 mb-12">
        De pagina die je zoekt bestaat niet of is verwijderd. Controleer de URL of ga terug naar de homepage.
    </div>

    <!-- Call-to-action knop naar jouw homepage -->
    <div>
        <a href="http://coldchaintest.test/" class="inline-block px-8 py-4 bg-[#243866] text-white font-semibold rounded-lg shadow hover:bg-[#1f2a56] transition-colors duration-300">
            Terug naar homepage
        </a>
    </div>

  </div>
</main>

<?php
get_footer();
?>
