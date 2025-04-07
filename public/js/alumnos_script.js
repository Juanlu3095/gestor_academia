
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

    // CON ESTO MOSTRABA EL ALERT INCLUSO SI HUBIESE ERROR
    /* fetch('/gestor_academia_mvc/alumnos', {
        method: 'POST',
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
        console.log('Respuesta: ', respuesta)
        if (!respuesta.ok) {
            return await respuesta.clone().json().then(promesa => {
                console.log('Esta es la promesa: ', promesa)
                throw new Error("Error " + respuesta.status + " al llamar al backend: " + respuesta.statusText);
                // Coger el objeto obtenido y pasarlo al formulario debajo de cada input si hay error
                
            })
            .catch(error => {
                console.error(error)
            })
        }
        
        return respuesta.text()
    })
    .then(datos => {
        console.log('Éstos son los datos: ' , datos)
        $( "#tabla" ).load( "/gestor_academia_mvc/alumnos #tabla" )
        alert(JSON.parse(datos).mensaje)

        // Si no hay errores
        if(!JSON.parse(datos).errores) {
            $('#nuevoModal').modal('hide')
        }
    })
    .catch(error => {
        console.error(error)
    }) */
}

/**
 * It allows to see an specific student in modal window
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
        console.log(datos)
        
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
 * It allows to edit data for a specific student
 * @param {HTMLElement} form
 */
function editarAlumno(form) {

}
