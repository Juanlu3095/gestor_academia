<?php

namespace database\seeders;

use database\Connection;
use Exception;

class TeacherSeeder extends Connection {

    public function __construct(private readonly array $dbconfig)
    {
        parent::__construct($this->dbconfig);
    }

    public function seed()
    {
        $row = ['Pepe', 'González López', 'pgonzalez@gmail.es', '111111111A'];

        try {
            $sql = "INSERT into `teachers` (nombre, apellidos, email, dni) VALUES (?,?,?,?);";
            $conexion = $this->accesoDB();
            $consulta = $conexion->prepare($sql);
            $consulta->execute($row);

            echo 'Ejecución del seeder de teachers ejecutado con éxito.';
        } catch (Exception $e) {
            echo 'Error al ejecutar el seed de teachers: ' . $e->getMessage() . ' Código del error: ' . $e->getCode();
        }
    }
}
?>