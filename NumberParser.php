#!/usr/local/bin/php
<?php

function is_full_numeric($val){
    $reg = "/^-?\\d+([\\.|,|x]\\d+)?$/ui";        //т.к. в русском языке символ ',' используется в качестве разделителя между
    if (preg_match($reg, $val)) return true;  //целой и дробной частью, производим проверку  и на ','
    return false;
}

function comma_to_dot($val){                             //но т.к. PHP не понимает дробные числа, разделённые запятой,
    return str_ireplace(",", ".", $val);  //заменяем её на точку
}

$fileIn = __DIR__."/in.txt";
$fileOut = __DIR__."/out.txt";

if (!file_exists($fileIn) || filesize($fileIn) == 0) exit;  //завершаем скрипт, если файла нет или файл пуст

$f = fopen($fileIn, 'r');

while (($line = fgets($f)) !== false)
    if (is_full_numeric(trim($line))) $numbers[] = comma_to_dot(trim($line));   #trim() вызывается для того, что бы отсечь все пробельные символы,
# включая сивол переноса строки
fclose($f);


if (is_null($numbers)) exit; //если чисел не найдено, то и продолжать скрипт бесполезно

$numbers = array_count_values($numbers);   #Считаем повторения чисел

arsort($numbers);    #тут происходит сортировка

$f = fopen($fileOut, 'a');

foreach ($numbers as $num=>$count){
    fwrite($f, "$num - $count".PHP_EOL);
    echo "$num - $count".PHP_EOL;
}

fclose($f);
?>
