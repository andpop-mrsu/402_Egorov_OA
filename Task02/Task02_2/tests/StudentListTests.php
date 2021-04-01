<?php

use PHPUnit\Framework\TestCase;
use App\StudentList;
use App\Student;

class StudentListTests extends TestCase
{
    public function testGet()
    {
        $student = new Student();
        $studentsList = new StudentList();
        $student -> setName("Кирилл") -> setSurname("Байшев") -> setFaculty("Юридический") -> setCourse(4) -> setGroup(404);
        $studentsList -> add($student);
        $this -> assertInstanceOf(Student::class, $studentsList -> get(1));
    }

    public function test_studentList_storing_isCorrect()
    {
        $student = new Student();
        $studentsList = new StudentList();
        $student -> setName("Алексей") -> setSurname("Маханов") -> setFaculty("Математический")-> setCourse(1) -> setGroup(101);
        $studentsList -> add($student);
        $this -> assertSame(null, $studentsList -> store("output"));
    }

    public function test_studentList_file_isCorrect()
    {
        $studentsList = new StudentList();
        $studentsList -> load("output");
        $this -> assertSame(1, $studentsList -> count());
        $this -> assertInstanceOf(Student::class, $studentsList -> get(1));
        $this -> assertSame("Файл fileName не существует!", $studentsList -> load("fileName"));
    }
} 