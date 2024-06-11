document.addEventListener('DOMContentLoaded', function() {
    eventListeners();

    // darkMode();
});

function eventListeners() {
    // FORMULARIO REGISTRO
    const txtUsuario = document.getElementById('usuario');
    txtUsuario.addEventListener("blur", () => {
        existeUsuario(txtUsuario.value);
    }, false)
}

//VERIFICAR SI EXISTE YA EL USUARIO
function existeUsuario(usuario) {
    const url = "../../classes/clienteAx.php";
    const formData = new FormData();
    formData.append("accion", "existeUsuario");
    formData.append("usuario", usuario);

    fetch(url, {
        method: 'POST',
        body: formData      
    })
        .then(response => response.json())
        .then(data => {
            if(data.ok) {
                document.getElementById('usuario').value = '';
                document.getElementById('validaUsuario').innerHTML = 'Usuario ya existente';
            } else {
                document.getElementById('validaUsuario').innerHTML = '';
            }
        })
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
        });
}

// ACTUALIZAR NUMERO DE PRODUCTOS EN CARRITO
function actualizarCantidad(cantidad, id) {
    const url = 'classes/actualizar_carrito.php';
    const formData = new FormData();
    formData.append('accion', 'agregar');
    formData.append('id', id);
    formData.append('cantidad', cantidad);

    fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
    })
        .then(response=> response.json())
        .then(data => {
            if(data.ok) {
                const divsubtotal =  document.getElementById('subtotal_' + id);
                divsubtotal.innerHTML = data.sub;

                let total = 0.00;
                const list = document.getElementsByName('subtotal[]')

                for (let i = 0; i < list.length; i++) {
                    total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''));
                }

                total = new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2
                }).format(total);
                document.getElementById('total').innerHTML = '$' + total;
            }
        })
}

// ELIMINAR PRODUCTOS DEL CARRITO DE COMPRAS
function eliminarProducto(id) {
    const url = 'classes/actualizar_carrito.php';
    const formData = new FormData();
    formData.append('accion', 'quitar');
    formData.append('id', id);

    fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
    })
        .then(response=> response.json())
        .then(data => {
            if(data.ok) {
                location.reload();
            }
        })
}

