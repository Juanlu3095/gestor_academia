<?php

namespace database\migrations;

require_once __DIR__ . '/../../config/database.php';

use database\migrations\DatabaseMigration;
use database\migrations\UserMigration;
use database\migrations\StudentMigration;
use database\migrations\TeacherMigration;
use database\migrations\CourseMigration;
use database\migrations\CourseStudentMigration;
use database\migrations\DocumentMigration;
use database\migrations\IncidenceMigration;

$database = new DatabaseMigration(DBCONFIG);
$users = new UserMigration(DBCONFIG);
$students = new StudentMigration(DBCONFIG);
$teachers = new TeacherMigration(DBCONFIG);
$courses = new CourseMigration(DBCONFIG);
$courseStudents = new CourseStudentMigration(DBCONFIG);
$documents = new DocumentMigration(DBCONFIG);
$incidences = new IncidenceMigration(DBCONFIG);

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