-- ============================================================================
-- Course Management System - Database Schema
-- Варіант 8: Демонстрація Many-to-Many зв'язків
-- ============================================================================

-- Створення бази даних
CREATE DATABASE IF NOT EXISTS course_management;
USE course_management;

-- ============================================================================
-- Таблиця: courses
-- Описує курси в системі
-- ============================================================================
CREATE TABLE IF NOT EXISTS courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    instructor VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Таблиця: students
-- Описує студентів в системі
-- ============================================================================
CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    student_number VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Таблиця: enrollments
-- Таблиця зв'язку для реалізації Many-to-Many між students та courses
-- 
-- Демонстрація:
-- - Один студент (student_id) може бути записаний на багато курсів (course_id)
-- - Один курс (course_id) може мати багато студентів (student_id)
-- - Це реалізується через цю таблицю зв'язку
-- ============================================================================
CREATE TABLE IF NOT EXISTS enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- Зовнішні ключі для забезпечення цілісності даних
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    
    -- Унікальний індекс для запобігання дублювання записів
    UNIQUE KEY unique_enrollment (student_id, course_id),
    
    -- Індекси для оптимізації запитів
    INDEX idx_student_id (student_id),
    INDEX idx_course_id (course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Тестові дані
-- ============================================================================

-- Вставлення курсів
INSERT INTO courses (name, description, instructor) VALUES
('Вступ до PHP', 'Основи мови програмування PHP, синтаксис, змінні та типи даних', 'Іван Петренко'),
('Веб-розробка з PHP', 'Розробка веб-додатків з використанням PHP та MySQL', 'Марія Сидоренко'),
('Об\'єктно-орієнтоване програмування', 'ООП в PHP: класи, об\'єкти, спадкування, поліморфізм', 'Олег Коваленко'),
('Робота з базами даних', 'SQL, MySQL, проектування БД, нормалізація', 'Анна Гавриленко'),
('REST API розробка', 'Розробка RESTful API, JSON, обробка запитів', 'Петро Іванов');

-- Вставлення студентів
INSERT INTO students (name, email, student_number) VALUES
('Олександр Бондаренко', 'oleksandr.bondarenko@university.edu', 'ST001'),
('Вікторія Кравченко', 'viktoria.kravchenko@university.edu', 'ST002'),
('Дмитро Шевченко', 'dmytro.shevchenko@university.edu', 'ST003'),
('Софія Мельник', 'sofia.melnyk@university.edu', 'ST004'),
('Максим Волков', 'maksym.volkov@university.edu', 'ST005'),
('Ірина Павленко', 'irina.pavlenko@university.edu', 'ST006'),
('Сергій Морозов', 'sergiy.morozov@university.edu', 'ST007'),
('Наталія Лисенко', 'natalia.lysenko@university.edu', 'ST008');

-- Вставлення записів студентів на курси (Many-to-Many зв'язок)
INSERT INTO enrollments (student_id, course_id) VALUES
-- Олександр записаний на 3 курси
(1, 1), (1, 2), (1, 4),
-- Вікторія записана на 4 курси
(2, 1), (2, 2), (2, 3), (2, 5),
-- Дмитро записаний на 2 курси
(3, 1), (3, 3),
-- Софія записана на 5 курсів
(4, 1), (4, 2), (4, 3), (4, 4), (4, 5),
-- Максим записаний на 3 курси
(5, 2), (5, 4), (5, 5),
-- Ірина записана на 2 курси
(6, 1), (6, 3),
-- Сергій записаний на 4 курси
(7, 2), (7, 3), (7, 4), (7, 5),
-- Наталія записана на 3 курси
(8, 1), (8, 4), (8, 5);
