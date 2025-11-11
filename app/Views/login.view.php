<?php
// app/Views/login.view.php (REESCRITO)
// Note que NÃO HÁ MAIS header.php ou footer.php aqui
?>

<div class="form-container">
    <h2>login</h2>

    <?php if ($error = session()->getFlash('error')): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if ($success = session()->getFlash('success')): ?>
        <p class="success-message"><?php echo $success; ?></p>
    <?php endif; ?>

    <form action="<?php echo base_path('/login'); ?>" method="POST">
        <div class="form-group"><label for="email">email</label><input type="email" name="email" id="email" required></div>
        <div class="form-group"><label for="password">senha</label><input type="password" name="password" id="password" required></div>
        <button type="submit" class="form-button">entrar</button>
    </form>
    <a href="<?php echo base_path('/register'); ?>" class="form-link">não tem uma conta? cadastre-se</a>
</div>