<?php

namespace tests\feature;

define('ENV', require_once __DIR__ . '/../../config/test.php');

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class StudentTest extends TestCase {

    public function test_student_page()
    {
        $client = new Client([
            'base_uri' => ENV['URL_BASE_TESTS']
        ]);

        $response = $client->get('alumnos');

        $this->assertSame(200, $response->getStatusCode());
    }
}

?>