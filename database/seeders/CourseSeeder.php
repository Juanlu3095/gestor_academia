<?php

namespace database\seeders;

use database\Connection;
use Exception;

class CourseSeeder extends Connection {

    public function __construct(
        private readonly array $dbconfig
    )
    {
        parent::__construct($this->dbconfig);
    }

    // Obtener primero el id de un profesor para pasarlo a seed().
    private function getTeacher()
    {
        $nombre = ['Pepe']; // Poner aquí el nombre de un profesor de la base de datos
        try {
            $sql = "SELECT id FROM `teachers` WHERE nombre = ?";
            $conexion = $this->accesoDB();
            $consulta = $conexion->prepare($sql);
            $consulta->execute($nombre);
            $resultado = $consulta->fetch();

            return $resultado['id'];
        } catch (Exception $e) {
            echo 'Error al obtener un profesor para el seed de courses: ' . $e->getMessage() . ' Código del error: ' . $e->getCode();
        }
    }

    public function seed()
    {
        $idCourse = self::getTeacher();
        $row = ['Desarrollo de aplicaciones con Java', 'Mayo 2025', 300, 'Curso de java', $idCourse];

        try {
            $sql = "INSERT into `courses` (nombre, fecha, horas, descripcion, teacher_id) VALUES (?,?,?,?,?);";
            $conexion = $this->accesoDB();
            $consulta = $conexion->prepare($sql);
            $consulta->execute($row);

            echo 'Ejecución del seeder de courses ejecutado con éxito.';
        } catch (Exception $e) {
            echo 'Error al ejecutar el seed de courses: ' . $e->getMessage() . ' Código del error: ' . $e->getCode();
        }
    }
}
?>