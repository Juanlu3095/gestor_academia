<?php

namespace database\migrations;

use database\Connection;
use Exception;

class IncidenceMigration {

    public function __construct(
        private readonly array $dbconfig
    ) {}

    public function migrate()
    {
        try {
            $estructura = "id BINARY(16) PRIMARY KEY DEFAULT(UUID_TO_BIN(UUID())), titulo VARCHAR(100) NOT NULL,
                           sumario TEXT NOT NULL, fecha DATE, document_id BINARY(16) NOT NULL, incidenceable_id BINARY(16) NOT NULL,
                           incidenceable_type VARCHAR(100), created_at TIMESTAMP DEFAULT(NOW()) NOT NULL,
                           updated_at TIMESTAMP DEFAULT(NOW()) NOT NULL, FOREIGN KEY (document_id) REFERENCES documents(id)";
            $sql = "CREATE TABLE IF NOT EXISTS `incidences` ($estructura)";
            $conexion = new Connection($this->dbconfig);
            $consulta = $conexion->accesoDB()->prepare($sql);
            $consulta->execute();
            
            echo 'Tabla incidences creada con éxito.\n';
        } catch (Exception $e) {
            echo 'Error al crear la tabla incidences: ' . $e->getMessage() . ' Código del error: ' . $e->getCode() . "\n";
        }
    }
}
?>