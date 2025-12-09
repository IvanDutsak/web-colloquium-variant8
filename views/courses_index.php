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
                    <div class="number"><?php echo count($courses); ?></div>
                    <div class="label">Всього курсів</div>
                </div>
                <div class="stat-box">
                    <div class="number">
                        <?php 
                        $totalEnrollments = 0;
                        foreach ($courses as $course) {
                            $totalEnrollments += $course->getStudentCount();
                        }
                        echo $totalEnrollments;
                        ?>
                    </div>
                    <div class="label">Записів студентів</div>
                </div>
            </div>

            <h2>📖 Всі курси</h2>

            <?php if (empty($courses)): ?>
                <div class="empty-state">
                    <p>Немає жодного курсу в системі</p>
                    <p style="font-size: 12px; color: #999;">Спочатку додайте курси до бази даних</p>
                </div>
            <?php else: ?>
                <div class="grid">
                    <?php foreach ($courses as $course): ?>
                        <div class="card">
                            <h3><?php echo htmlspecialchars($course->name); ?></h3>
                            <p class="description"><?php echo htmlspecialchars($course->description); ?></p>
                            <div class="meta">
                                <span>👨‍🏫 <?php echo htmlspecialchars($course->instructor); ?></span>
                                <span>👥 <?php echo $course->getStudentCount(); ?> студентів</span>
                            </div>
                            <a href="index.php?action=course&id=<?php echo $course->id; ?>" class="btn">
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
