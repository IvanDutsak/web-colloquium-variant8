-- ============================================================================
-- Course Management System - Database Initialization Script
-- Варіант 8: Зв'язки між сутностями (Many-to-Many) та DRY принцип
-- ============================================================================

-- Видалення існуючих таблиць (для чистого старту)
DROP TABLE IF EXISTS enrollments;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS courses;

-- ============================================================================
-- Створення таблиці курсів
-- ============================================================================
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    instructor VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Створення таблиці студентів
-- ============================================================================
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    student_number VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Створення таблиці зв'язків (Many-to-Many)
-- ============================================================================
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (student_id, course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Вставка курсів
-- ============================================================================
INSERT INTO courses (name, description, instructor) VALUES
('Веб-програмування', 'Основи веб-програмування: HTML, CSS, JavaScript, PHP. Вивчення принципів створення динамічних веб-сайтів та роботи з базами даних.', 'Іван Петренко'),
('Бази даних', 'Проектування та робота з реляційними базами даних. SQL, MySQL, нормалізація, оптимізація запитів.', 'Марія Сидоренко'),
('Об\'єктно-орієнтоване програмування', 'ООП в PHP: класи, об\'єкти, спадкування, поліморфізм, інкапсуляція. Патерни проектування.', 'Олег Коваленко'),
('Алгоритми та структури даних', 'Вивчення базових алгоритмів сортування, пошуку. Структури даних: масиви, списки, дерева, графи.', 'Анна Гавриленко'),
('Розробка REST API', 'Створення RESTful API: JSON, обробка запитів, аутентифікація, документування API.', 'Петро Іванов');

-- ============================================================================
-- Вставка студентів (реальні дані з групи)
-- ============================================================================
INSERT INTO students (name, email, student_number) VALUES
('Айб Олександр Романович', 'oleksandr.ayb@pnu.edu.ua', 'PNU2024001'),
('Андрухів Богдан Володимирович', 'bohdan.andrukhiv@pnu.edu.ua', 'PNU2024002'),
('Антоняк Володимир Степанович', 'volodymyr.antonyak@pnu.edu.ua', 'PNU2024003'),
('Атаманюк Владислав Тарасович', 'vladyslav.atamanyuk@pnu.edu.ua', 'PNU2024004'),
('Башук Ростислав Юрійович', 'rostyslav.bashuk@pnu.edu.ua', 'PNU2024005'),
('Бернацький Євгеній Олегович', 'yevheniy.bernatskyy@pnu.edu.ua', 'PNU2024006'),
('Білий Олександр Віталійович', 'oleksandr.bilyy@pnu.edu.ua', 'PNU2024007'),
('Богач Надія Петрівна', 'nadiya.bohach@pnu.edu.ua', 'PNU2024008'),
('Буковецька Каріна Сергіївна', 'karina.bukovetska@pnu.edu.ua', 'PNU2024009'),
('Валько Назар Андрійович', 'nazar.valko@pnu.edu.ua', 'PNU2024010'),
('Вахновський Вадим Сергійович', 'vadym.vakhnovskyy@pnu.edu.ua', 'PNU2024011'),
('Волочій Денис Вікторович', 'denys.volochiy@pnu.edu.ua', 'PNU2024012'),
('Галуга Володимир Романович', 'volodymyr.haluha@pnu.edu.ua', 'PNU2024013'),
('Гараздюк Іван Іванович', 'ivan.harazdyuk@pnu.edu.ua', 'PNU2024014'),
('Гетьманська Олександра Сергіївна', 'oleksandra.hetmanska@pnu.edu.ua', 'PNU2024015'),
('Горайчук Михайло Олександрович', 'mykhaylo.horaychuk@pnu.edu.ua', 'PNU2024016'),
('Даців Максим Віталійович', 'maksym.datsiv@pnu.edu.ua', 'PNU2024017'),
('Дуцак Іван Михайлович', 'ivan.dutsak@pnu.edu.ua', 'PNU2024018'),
('Желіховська Тетяна Юріївна', 'tetyana.zhelikhovska@pnu.edu.ua', 'PNU2024019'),
('Калин Богдан Миколайович', 'bohdan.kalyn@pnu.edu.ua', 'PNU2024020'),
('Кісляк Андрій Васильович', 'andriy.kislyak@pnu.edu.ua', 'PNU2024021'),
('Козьменчук Андрій Васильович', 'andriy.kozmenchuk@pnu.edu.ua', 'PNU2024022'),
('Козьмин Віталій Васильович', 'vitaliy.kozmyn@pnu.edu.ua', 'PNU2024023'),
('Коцко Андрій Романович', 'andriy.kotsko@pnu.edu.ua', 'PNU2024024'),
('Курман Руслан Ігорович', 'ruslan.kurman@pnu.edu.ua', 'PNU2024025'),
('Кучірка Любомир Іванович', 'lyubomyr.kuchirka@pnu.edu.ua', 'PNU2024026'),
('Мазурик Михайло Олегович', 'mykhaylo.mazuryk@pnu.edu.ua', 'PNU2024027'),
('Мацків Андрій Ярославович', 'andriy.matskiv@pnu.edu.ua', 'PNU2024028'),
('Наумець Дмитро Андрійович', 'dmytro.naumets@pnu.edu.ua', 'PNU2024029'),
('Новоселецький Богдан Богданович', 'bohdan.novoseletskyy@pnu.edu.ua', 'PNU2024030'),
('Олексюк Артур Ігорович', 'artur.oleksyuk@pnu.edu.ua', 'PNU2024031'),
('Павлюк Віталій Юрійович', 'vitaliy.pavlyuk@pnu.edu.ua', 'PNU2024032'),
('Палій Христина Володимирівна', 'khrystyna.paliy@pnu.edu.ua', 'PNU2024033'),
('Пліхтяк Микола Петрович', 'mykola.plikhtyak@pnu.edu.ua', 'PNU2024034'),
('Прокоп\'юк Денис Михайлович', 'denys.prokopyuk@pnu.edu.ua', 'PNU2024035'),
('Руденко Наталія Олександрівна', 'nataliya.rudenko@pnu.edu.ua', 'PNU2024036'),
('Турчин Любов Любомирівна', 'lyubov.turchyn@pnu.edu.ua', 'PNU2024037'),
('Федик Діана Михайлівна', 'diana.fedyk@pnu.edu.ua', 'PNU2024038'),
('Федів Станіслав Романович', 'stanislav.fediv@pnu.edu.ua', 'PNU2024039'),
('Фецяк Микола Ігорович', 'mykola.fetsyak@pnu.edu.ua', 'PNU2024040'),
('Чабан Руслан Ігорович', 'ruslan.chaban@pnu.edu.ua', 'PNU2024041'),
('Часовников Юрій Анатолійович', 'yuriy.chasovnykov@pnu.edu.ua', 'PNU2024042'),
('Юрків Андрій Віталійович', 'andriy.yurkiv@pnu.edu.ua', 'PNU2024043');

-- ============================================================================
-- Вставка зв'язків (Many-to-Many)
-- Демонстрація того, що студенти записані на різні курси
-- ============================================================================
INSERT INTO enrollments (student_id, course_id) VALUES
-- Веб-програмування (курс 1) - всі студенти
(1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1), (7, 1), (8, 1), (9, 1), (10, 1),
(11, 1), (12, 1), (13, 1), (14, 1), (15, 1), (16, 1), (17, 1), (18, 1), (19, 1), (20, 1),
(21, 1), (22, 1), (23, 1), (24, 1), (25, 1), (26, 1), (27, 1), (28, 1), (29, 1), (30, 1),
(31, 1), (32, 1), (33, 1), (34, 1), (35, 1), (36, 1), (37, 1), (38, 1), (39, 1), (40, 1),
(41, 1), (42, 1), (43, 1),

-- Бази даних (курс 2) - парні студенти
(2, 2), (4, 2), (6, 2), (8, 2), (10, 2), (12, 2), (14, 2), (16, 2), (18, 2), (20, 2),
(22, 2), (24, 2), (26, 2), (28, 2), (30, 2), (32, 2), (34, 2), (36, 2), (38, 2), (40, 2),
(42, 2),

-- ООП (курс 3) - непарні студенти
(1, 3), (3, 3), (5, 3), (7, 3), (9, 3), (11, 3), (13, 3), (15, 3), (17, 3), (19, 3),
(21, 3), (23, 3), (25, 3), (27, 3), (29, 3), (31, 3), (33, 3), (35, 3), (37, 3), (39, 3),
(41, 3), (43, 3),

-- Алгоритми (курс 4) - кожен третій студент
(1, 4), (4, 4), (7, 4), (10, 4), (13, 4), (16, 4), (19, 4), (22, 4), (25, 4), (28, 4),
(31, 4), (34, 4), (37, 4), (40, 4), (43, 4),

-- REST API (курс 5) - студенти з ID > 20
(21, 5), (22, 5), (23, 5), (24, 5), (25, 5), (26, 5), (27, 5), (28, 5), (29, 5), (30, 5),
(31, 5), (32, 5), (33, 5), (34, 5), (35, 5), (36, 5), (37, 5), (38, 5), (39, 5), (40, 5),
(41, 5), (42, 5), (43, 5);
