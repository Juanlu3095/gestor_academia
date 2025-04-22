<?php

namespace database\migrations;

use database\Connection;
use Exception;

class StudentMigration {

    public function __construct(
        private readonly array $dbconfig
    ) {}

    public function migrate()
    {
        try {
            $estructura = "id BINARY(16) PRIMARY KEY DEFAULT(UUID_TO_BIN(UUID())), nombre VARCHAR(50) NOT NULL, apellidos VARCHAR(50)
                           NOT NULL, email VARCHAR(50) UNIQUE NOT NULL, dni VARCHAR(10) UNIQUE NOT NULL, created_at TIMESTAMP
                           DEFAULT(NOW()) NOT NULL, updated_at TIMESTAMP DEFAULT(NOW()) NOT NULL";
            $sql = "CREATE TABLE IF NOT EXISTS `students` ($estructura)";
            $conexion = new Connection($this->dbconfig);
            $consulta = $conexion->accesoDB()->prepare($sql);
            $consulta->execute();
            
            echo 'Tabla students creada con éxito.\n';
        } catch (Exception $e) {
            echo 'Error al crear la tabla students: ' . $e->getMessage() . ' Código del error: ' . $e->getCode() . "\n";
        }
    }
}
?>