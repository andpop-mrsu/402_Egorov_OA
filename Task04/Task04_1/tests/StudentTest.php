<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Student;

class StudentTest extends TestCase
{

    public function testTextRepresentation()
    {
        $s1 = new Student();
        $s1 -> setName("Валерий") -> setLastName("Жмышенко") -> setFaculty("ФМиИТ") -> setCourse(2) -> setGroup(208);
        $this -> assertSame(
            "Id: 1" . "\n" .
            "Фамилия: Жмышенко" . "\n" .
            "Имя: Валерий" . "\n" .
            "Факультет: ФМиИТ" . "\n" .
            "Курс: 2" . "\n" .
            "Группа: 208",
            $s1 -> __toString()
        );
    }

    public function testGetFuntions()
    {
        $s1 = new Student();
        $s1 -> setName("Валерий") -> setLastName("Жмышенко") -> setFaculty("ФМиИТ") -> setCourse(2) -> setGroup(208);
        $this ->  assertSame("Валерий", $s1 -> getName());
        $this ->  assertSame("Жмышенко", $s1 -> getLastName());
        $this ->  assertSame("ФМиИТ", $s1 -> getFaculty());
        $this ->  assertSame(2, $s1 -> getCourse());
        $this ->  assertSame(208, $s1 -> getGroup());
    }
}