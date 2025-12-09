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
            <a href="index.php?action=courses" class="back-link">← Повернутися до списку курсів</a>

            <div class="card" style="margin: 20px 0;">
                <h2><?php echo htmlspecialchars($course->name); ?></h2>
                
                <p style="color: #666; margin: 15px 0;">
                    <strong>Опис:</strong><br>
                    <?php echo nl2br(htmlspecialchars($course->description)); ?>
                </p>
                
                <p style="color: #666; margin: 15px 0;">
                    <strong>Викладач:</strong> <?php echo htmlspecialchars($course->instructor); ?>
                </p>
                
                <p style="color: #667eea; font-weight: bold; margin: 15px 0;">
                    👥 Студентів на курсі: <span style="font-size: 20px;"><?php echo $course->getStudentCount(); ?></span>
                </p>
            </div>

            <h3>📚 Студенти на цьому курсі</h3>

            <?php if (empty($students)): ?>
                <div class="empty-state">
                    <p>На цьому курсі немає записаних студентів</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Ім'я</th>
                            <th>Email</th>
                            <th>Номер студента</th>
                            <th>Дія</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student->name); ?></td>
                                <td><?php echo htmlspecialchars($student->email); ?></td>
                                <td><?php echo htmlspecialchars($student->student_number); ?></td>
                                <td>
                                    <a href="index.php?action=student&id=<?php echo $student->id; ?>" class="btn btn-small">
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
