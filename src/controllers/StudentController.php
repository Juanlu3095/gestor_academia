<?php

namespace src\controllers;

require_once __DIR__ . '/../../config/database.php';

use Error;
use http\schema\StudentSchema;
use interfaces\Controller;
use services\StudentValidationService;
use src\models\StudentModel;

class StudentController implements Controller{

    private $studentModel;
    private $studentService;

    public function __construct(?array $dbconfig = [])
    {
        $this->studentModel = !empty($dbconfig) ? new StudentModel($dbconfig) : new StudentModel(DBCONFIG);
        $this->studentService = !empty($dbconfig) ? new StudentValidationService($dbconfig) : new StudentValidationService(DBCONFIG);
    }

    public function index (array $vars)
    {
        $busqueda = isset($vars['busqueda']) ? $vars['busqueda'] : '';
        
        if(isset($vars['busqueda']) && $busqueda != '') {
            $students = $this->studentModel->getStudents($busqueda);
        } else {
            $students = $this->studentModel->getStudents();
        }

        require_once __DIR__ . '/../views/alumnos.php';
    }

    public function show(array $vars, ?bool $mostrarRegistro = true)
    {
        $id = (string) $vars['id'];

        $student = $this->studentModel->getStudent($id);

        if(sizeof($student) < 1) {
            throw new Error('No hay registros de alumnos que cumplan con la consulta.');
        }
        
        if($mostrarRegistro) {
            echo json_encode($student);
        }
    }

    public function create()
    {
        $json = file_get_contents('php://input'); // Obtenemos los datos del post que nos viene del form
        $request = [
            'nombre' => json_decode($json, false)->nombre,
            'apellidos' => json_decode($json, false)->apellidos,
            'email' => json_decode($json, false)->email,
            'dni' => json_decode($json, false)->dni,
        ];

        $validateRequest = StudentSchema::validate($request, $_SERVER['REQUEST_METHOD']); // Validamos sin BD

        $validateDni = $this->studentService->comprobar_dni_unico($request['dni'], $_SERVER['REQUEST_METHOD']);
        $validateEmail = $this->studentService->comprobar_email_unico($request['email'], $_SERVER['REQUEST_METHOD']);

        // VALIDACIONES CON EL SCHEMA.
        if(!$validateRequest['success']) {
            echo json_encode(['errores' => $validateRequest['errors'], 'mensaje' => 'Los datos enviados son erróneos.']);
            http_response_code(422);
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

        $query = $this->studentModel->createStudent($validateRequest['data']);
        if($query > 0) {
            echo json_encode(['respuesta' => 201, 'mensaje' => 'Alumno añadido con éxito']);
        }

    }

    public function update(array $vars)
    {
        $this->show($vars, false);
        $id = (string) $vars['id']; // Comprueba que el alumno exista
        $json = file_get_contents('php://input'); // Obtenemos los datos del post que nos viene del form
        $request = [
            'nombre' => json_decode($json, false)->nombre,
            'apellidos' => json_decode($json, false)->apellidos,
            'email' => json_decode($json, false)->email,
            'dni' => json_decode($json, false)->dni,
        ];

        $validateRequest = StudentSchema::validate($request, $_SERVER['REQUEST_METHOD']); // Validamos sin BD

        $validateDni = $this->studentService->comprobar_dni_unico($request['dni'], $_SERVER['REQUEST_METHOD'], $id);
        $validateEmail = $this->studentService->comprobar_email_unico($request['email'], $_SERVER['REQUEST_METHOD'], $id);

        // VALIDACIONES CON EL SCHEMA.
        if(!$validateRequest['success']) {
            echo json_encode(['errores' => $validateRequest['errors'], 'mensaje' => 'Los datos enviados son erróneos.']);
            http_response_code(422);
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

        $updatedStudent = $this->studentModel->updateStudent($id, $request);

        if($updatedStudent > 0) {
            echo json_encode(['respuesta' => 200, 'mensaje' => 'Alumno actualizado con éxito.']);
        }
    }

    public function delete(array $vars)
    {
        $id = (string) $vars['id'];

        $this->show($vars, false);

        $query = $this->studentModel->deleteStudent($id);

        if($query > 0) {
            echo json_encode(['respuesta' => 200, 'mensaje' => 'Alumno eliminado con éxito.']);
        }
    }

}

?>