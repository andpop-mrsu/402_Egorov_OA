<?php

use PHPUnit\Framework\TestCase;
use App\Student;

class StudentTests extends TestCase
{
    public function test_student_getFunctions_isCorrect()
    {
        $student = new Student();
        $student -> setName("Иван") -> setSurname("Иванов") -> setFaculty("Экономический") -> setCourse(2) -> setGroup(201) -> __toString();
        $this ->  assertSame("Иван", $student -> getName());
        $this ->  assertSame("Иванов", $student -> getSurname());
        $this ->  assertSame("Экономический", $student -> getFaculty());
        $this ->  assertSame(2, $student -> getCourse());
        $this ->  assertSame(201, $student -> getGroup());
    }
}