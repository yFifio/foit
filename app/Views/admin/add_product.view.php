<style>
    .form-container { max-width: 600px; }
    /* ... (outros estilos) ... */
</style>

<div class="form-container">
    <h2>adicionar novo produto</h2>

    <?php if ($success = session()->getFlash('success')): ?>
        <p class="success-message"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
    <?php if ($error = session()->getFlash('error')): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="<?php echo base_path('/admin/products/add'); ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group"><label for="name">Nome do Produto</label><input type="text" name="name" id="name" required></div>
        <div class="form-group"><label for="price">Preço (ex: 99,90)</label><input type="text" name="price" id="price" required></div>
        <div class="form-group"><label for="description">Descrição</label><textarea name="description" id="description" rows="4" required></textarea></div>
        <div class="form-group"><label for="stock">Estoque</label><input type="number" name="stock" id="stock" required></div>
        <div class="form-group">
            <label for="category">Categoria</label>
            <select name="category" id="category" required>
                <option value="">Selecione...</option>
                <option value="novo">Novo</option>
                <option value="usado">Usado</option>
                <option value="tenis">Tênis</option>
                <option value="camisetas">Camisetas</option>
                <option value="moletom">Moletom</option>
                <option value="jaquetas">Jaquetas</option>
                <option value="calcas">Calças</option>
                <option value="shorts">Shorts</option>
                <option value="bones">Bonés</option>
                <option value="oculos">Óculos</option>
            </select>
        </div>
        <div class="form-group"><label for="size">Tamanho (ex: P, M, G)</label><input type="text" name="size" id="size" required></div>
        <div class="form-group"><label for="color">Cor</label><input type="text" name="color" id="color" required></div>
        <div class="form-group"><label for="image">Imagem do Produto</label><input type="file" name="image" id="image" accept="image/*" required></div>
        <button type="submit" class="form-button">salvar produto</button>
    </form>
</div>