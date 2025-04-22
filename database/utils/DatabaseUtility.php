<?php

namespace database\utils;

use database\Connection;
use Exception;

class DatabaseUtility extends Connection {

    public function __construct(
        private readonly array $dbconfig // Aquí definimos el array y no fuera por PHP 8
    )
    {
        parent::__construct($this->dbconfig);
    }

    /**
     * https://www.delftstack.com/es/howto/mysql/mysql-check-if-database-exists/
     * Tests if given database name exists in server.
     * @return bool True if database exists.
     * @return string In case there is a error.
     */
    public function verifyDatabaseExists(): bool
    {
        try {
            $sql = 'SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?';
            $conexion = $this->accesoDB();
            $consulta = $conexion->prepare($sql);
            $consulta->execute([$this->dbconfig['DB_NAME']]);
            $resultado = $consulta->fetchColumn();

            if($resultado === 1) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            return 'Error en la consulta mysql: ' . $e->getMessage() . ' Código de error: ' . $e->getCode() . "\n";
        }
    }

    /**
     * Verifies if a given table exists in database.
     * @param string $dbtable
     * @return bool True if table exists within database.
     * @return string If error.
     */
    public function verifyTableExists(string $dbtable)
    {
        try {
            $sql = "SHOW TABLES LIKE :tabla";
            $conexion = $this->accesoDB();
            $consulta = $conexion->prepare($sql);
            $consulta->bindValue(':tabla', $dbtable);
            $consulta->execute();
            
            return $consulta->rowCount() > 0;
        } catch (Exception $e) {
            return 'Error en la consulta mysql: ' . $e->getMessage() . ' Código de error: ' . $e->getCode() . "\n";
        }
    }
}

?>
