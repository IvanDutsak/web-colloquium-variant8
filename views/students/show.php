<?php
/**
 * Сторінка: Деталі студента
 * 
 * Демонструє:
 * - Many-to-Many зв'язок (студент має багато курсів)
 * - Використання методів моделі для отримання пов'язаних даних
 */

$title = 'Студент: ' . htmlspecialchars($student->name);
$action = 'student';

ob_start();
?>

<a href="index.php?action=students" style="margin-bottom: 20px; display: inline-block;">← Повернутися до списку студентів</a>

<div class="card" style="margin-bottom: 30px;">
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

<?php
$content = ob_get_clean();
$contentFile = __FILE__;
require_once __DIR__ . '/../layout.php';
?>
