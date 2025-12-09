<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тест підключення до БД</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background: #667eea;
            color: white;
        }
        h1 {
            color: #333;
        }
    </style>
</head>
<body>
    <h1>🔍 Тест підключення до бази даних</h1>
    
    <?php
    require_once __DIR__ . '/config/config.php';
    
    echo '<div class="info">';
    echo '<strong>Налаштування підключення:</strong><br>';
    echo 'Host: ' . DB_HOST . '<br>';
    echo 'Database: ' . DB_NAME . '<br>';
    echo 'User: ' . DB_USER . '<br>';
    echo 'Password: ' . (DB_PASS ? '***' : '(порожній)') . '<br>';
    echo '</div>';
    
    try {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        
        echo '<div class="success">';
        echo '✅ <strong>Підключення до бази даних успішне!</strong>';
        echo '</div>';
        
        // Перевірка таблиць
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        
        echo '<h2>📋 Таблиці в базі даних:</h2>';
        if (empty($tables)) {
            echo '<div class="error">❌ Таблиць не знайдено! Імпортуйте файл init_clean.sql</div>';
        } else {
            echo '<ul>';
            foreach ($tables as $table) {
                echo '<li>' . htmlspecialchars($table) . '</li>';
            }
            echo '</ul>';
        }
        
        // Перевірка даних у таблицях
        if (in_array('courses', $tables)) {
            echo '<h2>📚 Курси в базі даних:</h2>';
            $courses = $pdo->query("SELECT * FROM courses")->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($courses)) {
                echo '<div class="error">❌ Таблиця courses порожня! Імпортуйте файл init_clean.sql</div>';
            } else {
                echo '<table>';
                echo '<tr><th>ID</th><th>Назва</th><th>Викладач</th></tr>';
                foreach ($courses as $course) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($course['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($course['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($course['instructor']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        }
        
        if (in_array('students', $tables)) {
            echo '<h2>👥 Студенти в базі даних:</h2>';
            $students = $pdo->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($students)) {
                echo '<div class="error">❌ Таблиця students порожня! Імпортуйте файл init_clean.sql</div>';
            } else {
                echo '<table>';
                echo '<tr><th>ID</th><th>Ім\'я</th><th>Email</th><th>Номер студента</th></tr>';
                foreach ($students as $student) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($student['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($student['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($student['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($student['student_number']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        }
        
        if (in_array('enrollments', $tables)) {
            echo '<h2>🔗 Записи студентів на курси:</h2>';
            $enrollments = $pdo->query("SELECT COUNT(*) as count FROM enrollments")->fetch(PDO::FETCH_ASSOC);
            
            if ($enrollments['count'] == 0) {
                echo '<div class="error">❌ Таблиця enrollments порожня! Імпортуйте файл init_clean.sql</div>';
            } else {
                echo '<div class="success">✅ Знайдено ' . $enrollments['count'] . ' записів</div>';
            }
        }
        
        echo '<div class="info">';
        echo '<strong>Що робити далі:</strong><br>';
        if (empty($tables) || empty($courses) || empty($students)) {
            echo '1. Відкрийте phpMyAdmin<br>';
            echo '2. Виберіть базу даних "course_management"<br>';
            echo '3. Перейдіть на вкладку "Import"<br>';
            echo '4. Виберіть файл <strong>init_clean.sql</strong> (НЕ init.sql!)<br>';
            echo '5. Натисніть "Go"<br>';
            echo '6. Оновіть цю сторінку';
        } else {
            echo '✅ Все готово! Перейдіть на <a href="index.php">головну сторінку</a>';
        }
        echo '</div>';
        
    } catch (PDOException $e) {
        echo '<div class="error">';
        echo '❌ <strong>Помилка підключення до бази даних:</strong><br>';
        echo htmlspecialchars($e->getMessage());
        echo '<br><br><strong>Можливі причини:</strong><br>';
        echo '1. MySQL не запущений (перевірте XAMPP Control Panel)<br>';
        echo '2. Неправильний пароль (перевірте config/config.php)<br>';
        echo '3. База даних не створена (створіть базу "course_management" в phpMyAdmin)';
        echo '</div>';
    }
    ?>
    
    <p style="margin-top: 30px; text-align: center; color: #999;">
        <a href="index.php">← Повернутися на головну</a>
    </p>
</body>
</html>
