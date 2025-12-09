<?php
/**
 * Сторінка: Список всіх студентів
 * 
 * Демонструє:
 * - Використання layout для DRY
 * - Використання partials для переиспользуемих компонентів
 */

$title = 'Студенти';
$action = 'students';

// Отримання загальної статистики
$totalStudents = count($students);
$totalEnrollments = 0;
foreach ($students as $student) {
    $totalEnrollments += $student->getCourseCount();
}

ob_start();
?>

<div class="stats">
    <div class="stat-box">
        <div class="number"><?php echo $totalStudents; ?></div>
        <div class="label">Всього студентів</div>
    </div>
    <div class="stat-box">
        <div class="number"><?php echo $totalEnrollments; ?></div>
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
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        <?php foreach ($students as $student): ?>
            <?php 
            // Використання partial для відображення кожного студента (DRY принцип)
            $showCourses = false;
            require __DIR__ . '/../partials/student_card.php'; 
            ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
$contentFile = __FILE__;
require_once __DIR__ . '/../layout.php';
?>
