<?php

//class Cat {
//
//    private $name;
//    private $color;
//
//    public function __construct(string $name, string $color) {
//        $this->name = $name;
//        $this->color = $color;
//    }
//
//    public function setColor(string $color) {
//        $this->color = $color;
//    }
//
//    public function getColor(): string {
//        return $this->color;
//    }
//
//
//    public function sayHello(){
//        echo 'Hello, my name is ' . $this->name . '. Im ' . $this->color;
//    }
//}
//
//$cat1 = new Cat('Barsik', 'black');
//$cat2 = new Cat('John', 'white');
//
//var_dump($cat1);
//var_dump($cat2);
//
//$cat1->sayHello();
//
//echo $cat2->getColor();
//$cat1->setColor('red');
//echo $cat1->getColor();

//class Post {
//    private $title;
//    private $text;
//
//    public function __construct(string $title, string $text) {
//        $this->title = $title;
//        $this->text = $text;
//    }
//
//    public function getTitle()
//    {
//        return $this->title;
//    }
//
//    public function setTitle($title)
//    {
//        $this->title = $title;
//    }
//
//    public function getText()
//    {
//        return $this->text;
//    }
//
//    public function setText($text)
//    {
//        $this->text = $text;
//    }
//}
//
//class Lesson extends Post {
//    private $homework;
//
//    public function __construct(string $title, string $text, string $homework)
//    {
//        parent::__construct($title, $text);
//        $this->homework = $homework;
//    }
//
//    public function getHomework(): string
//    {
//        return $this->homework;
//    }
//
//    public function setHomework(string $homework)
//    {
//        $this->homework = $homework;
//    }
//}
//
//class PaidLesson extends Lesson {
//    private $price;
//
//    public function __construct(string $title, string $text, string $homework, float $price)
//    {
//        parent::__construct($title, $text, $homework);
//        $this->price = $price;
//    }
//
//    public function getPrice() {
//        return $this->price;
//    }
//
//    public function setPrice(float $price) {
//        $this->price = $price;
//    }
//}
//
//$lesson = new PaidLesson('Title', 'Text', 'Homework', 99.00);
//echo $lesson->getPrice();
//$lesson->setPrice(100);
//echo $lesson->getPrice() . " ";
//
//var_dump($lesson);

//interface CalculateSquare {
//    public function calculateSquare(): float;
//}
//
//class Rectangle {
//    private $x;
//    private $y;
//
//    public function __construct(float $x, float $y)
//    {
//        $this->x = $x;
//        $this->y = $y;
//    }
//
//    public function calculateSquare(): float {
//        return $this->x * $this->y;
//    }
//}
//
//class Square implements CalculateSquare
//{
//    private $x;
//
//    public function __construct(float $x)
//    {
//        $this->x = $x;
//    }
//
//    public function calculateSquare(): float
//    {
//        return $this->x ** 2;
//    }
//}
//
//class Circle implements CalculateSquare
//{
//    private $r;
//    const PI = 3.1416;
//
//    public function __construct(float $r)
//    {
//        $this->r = $r;
//    }
//
//    public function calculateSquare(): float
//    {
//        return self::PI * ($this->r ** 2);
//    }
//}
//
//$circle1 = new Circle(2.5);
//var_dump($circle1 instanceof CalculateSquare);
//
//$objects = [
//    new Square(5),
//    new Rectangle(2, 4),
//    new Circle(5)
//];
//
//foreach ($objects as $object) {
//    if($object instanceof CalculateSquare) {
//        echo 'Объект реализует интерфейс CalculateSquare класса ' . get_class($object). '. Площадь: ' . $object->calculateSquare();
//        echo '<br>';
//    }
//    else {
//        echo 'Объект класса ' . get_class($object) . ' не реализует интерфейс CalculateSquare.';
//        echo '<br>';
//    }
//}

//abstract class HumanAbs {
//    private $name;
//
//    public function __construct(string $name) {
//        $this->name = $name;
//    }
//
//    public function getName():string {
//        return $this->name;
//    }
//
//    public function setName(string $name): string {
//        return $this->name = $name;
//    }
//
//    abstract public function getGreetings();
//    abstract public function getMyNameIs();
//
//    public function introduceYourself() {
//        return $this->getGreetings() . '! ' . $this->getMyNameIs() . ' ' . $this->getName() . '.';
//    }
//}
//
//class RussianHuman extends HumanAbs {
//    public function getGreetings()
//    {
//        return 'Привет';
//    }
//    public function getMyNameIs()
//    {
//        return 'Меня зовут';
//    }
//}
//
//class EnglishHuman extends HumanAbs {
//    public function getGreetings()
//    {
//        return 'Hello';
//    }
//    public function getMyNameIs()
//    {
//        return 'My name is';
//    }
//}
//
//
//
//$human1 = new RussianHuman('Иван');
//$human2 = new EnglishHuman('Jack');
//
//echo $human1->introduceYourself();
//echo '<br>';
//echo $human2->introduceYourself();
//echo '<br>';
//$human1->setName('Даша');
//echo $human1->introduceYourself();

//class Human {
//    private static $count = 0;
//
//    public function __construct()
//    {
//        self::$count++;
//    }
//    public static function getCount(){
//        return self::$count;
//    }
//}
//
//echo 'Людей уже ' . Human::getCount();
//$human1 = new Human;
//$human2 = new Human;
//
//echo 'Людей уже ' . Human::getCount();

//require __DIR__ . '/../src/MyProject/Models/Articles/Article.php';
//require __DIR__ . '/../src/MyProject/Models/Users/User.php';



spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../src/' . str_replace('\\', '/', $className) . '.php';
});


$route = $_GET['route'] ?? '';
$routes = require __DIR__ . '/../src/routes.php';

$isRouteFound = false;
foreach ($routes as $pattern => $controllerAndAction) {
    preg_match($pattern, $route, $matches);
    if (!empty($matches)) {
        $isRouteFound = true;
        break;
    }
}

if (!$isRouteFound) {
    echo 'Страница не найдена!';
    return;
}

unset($matches[0]);

$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];

$controller = new $controllerName();
$controller->$actionName(...$matches);
