<?php

namespace database\seeders;

$dbconfig = require_once __DIR__ . '/../../config/database.php';

use database\seeders\StudentSeeder;
use database\seeders\TeacherSeeder;
use database\seeders\CourseSeeder;
use database\seeders\UserSeeder;

$student = new StudentSeeder($dbconfig);
$teacher = new TeacherSeeder($dbconfig);
$course = new CourseSeeder($dbconfig);
$user = new UserSeeder($dbconfig);

return [
    $student->seed(),
    $teacher->seed(),
    $course->seed(),
    $user->seed()
]

?>