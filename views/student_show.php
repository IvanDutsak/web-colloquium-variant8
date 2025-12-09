<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> - Course Management System</title>
    <link rel="stylesheet" href="views/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>📚 Course Management System</h1>
            <p>Система управління курсами та студентами</p>
        </header>
        
        <nav>
            <a href="index.php?action=courses">📖 Курси</a>
            <a href="index.php?action=students">👥 Студенти</a>
        </nav>
        
        <main>
            <a href="index.php?action=students" class="back-link">← Повернутися до списку студентів</a>

            <div class="card" style="margin: 20px 0;">
                <h2><?php echo htmlspecialchars($student->name); ?></h2>
                
                <p style="color: #666; margin: 15px 0;">
                    <strong>Email:</strong> <?php echo htmlspecialchars($student->email); ?>
                </p>
                
                <p style="color: #666; margin: 15px 0;">
                    <strong>Номер студента:</strong> <?php echo htmlspecialchars($student->student_number); ?>
                </p>
                
                <p style="color: #667eea; font-weight: bold; margin: 15px 0;">
                    📚 Записаних курсів: <span style="font-size: 20px;"><?php echo $student->getCourseCount(); ?></span>
                </p>
            </div>

            <h3>📖 Курси студента</h3>

            <?php if (empty($courses)): ?>
                <div class="empty-state">
                    <p>Студент не записаний на жодний курс</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Назва курсу</th>
                            <th>Викладач</th>
                            <th>Студентів на курсі</th>
                            <th>Дія</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($course->name); ?></td>
                                <td><?php echo htmlspecialchars($course->instructor); ?></td>
                                <td><?php echo $course->getStudentCount(); ?></td>
                                <td>
                                    <a href="index.php?action=course&id=<?php echo $course->id; ?>" class="btn btn-small">
                                        Переглянути
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </main>
        
        <footer>
            <p>© 2025 Course Management System | Варіант 8: Зв'язки між сутностями та DRY принцип</p>
        </footer>
    </div>
</body>
</html>
