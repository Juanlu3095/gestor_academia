<?php

namespace database\migrations;

// require_once __DIR__ . '/../connection.php'; // Esto ya no hace falta gracias a composer.json/psr-4

use database\Connection;
use Exception;

class DatabaseMigration {

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function migrate ()
    {
        try {
            unset($this->config['DB_NAME']); // Quitamos DB_NAME del array ya que no lo necesitamos
            $consulta = "CREATE DATABASE IF NOT EXISTS gestor_academia_mvc";
            $conexion = new Connection($this->config);
            $basedatos = $conexion->accesoDB();
            $ejecucion = $basedatos->prepare($consulta);
            $ejecucion->execute();
            $resultado = $ejecucion->fetchAll();
            $basedatos = null; // Cerramos la conexion a la base de datos
            echo 'Base de datos creada con éxito.';
        } catch (Exception $e) {
            echo 'Error al crear la base de datos: ' . $e->getMessage();
        }
        
    }
}

?>
