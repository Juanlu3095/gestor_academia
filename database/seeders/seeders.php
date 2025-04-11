<?php

namespace database\seeders;

require_once __DIR__ . '/../../config/database.php';

use database\seeders\StudentSeeder;
use database\seeders\TeacherSeeder;
use database\seeders\CourseSeeder;
use database\seeders\UserSeeder;

$student = new StudentSeeder(DBCONFIG);
$teacher = new TeacherSeeder(DBCONFIG);
$course = new CourseSeeder(DBCONFIG);
$user = new UserSeeder(DBCONFIG);

return [
    $student->seed(),
    $teacher->seed(),
    $course->seed(),
    $user->seed()
]

?>