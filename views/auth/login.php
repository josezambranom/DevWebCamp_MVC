<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Inicia sesión en DevWebCamp</p>


    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <form class="formulario" method="POST" action="/login">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email:</label>
            <input type="email" name="email" id="email" class="formulario__input" placeholder="Tu Email">
        </div>

        <div class="formulario__campo">
            <label for="password" class="formulario__label">Password:</label>
            <input type="password" name="password" id="password" class="formulario__input" placeholder="Tu password">
        </div>

        <input type="submit" class="formulario__submit" value="Iniciar Sesión">
    </form>

    <div class="acciones">
        <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Obtener una</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu Password?</a>
    </div>

</main>