<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Recupera tu acceso a DevWebCamp</p>

    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <form class="formulario" method="POST" action="/olvide">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email:</label>
            <input type="email" name="email" id="email" class="formulario__input" placeholder="Tu Email">
        </div>

        <input type="submit" class="formulario__submit" value="Enviar Instrucciones">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar Sesión</a>
        <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Obtener una</a>
    </div>

</main>