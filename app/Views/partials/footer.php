<?php
// Salve este novo conteúdo em: app/Views/partials/footer.php
?>
        </main> <footer>
            
            <div class="newsletter-form">
                <h3>Assine nossa newsletter</h3>
                <form action="#" method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                </form>
            </div>

            <div class="footer-socials">
                <a href="#"><img src="<?php echo base_path('images/whats.jpg'); ?>" alt="WhatsApp"></a>
                <a href="#"><img src="<?php echo base_path('images/email.jpg'); ?>" alt="Gmail"></a>
                <a href="https://www.instagram.com/foit.co" target="_blank" rel="noopener noreferrer"><img src="<?php echo base_path('images/insta.png'); ?>" alt="Instagram"></a>
            </div>

            <div class="footer-logo">
                 <img src="<?php echo base_path('images/foit.png'); ?>" alt="Foit Logo">
            </div>

            <div class="copyright">
                <p>Copyright Foit - seuemail@gmail.com - 2025. Todos os direitos reservados.</p>
                <p style="color: #555;">criado com Nuvemshop</p> </div>

        </footer>

    </div> 
    
    <script>
        // Script para a barra de pesquisa
        document.addEventListener('DOMContentLoaded', function () {
            const searchIcon = document.getElementById('search-icon');
            const searchOverlay = document.getElementById('search-overlay');
            const closeSearchBtn = document.getElementById('close-search');

            searchIcon.addEventListener('click', function (e) {
                e.preventDefault(); // Impede que o link '#' mude a URL
                searchOverlay.classList.add('visible');
            });

            closeSearchBtn.addEventListener('click', function () {
                searchOverlay.classList.remove('visible');
            });

            // Script para o submenu de marcas
            const brandsToggle = document.getElementById('brands-toggle');
            const brandsSubmenu = document.getElementById('brands-submenu');

            if (brandsToggle && brandsSubmenu) {
                brandsToggle.addEventListener('click', function(e) {
                    e.preventDefault(); // Impede a navegação do link
                    brandsSubmenu.classList.toggle('visible');
                });
            }
        });
    </script>
</body>
</html>