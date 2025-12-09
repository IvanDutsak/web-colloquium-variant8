<?php
/**
 * Course Management System
 * Варіант 8: Зв'язки між сутностями та DRY принцип
 */

// Ініціалізація сесії
session_start();

// Підключення конфігурації та класів
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/Model.php';
require_once __DIR__ . '/src/Course.php';
require_once __DIR__ . '/src/Student.php';
require_once __DIR__ . '/src/Enrollment.php';

// Ініціалізація бази даних
$db = Database::getInstance();

// Маршрутизація
$action = $_GET['action'] ?? 'courses';
$id = $_GET['id'] ?? null;

// Обробка запитів
switch ($action) {
    case 'courses':
        $courses = Course::all();
        require_once __DIR__ . '/views/courses/index.php';
        break;
    
    case 'course':
        if ($id) {
            $course = Course::find($id);
            $students = $course->getStudents();
            require_once __DIR__ . '/views/courses/show.php';
        }
        break;
    
    case 'students':
        $students = Student::all();
        require_once __DIR__ . '/views/students/index.php';
        break;
    
    case 'student':
        if ($id) {
            $student = Student::find($id);
            $courses = $student->getCourses();
            require_once __DIR__ . '/views/students/show.php';
        }
        break;
    
    case 'enroll':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $studentId = $_POST['student_id'] ?? null;
            $courseId = $_POST['course_id'] ?? null;
            
            if ($studentId && $courseId) {
                Enrollment::create($studentId, $courseId);
                $_SESSION['message'] = 'Студент успішно записаний на курс!';
            }
        }
        header('Location: index.php?action=students');
        exit;
    
    default:
        $courses = Course::all();
        require_once __DIR__ . '/views/courses/index.php';
}
