<style>
    .checkout-page { max-width: 800px; margin: 0 auto; }
    .checkout-page h2 { text-align: left; margin-bottom: 2rem; }
    .checkout-section { border: 1px solid #333; padding: 20px; margin-bottom: 2rem; }
    .checkout-section h3 { margin-top: 0; border-bottom: 1px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
    .cart-summary ul { list-style: none; padding: 0; }
    .cart-summary li { display: flex; justify-content: space-between; margin-bottom: 10px; }
    .cart-total { text-align: right; font-size: 1.2rem; font-weight: bold; margin-top: 1rem; }
    .payment-options label { display: block; margin-bottom: 10px; }
</style>

<div class="checkout-page">
    <h2>finalizar compra</h2>

    <form action="<?php echo BASE_PATH; ?>/process_order" method="POST">

        <!-- Seção de Resumo do Carrinho -->
        <div class="checkout-section cart-summary">
            <h3>resumo do pedido</h3>
            <ul>
                <?php foreach ($cart->getItems() as $item): ?>
                    <li>
                        <span><?php echo htmlspecialchars($item['product']->getName()); ?> (x<?php echo $item['quantity']; ?>)</span>
                        <span><?php echo $item['product']->getFormattedPrice(); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="cart-total">Total: <?php echo $cart->getFormattedTotal(); ?></div>
        </div>

        <!-- Seção de Endereço -->
        <div class="checkout-section">
            <h3>endereço de entrega</h3>
            <div class="form-group">
                <label for="address">endereço completo</label>
                <input type="text" name="address" id="address" required>
            </div>
            <div class="form-group">
                <label for="city">cidade</label>
                <input type="text" name="city" id="city" required>
            </div>
            <div class="form-group">
                <label for="zipcode">cep</label>
                <input type="text" name="zipcode" id="zipcode" required>
            </div>
        </div>

        <!-- Seção de Pagamento -->
        <div class="checkout-section">
            <h3>forma de pagamento</h3>
            <div class="payment-options">
                <label>
                    <input type="radio" name="payment_method" value="pix" checked required> pix
                </label>
                <label>
                    <input type="radio" name="payment_method" value="boleto" required> boleto
                </label>
                <label>
                    <input type="radio" name="payment_method" value="credit_card" required> cartão de crédito
                </label>
            </div>

            <!-- Detalhes do Cartão de Crédito (escondido por padrão) -->
            <div id="credit-card-details" style="display: none; margin-top: 20px; border-top: 1px solid #333; padding-top: 20px;">
                <div class="form-group">
                    <label for="card_number">número do cartão</label>
                    <input type="text" name="card_number" id="card_number" placeholder="0000 0000 0000 0000">
                </div>
                <div class="form-group">
                    <label for="card_name">nome no cartão</label>
                    <input type="text" name="card_name" id="card_name">
                </div>
                <div class="form-group" style="display: flex; gap: 20px;">
                    <div style="flex: 1;">
                        <label for="card_expiry">validade</label>
                        <input type="text" name="card_expiry" id="card_expiry" placeholder="MM/AA">
                    </div>
                    <div style="flex: 1;">
                        <label for="card_cvv">cvv</label>
                        <input type="text" name="card_cvv" id="card_cvv" placeholder="123">
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align: right;">
            <button type="submit" class="form-button">confirmar e pagar</button>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const creditCardDetails = document.getElementById('credit-card-details');

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            creditCardDetails.style.display = this.value === 'credit_card' ? 'block' : 'none';
        });
    });
});
</script>