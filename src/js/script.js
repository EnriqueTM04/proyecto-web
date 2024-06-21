document.addEventListener('DOMContentLoaded', function() {
    eventListeners();

    // darkMode();
});

function eventListeners() {
    // FORMULARIO REGISTRO
    validacionRegistro();
}

// FORMULARIO REGISTRO
function validacionRegistro() {
    const form = document.getElementById('formulario_registro');
    const txtUsuario = document.getElementById('usuario');
    const txtEmail = document.getElementById('email');
    const txtNombres = document.getElementById('nombres');
    const txtApellidos = document.getElementById('apellidos');
    const txtDireccion = document.getElementById('direccion');
    const txtTelefono = document.getElementById('tel');

    txtNombres.focus();

    txtUsuario.addEventListener("blur", () => {
        if(txtUsuario.value.trim().length < 1) {
            txtUsuario.setCustomValidity('El username es obligatorio');
        }
        else {
            txtUsuario.setCustomValidity('');
        }
        existeUsuario(txtUsuario.value);
        txtUsuario.reportValidity();
    }, false);
    txtEmail.addEventListener("blur", () => {
        const email = txtEmail.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            emailError.style.display = 'inline';
            emailInput.setCustomValidity('Por favor, ingrese un correo electrónico válido.');
        } else {
            emailError.style.display = 'none';
            emailInput.setCustomValidity('');
        }
        existeEmail(txtEmail.value);
        txtEmail.reportValidity();
    }, false);
    txtNombres.addEventListener("blur", () => {
        if(txtNombres.value.trim().length < 1) {
            txtNombres.setCustomValidity('El nombre es requerido.');
        }
        else {
            txtNombres.setCustomValidity('');
        }
        txtNombres.reportValidity();
    }, false);
    txtApellidos.addEventListener("blur", () => {
        if(txtApellidos.value.trim().length < 1) {
            txtApellidos.setCustomValidity('Los apellidos son obligatorios');
        }
        else {
            txtApellidos.setCustomValidity('');
        }
        txtApellidos.reportValidity();
    }, false);
    txtDireccion.addEventListener("blur", () => {
        if(txtDireccion.value.trim().length < 1) {
            txtDireccion.setCustomValidity('La direccion es requerida.');
        }
        else {
            txtDireccion.setCustomValidity('');
        }
        txtDireccion.reportValidity();
    }, false);
    txtTelefono.addEventListener("blur", () => {
        const numero = txtTelefono.value;
        const telRegex = /^\d{10}$/;
        if (!telRegex.test(numero)) {
            telError.style.display = 'inline';
            telInput.setCustomValidity('Telefono de 10 digitos.');
        } else {
            telError.style.display = 'none';
            telInput.setCustomValidity('');
        }
        txtTelefono.reportValidity();
    }, false);

    form.addEventListener('submit', (event) => {
        if (!form.checkValidity()) {
            event.preventDefault();
        }
    })
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
                setTimeout(function() {
                    document.getElementById('validaUsuario').innerHTML = '';
                }, 1500); // 2000 milisegundos = 2 segundos
            } else {
                document.getElementById('validaUsuario').innerHTML = '';
            }
        })
}

// VERIFICAR SI EXISTE CORREO
function existeEmail(email) {
    const url = "../../classes/clienteAx.php";
    const formData = new FormData();
    formData.append("accion", "existeEmail");
    formData.append("email", email);

    fetch(url, {
        method: 'POST',
        body: formData      
    })
        .then(response => response.json())
        .then(data => {
            if(data.ok) {
                document.getElementById('email').value = '';
                document.getElementById('validaEmail').innerHTML = 'Correo ya registrado';
                setTimeout(function() {
                    document.getElementById('validaEmail').innerHTML = '';
                }, 1500); // 2000 milisegundos = 2 segundos
            } else {
                document.getElementById('validaEmail').innerHTML = '';
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

