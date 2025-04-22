<?php

namespace database\migrations;

use database\Connection;
use Exception;

class CourseStudentMigration {

    public function __construct(
        private readonly array $dbconfig
    ){}

    public function migrate() {
        try {
            $estructura = "id BINARY(16) PRIMARY KEY DEFAULT(UUID_TO_BIN(UUID())), course_id INT UNSIGNED, student_id INT UNSIGNED,
                           created_at TIMESTAMP DEFAULT(NOW()) NOT NULL, updated_at TIMESTAMP DEFAULT(NOW()) NOT NULL,
                           FOREIGN KEY (course_id) REFERENCES courses(id), FOREIGN KEY (student_id) REFERENCES students(id)";
            $sql = "CREATE TABLE IF NOT EXISTS `course_students` ($estructura)";
            $conexion = new Connection($this->dbconfig);
            $consulta = $conexion->accesoDB()->prepare($sql);
            $consulta->execute();

            echo 'Tabla course_students creada con éxito.\n';
        } catch (Exception $e) {
            echo 'Error al crear la tabla course_students: ' . $e->getMessage() . ' Código del error: ' . $e->getCode() . "\n";
        }
    }
}

?>