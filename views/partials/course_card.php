<?php
/**
 * Partial: course_card.php
 * 
 * Демонстрація DRY принципу - переиспользуемий компонент для відображення інформації про курс
 * Використовується на кількох сторінках без дублювання коду
 * 
 * Параметри:
 * - $course: об'єкт Course
 * - $showStudents: чи показувати список студентів (опціонально)
 */

$studentCount = $course->getStudentCount();
?>

<div class="card">
    <h3><?php echo htmlspecialchars($course->name); ?></h3>
    
    <p style="color: #666; margin-bottom: 10px;">
        <strong>Опис:</strong> <?php echo htmlspecialchars($course->description); ?>
    </p>
    
    <p style="color: #666; margin-bottom: 10px;">
        <strong>Викладач:</strong> <?php echo htmlspecialchars($course->instructor); ?>
    </p>
    
    <p style="color: #667eea; font-weight: bold; margin-bottom: 15px;">
        👥 Студентів записано: <span style="font-size: 18px;"><?php echo $studentCount; ?></span>
    </p>
    
    <div style="display: flex; gap: 10px;">
        <a href="index.php?action=course&id=<?php echo $course->id; ?>" class="btn btn-small">
            Переглянути деталі
        </a>
    </div>
    
    <?php if (isset($showStudents) && $showStudents && $studentCount > 0): ?>
        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
            <strong>Студенти на курсі:</strong>
            <ul style="margin-top: 10px; margin-left: 20px;">
                <?php foreach ($course->getStudents() as $student): ?>
                    <li><?php echo htmlspecialchars($student->name); ?> (<?php echo htmlspecialchars($student->email); ?>)</li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>
