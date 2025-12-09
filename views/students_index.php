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
            <a href="index.php?action=courses" class="<?php echo $currentAction === 'courses' ? 'active' : ''; ?>">
                📖 Курси
            </a>
            <a href="index.php?action=students" class="<?php echo $currentAction === 'students' ? 'active' : ''; ?>">
                👥 Студенти
            </a>
        </nav>
        
        <main>
            <div class="stats">
                <div class="stat-box">
                    <div class="number"><?php echo count($students); ?></div>
                    <div class="label">Всього студентів</div>
                </div>
                <div class="stat-box">
                    <div class="number">
                        <?php 
                        $totalEnrollments = 0;
                        foreach ($students as $student) {
                            $totalEnrollments += $student->getCourseCount();
                        }
                        echo $totalEnrollments;
                        ?>
                    </div>
                    <div class="label">Записів на курси</div>
                </div>
            </div>

            <h2>👥 Всі студенти</h2>

            <?php if (empty($students)): ?>
                <div class="empty-state">
                    <p>Немає жодного студента в системі</p>
                    <p style="font-size: 12px; color: #999;">Спочатку додайте студентів до бази даних</p>
                </div>
            <?php else: ?>
                <div class="grid">
                    <?php foreach ($students as $student): ?>
                        <div class="card">
                            <h3><?php echo htmlspecialchars($student->name); ?></h3>
                            <p class="description">
                                <strong>Email:</strong> <?php echo htmlspecialchars($student->email); ?><br>
                                <strong>Номер студента:</strong> <?php echo htmlspecialchars($student->student_number); ?>
                            </p>
                            <div class="meta">
                                <span>📚 <?php echo $student->getCourseCount(); ?> курсів</span>
                            </div>
                            <a href="index.php?action=student&id=<?php echo $student->id; ?>" class="btn">
                                Переглянути деталі →
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
        
        <footer>
            <p>© 2025 Course Management System | Варіант 8: Зв'язки між сутностями та DRY принцип</p>
        </footer>
    </div>
</body>
</html>
