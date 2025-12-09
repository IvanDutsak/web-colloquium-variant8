-- ============================================================================
-- Course Management System - Database Schema (CLEAN VERSION)
-- Варіант 8: Демонстрація Many-to-Many зв'язків
-- 
-- Цей скрипт ВИДАЛЯЄ існуючі таблиці перед створенням нових
-- Використовуйте його, якщо потрібно почати з чистого аркуша
-- ============================================================================

USE course_management;

-- Видалення існуючих таблиць (якщо вони є)
DROP TABLE IF EXISTS enrollments;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS courses;

-- ============================================================================
-- Таблиця: courses
-- Описує курси в системі
-- ============================================================================
CREATE TABLE courses (
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
CREATE TABLE students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    student_number VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Таблиця: enrollments
-- Зв'язок Many-to-Many між students та courses
-- ============================================================================
CREATE TABLE enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    
    UNIQUE KEY unique_enrollment (student_id, course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Тестові дані: Курси
-- ============================================================================
INSERT INTO courses (name, description, instructor) VALUES
('Вступ до PHP', 'Основи мови програмування PHP, синтаксис, змінні, типи даних, оператори, функції. Робота з формами та обробка даних.', 'Іван Петренко'),
('Веб-розробка з PHP', 'Розробка веб-додатків з використанням PHP та MySQL. MVC архітектура, маршрутизація, шаблонізатори.', 'Марія Сидоренко'),
('Об\'єктно-орієнтоване програмування в PHP', 'ООП в PHP: класи, об\'єкти, спадкування, поліморфізм, інкапсуляція. Паттерни проектування.', 'Олег Коваленко'),
('Робота з базами даних', 'SQL, MySQL, проектування БД, нормалізація. PDO, підготовлені запити, транзакції.', 'Анна Гавриленко'),
('REST API розробка', 'Розробка RESTful API, JSON, обробка запитів, аутентифікація, документація API.', 'Петро Іванов');

-- ============================================================================
-- Тестові дані: Студенти
-- ============================================================================
INSERT INTO students (name, email, student_number) VALUES
('Олександр Бондаренко', 'oleksandr.bondarenko@university.edu', 'STN01'),
('Вікторія Кравченко', 'viktoria.kravchenko@university.edu', 'STN02'),
('Дмитро Шевченко', 'dmytro.shevchenko@university.edu', 'STN03'),
('Софія Мельник', 'sofia.melnyk@university.edu', 'STN04'),
('Максим Ткаченко', 'maksym.tkachenko@university.edu', 'STN05'),
('Анастасія Коваль', 'anastasia.koval@university.edu', 'STN06'),
('Артем Бойко', 'artem.boyko@university.edu', 'STN07'),
('Марія Лисенко', 'maria.lysenko@university.edu', 'STN08');

-- ============================================================================
-- Тестові дані: Записи студентів на курси (Many-to-Many зв'язок)
-- ============================================================================
INSERT INTO enrollments (student_id, course_id) VALUES
-- Олександр Бондаренко (STN01) - 3 курси
(1, 1), -- Вступ до PHP
(1, 2), -- Веб-розробка з PHP
(1, 3), -- ООП в PHP

-- Вікторія Кравченко (STN02) - 4 курси
(2, 1), -- Вступ до PHP
(2, 2), -- Веб-розробка з PHP
(2, 4), -- Робота з БД
(2, 5), -- REST API

-- Дмитро Шевченко (STN03) - 2 курси
(3, 1), -- Вступ до PHP
(3, 4), -- Робота з БД

-- Софія Мельник (STN04) - 3 курси
(4, 2), -- Веб-розробка з PHP
(4, 3), -- ООП в PHP
(4, 5), -- REST API

-- Максим Ткаченко (STN05) - 5 курсів (всі)
(5, 1), -- Вступ до PHP
(5, 2), -- Веб-розробка з PHP
(5, 3), -- ООП в PHP
(5, 4), -- Робота з БД
(5, 5), -- REST API

-- Анастасія Коваль (STN06) - 2 курси
(6, 1), -- Вступ до PHP
(6, 3), -- ООП в PHP

-- Артем Бойко (STN07) - 3 курси
(7, 2), -- Веб-розробка з PHP
(7, 4), -- Робота з БД
(7, 5), -- REST API

-- Марія Лисенко (STN08) - 4 курси
(8, 1), -- Вступ до PHP
(8, 2), -- Веб-розробка з PHP
(8, 3), -- ООП в PHP
(8, 4); -- Робота з БД

-- ============================================================================
-- Готово! База даних створена та заповнена тестовими даними
-- ============================================================================
