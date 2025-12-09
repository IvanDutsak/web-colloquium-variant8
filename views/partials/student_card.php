<?php
/**
 * Partial: student_card.php
 * 
 * Демонстрація DRY принципу - переиспользуемий компонент для відображення інформації про студента
 * Використовується на кількох сторінках без дублювання коду
 * 
 * Параметри:
 * - $student: об'єкт Student
 * - $showCourses: чи показувати список курсів (опціонально)
 */

$courseCount = $student->getCourseCount();
?>

<div class="card">
    <h3><?php echo htmlspecialchars($student->name); ?></h3>
    
    <p style="color: #666; margin-bottom: 10px;">
        <strong>Email:</strong> <?php echo htmlspecialchars($student->email); ?>
    </p>
    
    <p style="color: #666; margin-bottom: 10px;">
        <strong>Номер студента:</strong> <?php echo htmlspecialchars($student->student_number); ?>
    </p>
    
    <p style="color: #667eea; font-weight: bold; margin-bottom: 15px;">
        📚 Курсів записано: <span style="font-size: 18px;"><?php echo $courseCount; ?></span>
    </p>
    
    <div style="display: flex; gap: 10px;">
        <a href="index.php?action=student&id=<?php echo $student->id; ?>" class="btn btn-small">
            Переглянути деталі
        </a>
    </div>
    
    <?php if (isset($showCourses) && $showCourses && $courseCount > 0): ?>
        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
            <strong>Записані курси:</strong>
            <ul style="margin-top: 10px; margin-left: 20px;">
                <?php foreach ($student->getCourses() as $course): ?>
                    <li><?php echo htmlspecialchars($course->name); ?> (викладач: <?php echo htmlspecialchars($course->instructor); ?>)</li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
