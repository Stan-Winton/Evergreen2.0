/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
const $ = require('jquery');    
require('bootstrap');

// start the Stimulus application
import './bootstrap';

// Cuando se hace clic en el botón "Añadir al carrito"
document.querySelectorAll('.add-to-cart').forEach(function(button) {
    button.addEventListener('click', function() {
        // Encuentra el elemento de stock para este producto
        var productId = button.getAttribute('data-id');
        var stockElement = document.getElementById('stock-' + productId);
        var currentStock = parseInt(stockElement.textContent.replace('Stock: ', ''), 10);

        // Solo realiza la solicitud AJAX si hay stock disponible
        if (currentStock > 0) {
            // Aquí es donde haces la solicitud AJAX para disminuir el stock en el servidor
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/compra_online/' + productId + '/disminuir-stock', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Obtiene la nueva cantidad de stock de la respuesta del servidor
                    var newStock = parseInt(xhr.responseText, 10);

                    // Actualiza el DOM en la próxima iteración del bucle de eventos
                    setTimeout(function() {
                        stockElement.textContent = 'Stock: ' + newStock;

                        // Si el nuevo stock es 0, oculta el elemento del producto
                        if (newStock == 0) {
                            var productElement = document.getElementById('product-' + productId);
                            productElement.style.display = 'none';
                        }
                    }, 0);
                } else {
                    console.error('Error en la solicitud AJAX: ' + xhr.status);
                }
            };
            xhr.onerror = function() {
                console.error('Error en la solicitud AJAX');
            };
            xhr.send();
        }
    });
});

// Cuando se hace clic en el botón "Comprar" o "Checkout"
document.getElementById('checkout-button').addEventListener('click', function() {
    // Aquí haces una solicitud al servidor para completar la compra
    // y disminuir el stock en la base de datos
});
