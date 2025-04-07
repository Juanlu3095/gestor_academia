<?php

namespace database\migrations;

use database\Connection;
use Exception;

class CourseMigration {

    public function __construct(
        private readonly array $dbconfig
    ){}

    public function migrate() {
        try {
            $estructura = "id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(100) NOT NULL, fecha VARCHAR(50) NOT NULL,
                           horas INT NOT NULL, descripcion TEXT NOT NULL, teacher_id BINARY(16) NOT NULL,
                           created_at TIMESTAMP DEFAULT(NOW()) NOT NULL, updated_at TIMESTAMP DEFAULT(NOW()) NOT NULL, 
                           FOREIGN KEY (teacher_id) REFERENCES teachers(id)";
            $sql = "CREATE TABLE IF NOT EXISTS `courses` ($estructura)";
            $conexion = new Connection($this->dbconfig);
            $consulta = $conexion->accesoDB()->prepare($sql);
            $consulta->execute();

            echo 'Tabla courses creada con éxito.';
        } catch (Exception $e) {
            echo 'Error al crear la tabla courses: ' . $e->getMessage() . ' Código del error: ' . $e->getCode();
        }
    }
}

?>