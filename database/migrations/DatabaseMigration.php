<?php

namespace database\migrations;

// require_once __DIR__ . '/../connection.php'; // Esto ya no hace falta gracias a composer.json/psr-4

use database\Connection;
use Exception;

class DatabaseMigration {

    private array $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function migrate ()
    {
        try {
            $consulta = "CREATE DATABASE IF NOT EXISTS " . $this->config['DB_NAME'];
            unset($this->config['DB_NAME']); // Quitamos DB_NAME del array ya que no lo necesitamos
            $conexion = new Connection($this->config);
            $basedatos = $conexion->accesoDB();
            $ejecucion = $basedatos->prepare($consulta);
            $ejecucion->execute();
            $resultado = $ejecucion->fetchAll();
            $basedatos = null; // Cerramos la conexion a la base de datos
            echo "Base de datos creada con éxito.\n";
        } catch (Exception $e) {
            echo "Error al crear la base de datos: " . $e->getMessage() ."\n";
        }
    }

    public function destroy ()
    {
        try {
            $consulta = "DROP DATABASE IF EXISTS " . $this->config['DB_NAME'];
            $conexion = new Connection($this->config);
            $basedatos = $conexion->accesoDB();
            $ejecucion = $basedatos->prepare($consulta);
            $ejecucion->execute();
            $basedatos = null;
            
            echo 'Base de datos eliminada con éxito.\n';
        } catch (Exception $e) {
            echo 'Error al eliminar la base de datos: ' . $e->getMessage() . "\n";
        }
    }
}

?>
