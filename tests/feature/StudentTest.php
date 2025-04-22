<?php

namespace tests\feature;

require_once __DIR__ . '/../../config/test.php';

use database\migrations\DatabaseMigration;
use database\migrations\StudentMigration;
use database\utils\DatabaseUtility;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class StudentTest extends TestCase {

    public function test_database_config()
    {
        $dbconfig = DBCONFIG_TEST;
        unset($dbconfig['DB_NAME']); // Se usará este array para cuando no sea necesario DB_NAME
        
        $databaseMigration = new DatabaseMigration(DBCONFIG_TEST);
        $databaseUtilityNoDB = new DatabaseUtility($dbconfig);
        $databaseUtility = new DatabaseUtility(DBCONFIG_TEST);
        $studentMigration = new StudentMigration(DBCONFIG_TEST);
        
        $databaseExists = $databaseUtilityNoDB->verifyDatabaseExists(DBCONFIG_TEST['DB_NAME']);

        if($databaseExists) {
            $databaseMigration->destroy();
        } else {
            $databaseMigration->migrate();
        }
        $studentMigration->migrate();
        
        // Función que compruebe que la tabla existen
        $tableExists = $databaseUtility->verifyTableExists('students');
        $this->assertTrue($tableExists);
    }

    public function test_student_page()
    {
        $client = new Client([
            'base_uri' => URL_TEST
        ]);
        
        $response = $client->get('alumnos'); // POR QUÉ SALE 200 SI ESTA RUTA AÚN NO EXISTE???
        
        $this->assertSame(200, $response->getStatusCode());
    }
}

?>