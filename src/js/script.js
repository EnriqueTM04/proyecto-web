document.addEventListener('DOMContentLoaded', function() {
    eventListeners();

    darkMode();
});

function eventListeners() {

}

// AGREGAR AL CARRITO
function addProducto(id, token) {
    const url = 'classes/carrito.php';
    const formData = new FormData();
    formData.append('id', id);
    formData.append('token', token);

    fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
    })
        .then(response=> response.json())
        .then(data => {
            if(data.ok) {
                const elemento = document.getElementById("num_cart");
                elemento.innerHTML = data.numero;
            }
        })
}