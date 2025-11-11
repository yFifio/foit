<div class="form-container">
    <h2>criar conta</h2>
    
    <?php if ($error = session()->getFlash('error')): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="<?php echo base_path('/register'); ?>" method="POST">
        <div class="form-group"><label for="name">nome completo</label><input type="text" name="name" id="name" required></div>
        <div class="form-group"><label for="email">email</label><input type="email" name="email" id="email" required></div>
        <div class="form-group"><label for="password">senha</label><input type="password" name="password" id="password" required></div>
        <button type="submit" class="form-button">cadastrar</button>
    </form>
    <a href="<?php echo base_path('/login'); ?>" class="form-link">já tem uma conta? faça o login</a>
</div>