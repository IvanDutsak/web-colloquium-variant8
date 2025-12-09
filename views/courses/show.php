<?php
/**
 * Сторінка: Деталі курсу
 * 
 * Демонструє:
 * - Many-to-Many зв'язок (курс має багато студентів)
 * - Використання методів моделі для отримання пов'язаних даних
 */

$title = 'Курс: ' . htmlspecialchars($course->name);
$action = 'course';
$contentFile = __FILE__;

if (basename($_SERVER['PHP_SELF']) === 'index.php') {
    ob_start();
?>

<a href="index.php?action=courses" style="margin-bottom: 20px; display: inline-block;">← Повернутися до списку курсів</a>

<div class="card" style="margin-bottom: 30px;">
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

<?php
    $content = ob_get_clean();
    require_once __DIR__ . '/../layout.php';
}
?>
