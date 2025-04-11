<?php

namespace http\schema;

class StudentSchema {

    private static function is_valid_dni(string $dni) {
        $letter = substr($dni, -1); // Devuelve el último carácter empezando por el final, por eso el -1
        $numbers = substr($dni, 0, -1); // Empieza desde la posición 0 y omite el último carácter con el -1

        if(strlen($dni) != 9) { // Comprueba que la longitud de $dni sea 9 exacto
            return false;
        }

        if(!is_numeric($numbers)) { // Comprueba que $numbers contenga sólo números
            return false;
        }
      
        if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numbers%23, 1) == $letter && strlen($letter) == 1 && strlen ($numbers) == 8 ){
          return true;
        }
        return false;
    }

    public static function validate(array $request, string $httpmethod)
    {
        switch($httpmethod) {
            case 'POST':
                // Vamos metiendo aquí los datos, ya sean correctos o no. Cuando algún dato no sea correcto el success será false
                // y se añadirán los errores uno a uno en 'errors'
                $validation = [
                    'success' => true, // Iniciamos en true y si hay algún error se cambia a false
                    'data' => [
                        'nombre' => '',
                        'apellidos' => '',
                        'email' => '',
                        'dni' => '',
                    ],
                    'errors' => [
                        'nombre' => '',
                        'apellidos' => '',
                        'email' => '',
                        'dni' => '',
                    ]
                ]; 

                // NOMBRE
                if($request['nombre'] && is_string($request['nombre'])) {
                    $validation['data']['nombre'] = preg_replace('([^A-Za-záéíóúÁÉÍÓÚ ])', '', $request['nombre']);
                } else {
                    $validation['success'] = false;
                    $validation['errors']['nombre'] = 'El campo nombre no es correcto.';
                }

                // APELLIDOS
                if($request['apellidos'] && is_string($request['apellidos'])) {
                    $validation['data']['apellidos'] = preg_replace('([^A-Za-záéíóúÁÉÍÓÚ ])', '', $request['apellidos']);
                } else {
                    $validation['success'] = false;
                    $validation['errors']['apellidos'] = 'El campo apellidos no es correcto.';
                }

                // EMAIL
                if(filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                    $validation['data']['email'] = $request['email'];
                } else {
                    $validation['success'] = false;
                    $validation['errors']['email'] = 'El campo email no es correcto.';
                }

                // DNI
                if($request['dni'] && self::is_valid_dni($request['dni'])) {
                    $validation['data']['dni'] = $request['dni'];
                } else {
                    $validation['success'] = false;
                    $validation['errors']['dni'] = 'El campo dni no es correcto.';
                }

                return $validation;
                break;

            case 'PUT':
                $validation = [
                    'success' => true, // Iniciamos en true y si hay algún error se cambia a false
                    'data' => [
                        'nombre' => '',
                        'apellidos' => '',
                        'email' => '',
                        'dni' => '',
                    ],
                    'errors' => [
                        'nombre' => '',
                        'apellidos' => '',
                        'email' => '',
                        'dni' => '',
                    ]
                ]; 

                // NOMBRE
                if($request['nombre'] && is_string($request['nombre'])) {
                    $validation['data']['nombre'] = preg_replace('([^A-Za-záéíóúÁÉÍÓÚ ])', '', $request['nombre']);
                } else {
                    $validation['success'] = false;
                    $validation['errors']['nombre'] = 'El campo nombre no es correcto.';
                }

                // APELLIDOS
                if($request['apellidos'] && is_string($request['apellidos'])) {
                    $validation['data']['apellidos'] = preg_replace('([^A-Za-záéíóúÁÉÍÓÚ ])', '', $request['apellidos']);
                } else {
                    $validation['success'] = false;
                    $validation['errors']['apellidos'] = 'El campo apellidos no es correcto.';
                }

                // EMAIL
                if(filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
                    $validation['data']['email'] = $request['email'];
                } else {
                    $validation['success'] = false;
                    $validation['errors']['email'] = 'El campo email no es correcto.';
                }

                // DNI
                if($request['dni'] && self::is_valid_dni($request['dni'])) {
                    $validation['data']['dni'] = $request['dni'];
                } else {
                    $validation['success'] = false;
                    $validation['errors']['dni'] = 'El campo dni no es correcto.';
                }

                return $validation;
                break;

            default:
                return 'Los datos no son válidos';
                break;
        }
    }
}

?>