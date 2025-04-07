<?php

namespace database\migrations;

use database\Connection;
use Exception;

class DocumentMigration {

    public function __construct(
        private readonly array $dbconfig
    ){}

    public function migrate() {
        try {
            $estructura = "id BINARY(16) PRIMARY KEY DEFAULT(UUID_TO_BIN(UUID())), nombre VARCHAR(100) NOT NULL,
                           url VARCHAR(100) NOT NULL, created_at TIMESTAMP DEFAULT(NOW()) NOT NULL,
                           updated_at TIMESTAMP DEFAULT(NOW()) NOT NULL";
            $sql = "CREATE TABLE IF NOT EXISTS `documents` ($estructura)";
            $conexion = new Connection($this->dbconfig);
            $consulta = $conexion->accesoDB()->prepare($sql);
            $consulta->execute();

            echo 'Tabla documents creada con éxito.';
        } catch (Exception $e) {
            echo 'Error al crear la tabla documents: ' . $e->getMessage() . ' Código del error: ' . $e->getCode();
        }
    }
}

?>