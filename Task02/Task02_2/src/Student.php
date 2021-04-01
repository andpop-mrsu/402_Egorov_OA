<?php
namespace App;

class Student
{
    private int $id;
    private string $surname;
    private string $name;
    private string $faculty;
    private int $course;
    private int $group;

    private static int $tempId = 1;

    public function __construct()
    {
        $this -> id = self::$tempId++;
    }

    public function setName(string $name)
    {
        $this -> name = $name;
        return $this;
    }

    public function setSurname(string $surname)
    {
        $this -> surname = $surname;
        return $this;
    }

    public function setFaculty(string $faculty)
    {
        $this -> faculty = $faculty;
        return $this;
    }

    public function setCourse(int $course)
    {
        $this -> course = $course;
        return $this;
    }

    public function setGroup(int $group)
    {
        $this -> group = $group;
        return $this;
    }

    public function getId(): int
    {
        return $this -> id;
    }

    public function getName(): string
    {
        return $this -> name;
    }

    public function getSurname(): string
    {
        return $this -> surname;
    }

    public function getFaculty(): string
    {
        return $this -> faculty;
    }

    public function getCourse(): int
    {
        return $this -> course;
    }

    public function getGroup(): int
    {
        return $this -> group;
    }

    public function __toString(): string
    {
        return ("Id студента {$this -> id}" . "\n" . "Фамилия студента {$this -> surname}" . "\n" .
        "Имя студента {$this -> name}" . "\n" . "Факультет {$this -> faculty}" . "\n" .
        "Курс {$this -> course}" . "\n" . "Группа  {$this -> group}");
    }
} 