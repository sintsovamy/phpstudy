<?php

abstract class HumanAbstract
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    abstract public function getGreetings(): string;
    abstract public function getMyNameIs(): string;

    public function introduceYourself()
    {
        echo $this->getGreetings() . '! ' . $this->getMyNameIs() . ' ' . $this->getName() . '.' . "<br>";
    }
}

class RussianHuman extends HumanAbstract
{
    public function getGreetings(): string
    {
        return 'Привет';

    }

    public function getMyNameIs(): string
    {
       return 'Меня зовут ';
    }	
}

class EnglishHuman extends HumanAbstract
{
    public function getGreetings(): string
    {
        return 'Hello';

    }

    public function getMyNameIs(): string
    {
        return 'My name is ';
    }
}


$human1 = new RussianHuman('Иван');
$human2 = new EnglishHuman('John');
$human1->introduceYourself();
$human2->introduceYourself();

