<?php
/**
 * Модель Student - Демонстрація Many-to-Many зв'язку
 * 
 * Зв'язок: Student (1) --- (Many) Enrollment --- (Many) Course
 * 
 * Демонструє:
 * - Успадкування від Model
 * - Many-to-Many зв'язок через таблицю enrollments
 * - Метод для отримання пов'язаних курсів
 */

class Student extends Model {
    protected static $table = 'students';
    
    /**
     * Отримання всіх курсів, на які записаний студент
     * 
     * Демонстрація Many-to-Many зв'язку:
     * - Студент має багато курсів
     * - Курс має багато студентів
     * - Зв'язок реалізується через таблицю enrollments
     */
    public function getCourses() {
        $db = Database::getInstance();
        
        $sql = '
            SELECT c.* FROM courses c
            INNER JOIN enrollments e ON c.id = e.course_id
            WHERE e.student_id = ?
            ORDER BY c.name ASC
        ';
        
        $records = $db->fetchAll($sql, [$this->attributes['id']]);
        
        $courses = [];
        foreach ($records as $record) {
            $courses[] = new Course($record);
        }
        
        return $courses;
    }
    
    /**
     * Отримання кількості курсів, на які записаний студент
     */
    public function getCourseCount() {
        $db = Database::getInstance();
        
        $sql = '
            SELECT COUNT(*) as count FROM enrollments
            WHERE student_id = ?
        ';
        
        $result = $db->fetchOne($sql, [$this->attributes['id']]);
        return $result['count'] ?? 0;
    }
    
    /**
     * Перевірка, чи записаний студент на конкретний курс
     */
    public function isEnrolledIn($courseId) {
        $db = Database::getInstance();
        
        $sql = '
            SELECT COUNT(*) as count FROM enrollments
            WHERE student_id = ? AND course_id = ?
        ';
        
        $result = $db->fetchOne($sql, [$this->attributes['id'], $courseId]);
        return $result['count'] > 0;
    }
    
    /**
     * Запис студента на курс
     */
    public function enrollInCourse($courseId) {
        if (!$this->isEnrolledIn($courseId)) {
            Enrollment::create($this->attributes['id'], $courseId);
        }
    }
    
    /**
     * Видалення студента з курсу
     */
    public function unenrollFromCourse($courseId) {
        $db = Database::getInstance();
        
        $sql = 'DELETE FROM enrollments WHERE student_id = ? AND course_id = ?';
        $db->execute($sql, [$this->attributes['id'], $courseId]);
    }
}
