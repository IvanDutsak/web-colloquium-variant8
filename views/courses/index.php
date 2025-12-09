<?php
/**
 * Сторінка: Список всіх курсів
 * 
 * Демонструє:
 * - Використання layout для DRY (уникнення дублювання HTML)
 * - Використання partials для переиспользуемих компонентів
 */

$title = 'Курси';
$action = 'courses';

// Отримання загальної статистики
$totalCourses = count($courses);
$totalStudents = 0;
foreach ($courses as $course) {
    $totalStudents += $course->getStudentCount();
}

// Початок буферизації контенту
ob_start();
?>

<div class="stats">
    <div class="stat-box">
        <div class="number"><?php echo $totalCourses; ?></div>
        <div class="label">Всього курсів</div>
    </div>
    <div class="stat-box">
        <div class="number"><?php echo $totalStudents; ?></div>
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
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        <?php foreach ($courses as $course): ?>
            <?php 
            // Використання partial для відображення кожного курсу (DRY принцип)
            $showStudents = false;
            require __DIR__ . '/../partials/course_card.php'; 
            ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
$contentFile = __FILE__;
require_once __DIR__ . '/../layout.php';
?>
