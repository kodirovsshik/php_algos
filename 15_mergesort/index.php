<?php

function swap(&$x, &$y)
{
	$tmp = $x;
	$x = $y;
	$y = $tmp;
}

function merge(&$arr, $l, $r, $m)
{
    $sorted = array();

    $i = $l;
    $j = $m;
    while ($i < $m && $j < $r) {
        if ($arr[$i] < $arr[$j])
            $sorted[] = $arr[$i++];
        else
            $sorted[] = $arr[$j++];
    }
    while ($i < $m)
        $sorted[] = $arr[$i++];
    while ($j < $r)
        $sorted[] = $arr[$j++];
    for ($i = $l; $i < $r; ++$i)
        $arr[$i] = $sorted[$i - $l];
}
function merge_sort(&$arr, $l = 0, $r = null)
{
    if ($r === null)
        $r = count($arr);
    if ($r - $l <= 1)
        return;

	$m = intdiv($l + $r, 2);
	merge_sort($arr, $l, $m);
	merge_sort($arr, $m, $r);
    merge($arr, $l, $r, $m);
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
merge_sort($array);

echo "Отсортированный массив:\n";
foreach ($array as $element) {
	echo $element, " ";
}
echo "";