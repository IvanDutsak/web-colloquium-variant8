<?php
/**
 * Course Management System
 * Варіант 8: Зв'язки між сутностями та DRY принцип
 */

// Увімкнення відображення помилок для налагодження
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
try {
    $db = Database::getInstance();
} catch (Exception $e) {
    die('Помилка підключення до бази даних: ' . $e->getMessage());
}

// Маршрутизація
$action = $_GET['action'] ?? 'courses';
$id = $_GET['id'] ?? null;

// Обробка запитів
switch ($action) {
    case 'courses':
        // Отримання всіх курсів
        $courses = Course::all();
        $title = 'Курси';
        $currentAction = 'courses';
        include __DIR__ . '/views/courses_index.php';
        break;
    
    case 'course':
        // Деталі курсу
        if ($id) {
            $course = Course::find($id);
            if ($course) {
                $students = $course->getStudents();
                $title = 'Курс: ' . $course->name;
                $currentAction = 'course';
                include __DIR__ . '/views/course_show.php';
            } else {
                die('Курс не знайдено');
            }
        } else {
            die('ID курсу не вказано');
        }
        break;
    
    case 'students':
        // Отримання всіх студентів
        $students = Student::all();
        $title = 'Студенти';
        $currentAction = 'students';
        include __DIR__ . '/views/students_index.php';
        break;
    
    case 'student':
        // Деталі студента
        if ($id) {
            $student = Student::find($id);
            if ($student) {
                $courses = $student->getCourses();
                $title = 'Студент: ' . $student->name;
                $currentAction = 'student';
                include __DIR__ . '/views/student_show.php';
            } else {
                die('Студента не знайдено');
            }
        } else {
            die('ID студента не вказано');
        }
        break;
    
    default:
        // За замовчуванням показуємо курси
        $courses = Course::all();
        $title = 'Курси';
        $currentAction = 'courses';
        include __DIR__ . '/views/courses_index.php';
}
