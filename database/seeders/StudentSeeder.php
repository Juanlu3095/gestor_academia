<?php

namespace database\seeders;

use database\Connection;
use Exception;

class StudentSeeder extends Connection {

    public function __construct(private readonly array $dbconfig)
    {
        parent::__construct($this->dbconfig);
    }

    public function seed()
    {
        $row = [
            'nombre' => 'Pepe',
            'apellidos' => 'González López',
            'email' => 'pgonzalez@gmail.es',
            'dni' => '111111111A'
        ];

        try {
            $sql = "INSERT into `students` (nombre, apellidos, email, dni) VALUES (:nombre, :apellidos, :email, :dni);";
            $conexion = $this->accesoDB();
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':nombre', $row['nombre']);
            $consulta->bindParam(':apellidos', $row['apellidos']);
            $consulta->bindParam(':email', $row['email']);
            $consulta->bindParam(':dni', $row['dni']);
            $consulta->execute();

            echo 'Ejecución del seeder de students ejecutado con éxito.\n';
        } catch (Exception $e) {
            echo 'Error al ejecutar el seed de students: ' . $e->getMessage() . ' Código del error: ' . $e->getCode() . "\n";
        }
    }
}
?>