// Importaciones y configuración inicial
import './styles/app.scss';
const $ = require('jquery');    
require('bootstrap');
import './bootstrap';


// Cuando el carrito se vacía, actualiza el contador
$('#vaciar_carrito').on('click', function() {
    // Establece el contador en el almacenamiento local a 0
    localStorage.setItem('cart-count', 0);

    // Obtiene el valor del contador del almacenamiento local
    var count = localStorage.getItem('cart-count');

    // Actualiza el texto del contador en la página
    $('#cart-count').text(count);
});