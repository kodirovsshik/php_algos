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
function sorted_run_length($arr, $l, $r)
{
	$i = 0;
	for ($i = $l + 1; $i < $r; ++$i)
		if ($arr[$i - 1] > $arr[$i])
			break;
	return $i - $l;
}
function merge_sort(&$arr)
{
	$n = count($arr);
    $m = sorted_run_length($arr, 0, $n);
	while ($m < $n)
    {
        $l = sorted_run_length($arr, $m, $n);
        merge($arr, 0, $m + $l, $m);
        $m += $l;
    }
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