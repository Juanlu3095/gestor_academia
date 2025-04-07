<?php

namespace src\models;

use database\Connection;
use Exception;

class StudentModel extends Connection {

    public function __construct(
        private readonly array $dbconfig
    )
    {
        parent::__construct($this->dbconfig);
    }

    public function getStudents (?string $busqueda = null)
    {
        try {
            if($busqueda) {
                $sql = "SELECT HEX(id) as id, nombre, apellidos, email, dni FROM `students` WHERE (nombre LIKE ? OR apellidos LIKE ? OR email LIKE ?)";
            } else {
                $sql = "SELECT HEX(id) as id, nombre, apellidos, email, dni FROM `students`";
            }
            $conexion = $this->accesoDB();
            $consulta = $conexion->prepare($sql);

            if($busqueda) {
                $consulta->execute(['%'.$busqueda.'%', '%'.$busqueda.'%', '%'.$busqueda.'%']);
            } else {
                $consulta->execute();
            }
            $resultado = $consulta->fetchAll();

            return $resultado;
        } catch (Exception $e) {
            echo 'Error al obtener todos los alumnos: ' . $e->getMessage() . ' Código del error: ' . $e->getCode();
        }
    }

    public function getStudent (string $id)
    {
        try {
            $sql = "SELECT HEX(id) as id, nombre, apellidos, email, dni FROM `students` WHERE HEX(id) = ?";
            $conexion = $this->accesoDB();
            $consulta = $conexion->prepare($sql);
            $consulta->execute([$id]);
            $resultado = $consulta->fetchAll();

            return $resultado;
        } catch (Exception $e) {
            echo 'Error al obtener el alumno especificado: ' . $e->getMessage() . ' Código del error: ' . $e->getCode();
        }
    }

    public function createStudent(array $request)
    {
        try {
            $sql = "INSERT into `students` (nombre, apellidos, email, dni) VALUES (:nombre, :apellidos, :email, :dni);";
            $conexion = $this->accesoDB();
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':nombre', $request['nombre']);
            $consulta->bindParam(':apellidos', $request['apellidos']);
            $consulta->bindParam(':email', $request['email']);
            $consulta->bindParam(':dni', $request['dni']);
            $consulta->execute();
            $resultado = $consulta->fetchAll();

            return $resultado;
        } catch (Exception $e) {
            echo 'Error al crear el alumno: ' . $e->getMessage() . ' Código del error: ' . $e->getCode();
        }
    }

    public function updateStudent(string $id, array $request)
    {
        try {
            $sql = "UPDATE `students` SET (nombre, apellidos, email, dni) VALUES (:nombre, :apellidos, :email, :dni) WHERE HEX(id) = ?;";
            $conexion = $this->accesoDB();
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':nombre', $request['nombre']);
            $consulta->bindParam(':apellidos', $request['apellidos']);
            $consulta->bindParam(':email', $request['email']);
            $consulta->bindParam(':dni', $request['dni']);
            $consulta->execute([$id]);
            $resultado = $consulta->fetchAll();

            return $resultado;
        } catch (Exception $e) {
            echo 'Error al actualizar el alumno: ' . $e->getMessage() . ' Código del error: ' . $e->getCode();
        }
    }

    public function deleteStudent(string $id)
    {
        try {
            $sql = "DELETE `students` WHERE HEX(id) = ?";
            $conexion = $this->accesoDB();
            $consulta = $conexion->prepare($sql);
            $consulta->execute([$id]);
            $resultado = $consulta->fetchAll();

            return $resultado;
        } catch (Exception $e) {
            echo 'Error al eliminar el alumno: ' . $e->getMessage() . ' Código del error: ' . $e->getCode();
        }
    }
    
}

?>