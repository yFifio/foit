<div class="contact-page">
    
    <?php if ($success = session()->getFlash('success')): ?>
        <p class="success-message"><?php echo htmlspecialchars($success); ?></p>
    <?php elseif ($error = session()->getFlash('error')): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <div class="contact-header">
        <h2>entre em contato</h2>
        <p>Tem alguma dúvida, sugestão ou proposta? Adoraríamos ouvir você. Preencha o formulário ou nos envie um email.</p>
    </div>

    <div class="contact-layout">
        <!-- Coluna da Esquerda: Informações -->
        <div class="contact-info">
            <h3>informações de contato</h3>
            <p><strong>Email:</strong><br> seuemail@foit.com</p>
            <p><strong>Horário de Atendimento:</strong><br> Seg. a Sex. das 9h às 18h</p>
        </div>

        <!-- Coluna da Direita: Formulário -->
        <div class="contact-form-wrapper">
            <form action="<?php echo base_path('/contact'); ?>" method="POST">
                <div class="form-group">
                    <label for="name">nome</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div class="form-group">
                    <label for="email">email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="message">mensagem</label>
                    <textarea name="message" id="message" rows="6" required></textarea>
                </div>
                <button type="submit" class="form-button">enviar mensagem</button>
            </form>
        </div>
    </div>
</div>