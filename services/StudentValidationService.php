<?php

/*
*  Este servicio se encarga de realizar las validaciones en las que sea necesario el uso de la BD
*
*  params $dbconfig (array)
*  returns bool
*/

namespace services;

use database\Connection;
use Exception;

class StudentValidationService {

    public function __construct(
        private readonly array $dbconfig
    ){}

    /**
     * It validates if a given dni is already in the database.
     * @param string $dni
     * @return bool
     */
    public function comprobar_dni_unico(string $dni)
    {
        try {
            $sql = "SELECT count(dni) FROM `students` WHERE dni = ?";
            $conexion = new Connection($this->dbconfig);
            $consulta = $conexion->accesoDB()->prepare($sql);
            $consulta->execute([$dni]);
            $resultado = $consulta->fetchColumn();

            // fetchColumn devuelve el valor de la primera columna de la primera fila del resultado de la consulta.

            if($resultado == 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return 'Error al validar la unicidad del DNI: ' . $e->getMessage() . ' Código del error: ' . $e->getCode();
        }
    }

    /**
     * It validates if a given email is already in the database.
     * @param string $email
     * @return bool
     */
    public function comprobar_email_unico($email)
    {
        try {
            $sql = "SELECT count(email) FROM `students` WHERE email = ?";
            $conexion = new Connection($this->dbconfig);
            $consulta = $conexion->accesoDB()->prepare($sql);
            $consulta->execute([$email]);
            $resultado = $consulta->fetchColumn(); // REVISAR QUE REALMENTE DEVUELVE UN NÚMERO CON EL COUNT()

            if($resultado == 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return 'Error al validar la unicidad del email: ' . $e->getMessage() . ' Código del error: ' . $e->getCode();
        }
    }
}

?>