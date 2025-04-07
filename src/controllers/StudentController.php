<?php

namespace src\controllers;

define('CONFIG', require_once __DIR__ . '/../../config/database.php');

use Error;
use http\schema\StudentSchema;
use services\StudentValidationService;
use src\models\StudentModel;

class StudentController {

    private static $studentModel;
    private static $studentService;

    private static function conectar() {
        self::$studentModel = new StudentModel(CONFIG);
        self::$studentService = new StudentValidationService(CONFIG);
    }

    public static function index (array $vars)
    {
        $busqueda = isset($vars['busqueda']) ? $vars['busqueda'] : '';

        self::conectar();
        
        if(isset($vars['busqueda']) && $busqueda != '') {
            $students = self::$studentModel->getStudents($busqueda);
        } else {
            $students = self::$studentModel->getStudents();
        }

        require_once __DIR__ . '/../views/alumnos.php';
    }

    public static function show(array $vars)
    {
        $id = (string) $vars['id'];

        self::conectar();

        $student = self::$studentModel->getStudent($id);

        if(sizeof($student) < 1) {
            throw new Error('No hay registros de alumnos que cumplan con la consulta.');
        }
        
        echo json_encode($student);
    }

    public static function create()
    {
        $json = file_get_contents('php://input'); // Obtenemos los datos del post que nos viene del form
        $request = [
            'nombre' => json_decode($json, false)->nombre,
            'apellidos' => json_decode($json, false)->apellidos,
            'email' => json_decode($json, false)->email,
            'dni' => json_decode($json, false)->dni,
        ];

        $validateRequest = StudentSchema::validate($request, $_SERVER['REQUEST_METHOD']); // Validamos sin BD
        
        self::conectar();

        $validateDni = self::$studentService->comprobar_dni_unico($request['dni']);
        $validateEmail = self::$studentService->comprobar_email_unico($request['email']);

        // VALIDACIONES CON EL SCHEMA.
        if(!$validateRequest['success']) {
            echo json_encode(['errores' => $validateRequest['errors'], 'mensaje' => 'Los datos enviados son erróneos.']);
            http_response_code(400);
            exit();
        }
        
        // VALIDACIONES CON EL SERVICIO
        if(!$validateDni) {
            echo json_encode(['errores' => ['dni' => 'DNI no válido.'], 'mensaje' => 'Los datos enviados son erróneos.']);
            http_response_code(422);
            exit();
        }

        if(!$validateEmail) {
            echo json_encode(['errores' => ['email' => 'Email no válido.'], 'mensaje' => 'Los datos enviados son erróneos.']);
            http_response_code(422);
            exit();
        }

        self::$studentModel->createStudent($validateRequest['data']);// Hay problemas si se intenta añadir un alumno existente
        echo json_encode(['respuesta' => 201, 'mensaje' => 'Alumno añadido con éxito']);

    }

    public static function update(string $id)
    {

    }

    public static function delete(string $id)
    {

    }

}

?>