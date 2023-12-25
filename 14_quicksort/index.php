<?php

function swap(&$x, &$y)
{
    $tmp = $x;
    $x = $y;
    $y = $tmp;
}

function partition_2way(&$arr, $b, $e, $x)
{
    $mid1 = $b;
    $i = $b;
    while ($i < $e)
    {
        if ($arr[$i] < $x)
            swap($arr[$i], $arr[$mid1++]);
        $i++;
    }

    $mid2 = $mid1;
    $i = $mid1;
    while ($i < $e)
    {
        if ($arr[$i] <= $x)
            swap($arr[$i], $arr[$mid2++]);
        $i++;
    }

    return [$mid1, $mid2];
}

function quick_sort(&$arr, $l = 0, $r = null)
{
    if ($r === null)
        $r = count($arr);

    if ($l == $r)
        return;
    $mid = $arr[intdiv($r + $l, 2)];
    [$mid1, $mid2] = partition_2way($arr, $l, $r, $mid);
    quick_sort($arr, $l, $mid1);
    quick_sort($arr, $mid2, $r);
}

function read($prompt)
{
    echo $prompt;
    return rtrim(fgets(STDIN));
}
function read_array($prompt)
{
    return explode(' ', read($prompt));
}

$array = read_array("Введите массив:\n");
quick_sort($array);

echo "Отсортированный массив:\n";
foreach ($array as $element) {
    echo $element, " ";
}
echo "";