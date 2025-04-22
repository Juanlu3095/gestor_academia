<?php

namespace database\seeders;

use database\Connection;
use Exception;

class UserSeeder extends Connection {

    function __construct(private readonly array $dbconfig)
    {
        parent::__construct($this->dbconfig);
    }

    public function seed ()
    {
        $row = [
            'nombre' => 'Pepe',
            'email' => 'pepelopez@gmail.com',
            'password' => password_hash('pepe', PASSWORD_DEFAULT) // Se creará un string de 60 caracteres
        ];

        try {
            $sql = "INSERT into `users` (nombre, email, password) VALUES (:nombre, :email, :password);";
            $conexion = $this->accesoDB();
            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':nombre', $row['nombre']);
            $consulta->bindParam(':email', $row['email']);
            $consulta->bindParam(':password', $row['password']);
            $consulta->execute();

            echo 'Ejecución del seeder de users ejecutado con éxito.\n';
        } catch (Exception $e) {
            echo 'Error al ejecutar el seed de users: ' . $e->getMessage() . ' Código del error: ' . $e->getCode() . "\n";
        }
    }
}

?>