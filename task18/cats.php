<?php
class Cat
{
    private $name;
    private $color;

    public function __construct(string $name, string $color)
    {
	$this->name = $name;
        $this->color = $color;
    }

    public function sayHello()
    {
        echo 'Привет! Меня зовут ' . $this->name . '.' . '<br>';
	echo 'Цвет моей шерсти ' . $this->color . '.' . '<br>';
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setColor(string $name)
    {
        $this->color = $color;
    }

    public function getColor(): string
    {
        return $this->color;
    }
}

$cat1 = new Cat('Барсик', 'Чёрный');
$cat2 = new Cat('Снежок', 'Белый');
$cat3 = new Cat('Барсик', 'Рыжий');
$cat1->sayHello();
$cat2->sayHello();
$cat3->sayHello();

