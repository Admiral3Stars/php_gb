<!-- 1. Объявить две целочисленные переменные $a и $b и задать им произвольные начальные значения. Затем написать скрипт, который работает по следующему принципу:
если $a и $b положительные, вывести их разность;
если $а и $b отрицательные, вывести их произведение;
если $а и $b разных знаков, вывести их сумму;
ноль можно считать положительным числом. -->

<?php
    class first{
        private int $resut;

        public function __construct(int $a = 0, int $b = 0){
            if ($a >= 0 && $b >= 0){
                $this->result = $a - $b;
            }else if ($a < 0 && $b < 0){
                $this->result = $a * $b;
            }else{
                $this->result = $a + $b;
            }
        }
    }

    $first = new first(-5 , 7);
    echo $first->result . "<br>";
?>

<!-- 2. Присвоить переменной $а значение в промежутке [0..15] (произвольное значение при помощи rand). С помощью оператора switch организовать вывод чисел от $a до 15. -->

<?php
    class second{
        private $number;

        public function __construct(){
            $this->number = rand(0, 15);
        }

        public function render(){
            switch($this->number){
                case 0:
                    echo "Ноль";
                    break;
                case 1:
                    echo "Один";
                    break;
                case 2:
                    echo "Два";
                    break;
                case 3:
                    echo "Три";
                    break;
                case 4:
                    echo "Четыре";
                    break;
                case 5:
                    echo "Пять";
                    break;
                case 6:
                    echo "Шесть";
                    break;
                case 7:
                    echo "Семь";
                    break;
                case 8:
                    echo "Восемь";
                    break;
                case 9:
                    echo "Девять";
                    break;
                case 10:
                    echo "Десять";
                    break;
                case 11:
                    echo "Одинадцать";
                    break;
                case 12:
                    echo "Двенадцать";
                    break;
                case 13:
                    echo "Тринадцать";
                    break;
                case 14:
                    echo "Четырнадцать";
                    break;
                case 15:
                    echo "Пяднадцать";
                    break;
                default:
                    echo "Потому что, потому";
                    break;
            }
            echo "<br>";
        }
    }

    $second = new second;
    $second->render();
?>

<!-- 3. Реализовать основные 4 арифметические операции в виде функций с двумя параметрами. Обязательно использовать оператор return. -->

<?php

    function addition(float $a, float $b): float{
        return $a - $b;
    }
    function difference(float $a, float $b): float{
        return $a + $b;
    }
    function multiplication(float $a, float $b): float{
        return $a * $b;
    }
    function division(float $a, float $b): float{
        return $a / $b;
    }

    function calc(string $do, float $a, float $b){
        $calc = ["addition" => $a - $b, "difference" => $a + $b, "multiplication" => $a * $b, "division" => $a / $b,];
        return array_key_exists($do, $calc) ? $calc[$do] : "Вы можете использовать следующие действия: addition | difference | multiplication | division. Например: calc(\"addition\", 2, 0.98);";
    }

    echo addition(0.54, 2) . "<br>";
    echo calc("multiplication", 2, 1.5) . "<br>";

?>

<!-- 4. Реализовать функцию с тремя параметрами: function mathOperation($arg1, $arg2, $operation), где $arg1, $arg2 – значения аргументов, $operation – строка с названием операции. В зависимости от переданного значения операции выполнить одну из арифметических операций (использовать функции из пункта 3) и вернуть полученное значение (использовать switch). -->

<?php
    function mathOperation(float $arg1, float $arg2, string $operation){
        # Упускаем break; из-за наличия return в действиях условного оператор. После return функция прекращает свою работу.
        # Если будете выводить через переменную $result = $arg1 - $arg2;, то следующая строка обязательно должна быть break;
        switch($operation){
            case "addition":
                return $arg1 - $arg2;
            case "difference":
                return $arg1 + $arg2;
            case "multiplication":
                return $arg1 * $arg2;
            case "division":
                return $arg1 / $arg2;
            default:
                return "Вы можете использовать следующие действия: addition | difference | multiplication | division. Например: mathOperation(2, 0.98, \"addition\");";
        }
    }

    echo mathOperation(2, -7, "difference") . "<br>";
?>

<!-- 5. Посмотреть на встроенные функции PHP. Используя имеющийся HTML шаблон, вывести текущий год в подвале при помощи встроенных функций PHP. -->

<?php
    echo date("Y");
?>
    <br>

<!-- 6. *С помощью рекурсии организовать функцию возведения числа в степень. Формат: function power($val, $pow), где $val – заданное число, $pow – степень. Учитывайте степень 0 и отрицательную степень. -->

<?php
    function userPow(float $val, float $pow): float{
        if ($val == 0){
            return 0;
        }else if ($pow == 0){
            return 1;
        }else if ($pow < 0){
            return userPow(1 / $val, -$pow);
        }else{
            return $val * userPow($val, $pow-1);
        }
    }

    echo userPow(100, -2) . "<br>";
?>

<!-- 7. *Написать функцию, которая вычисляет текущее время и возвращает его в формате с правильными склонениями, например:
22 часа 15 минут
21 час 43 минуты -->

<?php
    $hNow = date("H");
    $iNow = date("i");

    // $hNow = 22;
    // $iNow = 44;

    $h = $hNow . " час";
    $i = $iNow . " минут";

    if (($hNow > 4 && $hNow < 21) || $hNow == 0){
        $h .= "ов";
    }else if ($hNow % 10 > 1 && $hNow % 10 < 5){
        $h .= "а";
    }

    if (($iNow < 5 || $iNow > 20) && ($iNow % 10 != 0 && $iNow % 10 < 5)){
        if ($iNow % 10 == 1){
            $i .= "а";
        }else{
            $i .= "ы";
        }
    }

    echo "$h $i";
    
?>