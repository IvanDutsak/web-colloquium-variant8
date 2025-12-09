<?php
/**
 * Модель Enrollment - Таблиця зв'язку для Many-to-Many
 * 
 * Демонструє:
 * - Успадкування від Model
 * - Таблиця зв'язку для реалізації Many-to-Many
 * - Статичний метод create для зручного створення зв'язків
 */

class Enrollment extends Model {
    protected static $table = 'enrollments';
    
    /**
     * Статичний метод для створення зв'язку між студентом та курсом
     * 
     * Демонструє DRY принцип - повторне використання коду
     * Замість дублювання логіки в кількох місцях, використовуємо один метод
     */
    public static function create($studentId, $courseId) {
        $enrollment = new self([
            'student_id' => $studentId,
            'course_id' => $courseId,
            'enrolled_at' => date('Y-m-d H:i:s')
        ]);
        
        return $enrollment->save();
    }
    
    /**
     * Отримання дати запису студента на курс
     */
    public function getEnrolledAt() {
        return $this->attributes['enrolled_at'] ?? null;
    }
    
    /**
     * Отримання студента цього запису
     */
    public function getStudent() {
        return Student::find($this->attributes['student_id']);
    }
    
    /**
     * Отримання курсу цього запису
     */
    public function getCourse() {
        return Course::find($this->attributes['course_id']);
    }
}
