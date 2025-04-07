<?php

namespace database\migrations;

$dbconfig = require_once __DIR__ . '/../../config/database.php';

use database\migrations\DatabaseMigration;
use database\migrations\UserMigration;
use database\migrations\StudentMigration;
use database\migrations\TeacherMigration;
use database\migrations\CourseMigration;
use database\migrations\CourseStudentMigration;
use database\migrations\DocumentMigration;
use database\migrations\IncidenceMigration;

$database = new DatabaseMigration($dbconfig);
$users = new UserMigration($dbconfig);
$students = new StudentMigration($dbconfig);
$teachers = new TeacherMigration($dbconfig);
$courses = new CourseMigration($dbconfig);
$courseStudents = new CourseStudentMigration($dbconfig);
$documents = new DocumentMigration($dbconfig);
$incidences = new IncidenceMigration($dbconfig);

return [
    $database->migrate(),
    $users->migrate(),
    $students->migrate(),
    $teachers->migrate(),
    $courses->migrate(),
    $courseStudents->migrate(),
    $documents->migrate(),
    $incidences->migrate()
]

?>