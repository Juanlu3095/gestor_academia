
function crearAlumno() {
    let nombre = document.querySelector('#alumnonuevo-form input[name=nombre]').value
    let apellidos = document.querySelector('#alumnonuevo-form input[name=apellidos]').value
    let email = document.querySelector('#alumnonuevo-form input[name=email]').value
    let dni = document.querySelector('#alumnonuevo-form input[name=dni]').value

    $.ajax({
        type: 'POST',
        url: '/gestor_academia_mvc/alumnos',
        data: JSON.stringify({
            nombre: nombre,
            apellidos: apellidos,
            email: email,
            dni: dni
        }),

        success: function (response) {
            console.log(response)

            $('.new-invalid').empty()

            alert(JSON.parse(response).mensaje)
            $( "#tabla" ).load( "/gestor_academia_mvc/alumnos #tabla" )
            $('#nuevoModal').modal('hide')
        },
        error: function (error) {
            // PROBAR ERRORES CON REGISTROS DE LA BD YA EXISTENTES
            console.error('Este es el error: ', JSON.parse(error.responseText))

            $('.new-invalid').empty()

            $('.invalid-feedback-nombre').append(JSON.parse(error.responseText).errores.nombre)
            $('.invalid-feedback-apellidos').append(JSON.parse(error.responseText).errores.apellidos)
            $('.invalid-feedback-email').append(JSON.parse(error.responseText).errores.email)
            $('.invalid-feedback-dni').append(JSON.parse(error.responseText).errores.dni)
        }
    })
}

/**
 * It allows to see a specific student in modal window
 * @param {HTMLElement} form
 */
function verAlumno(form) {
    let id = form.getAttribute('data-editar')
    
    fetch(`/gestor_academia_mvc/alumnos/${id}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
        },
    })
    .then(respuesta => {
        return respuesta.json()
    })
    .then(datos => {
        
        $("#editar-id").val(datos[0].id)
        $("#editar-nombre").val(datos[0].nombre)
        $("#editar-apellidos").val(datos[0].apellidos)
        $("#editar-email").val(datos[0].email)
        $("#editar-dni").val(datos[0].dni)
        
    })
    .catch(error => {
        console.error(error)
    })
}

/**
 * It allows to edit data for a specific student. Using Fetch.
 * @throws Error
 */
function editarAlumno() {
    let id = document.querySelector('#editar-form input[name=id]').value
    let nombre = document.querySelector('#editar-form input[name=nombre]').value
    let apellidos = document.querySelector('#editar-form input[name=apellidos]').value
    let email = document.querySelector('#editar-form input[name=email]').value
    let dni = document.querySelector('#editar-form input[name=dni]').value

    fetch(`/gestor_academia_mvc/alumnos/${id}`, {
        method: 'PUT',
        headers: {
            'Accept': 'application/json',
            'Content-type': 'application/json',
        },
        body: JSON.stringify({
            nombre: nombre,
            apellidos: apellidos,
            email: email,
            dni: dni
        })
    })
    .then(async respuesta => {
        $('.edit-invalid').empty()

        if (!respuesta.ok) {

            respuesta.clone().json().then(async promesa => {
                $('.invalid-feedback-editar-nombre').append(promesa.errores.nombre)
                $('.invalid-feedback-editar-apellidos').append(promesa.errores.apellidos)
                $('.invalid-feedback-editar-email').append(promesa.errores.email)
                $('.invalid-feedback-editar-dni').append(promesa.errores.dni)
            }).catch(error => {
                console.error('No se ha podido obtener los datos: ', error)
            })

            throw new Error("Error " + respuesta.status + " al llamar al backend: " + respuesta.statusText);
        }
        
        return respuesta.text()
    })
    .then(datos => {
        $("#tabla").load( "/gestor_academia_mvc/alumnos #tabla" );
        alert('Datos del alumno actualizados.')
        $('#editarModal').modal('hide')
    })
    .catch(error => {
        console.error(error)
    })
}

/**
 * It allows to delete a specific student in modal window
 * @param {HTMLElement} form
 */
function eliminarModal(data) // El parámetro debe estar en el botón eliminar 
{
    let id = data.getAttribute('data-eliminarid');
    let nombre = data.getAttribute('data-eliminarnombre');

    document.getElementById('nombrealumno').innerHTML = nombre;
    confirmar = $("#confirmarEliminar");
    
    // Se ejecuta cuando hacemos click para confirmar el delete. Off elimina el listener para que no se ejecuten varios.
    confirmar.off('click').on('click', function() {
        $.ajax({
            type: 'DELETE',
            url: '/gestor_academia_mvc/alumnos/' + id,

            success: function(response) {
                console.log(response)
                alert('Alumno eliminado.')
                $('#eliminarModal').modal('hide')
                
                // Se recargan correctamente los datos de la tabla al eliminar un registro
                $( "#tabla" ).load( "/gestor_academia_mvc/alumnos #tabla" );

            },
            error: function (error) {
                alert(`${error.responseJSON.message} Código del error: ${error.status}.`)
            }

        })
    })

}
