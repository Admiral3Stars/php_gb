<!-- 1. Установить программное обеспечение: веб-сервер, базу данных, интерпретатор, текстовый редактор и проверить, что всё работает правильно.-->

<!-- Установлено, всё работает корректно -->

<!-- 2. Выполнить примеры из методички, разобраться, как это работает. -->

<?php
    echo "Hello, World!<br>"; // выводит текст
?>
<?php
    $name = "GeekBrains user"; // записывает текст в переменную нейм
    echo "Hello, $name!<br>"; // Выводит текст и значение переменной нейм
?>
<?php
    define('MY_CONST', 100); // создаёт константу и записывает в неё значение 100
    echo MY_CONST . "<br>"; // Выводит значение константы
?>
<?php
    /* Просто записывает значения в переменные. Сами значения в 10тиричной, 2ичной, 8ричной и 16ричной системах счисления. php самое типизирует данные, поэтому на выводе мы получим 42 везде. Если бы нужен был string, то стоило бы поставить кавычки и записать значение в них ' '. С плавающей точкой всё тоже самое. */
    $int10 = 42;
    $int2 = 0b101010;
    $int8 = 052;
    $int16 = 0x2A;
    echo "Десятеричная система $int10 <br>"; 
    echo "Двоичная система $int2 <br>";
    echo "Восьмеричная система $int8 <br>";
    echo "Шестнадцатеричная система $int16 <br>";
?>

<?php
    $precise1 = 1.5;
    $precise2 = 1.5e4;
    $precise3 = 6E-8;
    echo "$precise1 | $precise2 | $precise3 <br>";
?>

<?php
    $a = 1;
    echo "$a"; // 1
    echo '$a<br>'; // $a. Одинарные кавычки не позволяют выводить значение переменных, только текстовую информацию. Кстати, хоть я и не любитель одинарных кавычек и привык экранизировать двойные, но тем не менее использование оных может добавить безопасности к работе приложений, так как не позволит выводить значения переменных, которые могут содержать в себе не только простые типы данных.
?>

<?php
    $a = 10;
    $b = 10; // вот определил
    $b = (boolean) $b; // Вот не надо так определять переменную, так как если будет вывод ошибок включен, то получите Warning: Undefined variable. Использовать для переопределения типа только. Хотя может они в методичке опечатались и вместо $b указали $a, иначе нахрена она тут вообще? Возьму и сам определю $b выше)
    var_dump($b);
?>

<?php
    $a = 'Hello,';
    $b = 'world';
    $c = $a . $b; // конкатинация. Тоже что вверху, только со значениями переменных и с последующей записей в новую переменную.
    echo $c . "<br>"; // Выведет Hello world
?>

<!-- ну тут всё понятно и без комментариев я думаю. ЕСЛИ КОПИРОВАТЬ ИЗ МЕТОДЫ НЕ РАБОТАЕТ код, потому что метода написана с кучей ошибок. я смог найти 5 штук (это я бегло смотрел) Написал в чат GB_PHP об этом -->
<?php
    $a = 4;
    $b = 5;
    echo $a + $b . '<br>';
    echo $a * $b . '<br>';
    echo $a - $b . '<br>';
    echo $a / $b . '<br>';
    echo $a % $b . '<br>';
    echo $a ** $b . '<br>';
?>

<!-- Это тоже работать не будет, если скопируете с методички. Жесть какая-то а не методичка. Новички, которые не знают как установить open server должны сталкиваться с проблемами лишними -->

<?php
    $a = 4;
    $b = 5;
    $a += $b;
    echo 'a = ' . $a . '<br>';
    $a = 0;
    echo $a++; // Постинкремент снача выводит, потом прибавляет
    echo ++$a; // Преинкремент сначала прибавляет, потом выводит
    echo $a--; // Постдекремент тоже но с вычитанием
    echo --$a; // Предекремент тоже но с вычитанием

?>

<?php
    $a = 4;
    $b = 5;
    var_dump($a == $b);  // Сравнение по значению
    var_dump($a === $b); // Сравнение по значению и типу
    var_dump($a > $b);    // Больше
    var_dump($a < $b);    // Меньше
    var_dump($a <> $b);  // Не равно
    var_dump($a != $b);   // Не равно
    var_dump($a !== $b); // Не равно без приведения типов
    var_dump($a <= $b);  // Меньше или равно
    var_dump($a >= $b);  // Больше или равно
?>

<!-- 3. Объяснить, как работает данный код: -->
<?php
    $a = 5; // присваиваем 5 переменной a
    $b = '05'; // присваиваем текст переменной b
    var_dump($a == $b); // Почему true? потому что при сравнении приводит типы данных к единому (для сравнения), при этом сами типы не сравнивает Поэтому 5 = 5 и вот вам трай
    var_dump((int)'012345');     // Почему 12345? потому что тип указали число, а в нём 0 впереди убирается
    var_dump((float)123.0 === (int)123.0); // Почему false? Потому что 3 равно и идёт сравнение типов. Типы данных разные, фот вам и фолс
    var_dump((int)0 === (int)'hello, world'); // Почему true? нет числа в тексте, значит 0 при приведении! 0 и 0 равны.
?>
<!-- 4. Используя имеющийся HTML-шаблон, сделать так, чтобы главная страница генерировалась через PHP. Создать блок переменных в начале страницы. Сделать так, чтобы h1, title и текущий год генерировались в блоке контента из созданных переменных. -->

<!-- Я не знаю где там имеющийся php шаблон, но код будет примерно таким:  -->
<?php
    class pages{
        public $title = "Имя страницы";
        public $header = "Заголовок";
        public $year = "2000";

        public function __construct($title, $header){
            $this->title = $title;
            $this->header = $header;
            $this->year = date("Y");
        }
    }

    $page = new pages("Сайт домашних работ", "Работа номер 1 Geek Brains PHP1");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$page->title ?></title>
</head>
<body class="site">
    <header class="site-header"></header>
    <main class="site-content">
        <h1 class="content-header"><?=$page->header ?></h1>
    </main>
    <footer class="site-footer"><?=$page->year ?></footer>
</body>
</html>

<!-- 5. *Используя только две переменные, поменяйте их значение местами. Например, если a = 114, b = 2, надо, чтобы получилось: b = 114, a = 2. Дополнительные переменные использовать нельзя. -->

<?php
    class items{
        public $a = 114;
        public $b = 2;

        public function __construct($a, $b){
            $a = $a - $b;
            $b = $a + $b;
            $a = $b - $a;

            $this->a = $a;
            $this->b = $b;
        }
    }

    $item = new items(4, 7);
    var_dump($item);
?>