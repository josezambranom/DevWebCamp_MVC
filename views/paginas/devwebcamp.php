<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $titulo; ?></h2>
    <p class="devwebcamp__descripcion">Conoce la conferencia más importante de latinoamérica</p>

    <div <?php aos_animacion(); ?> class="devwebcamp__grid">
        <div class="devwebcamp__imagen">
            <picture>
                <source src="build/img/sobre_devwebcamp.avif" type="image/avif">
                <source src="build/img/sobre_devwebcamp.webp" type="image/webp">
                <img loading="lazy" width="200" height="300" src="build/img/sobre_devwebcamp.jpg" alt="Imagen DevWebCamp">
            </picture>
        </div>

        <div class="devwebcamp__contenido">
            <p <?php aos_animacion(); ?> class="devwebcamp__texto">
                Ut vitae tristique arcu. In laoreet, justo eu dictum sollicitudin, urna eros vehicula tortor, ut semper justo augue vel felis. Sed consequat lorem a libero euismod, et cursus mi imperdiet. Suspendisse potenti.
            </p>
            <p <?php aos_animacion(); ?> class="devwebcamp__texto">
                Ut vitae tristique arcu. In laoreet, justo eu dictum sollicitudin, urna eros vehicula tortor, ut semper justo augue vel felis. Sed consequat lorem a libero euismod, et cursus mi imperdiet. Suspendisse potenti.
            </p>
        </div>

    </div>
</main>