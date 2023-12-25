<?php
function heap_sort(&$arr)
{
	$n = count($arr);

	for ($i = (int) ($n / 2) - 1; $i >= 0; $i--) {
		heapify($arr, $n, $i);
	}

    echo "Куча:\n";
    foreach ($arr as $element) {
        echo $element, " ";
    }
    echo "\n";

    for ($i = $n - 1; $i >= 0; $i--) {
		$temp = $arr[0];
		$arr[0] = $arr[$i];
		$arr[$i] = $temp;

		heapify($arr, $i, 0);
	}
}

function heapify(&$arr, $n, $i)
{
	$largest = $i;
	$left = 2 * $i + 1;
	$right = 2 * $i + 2;
	if ($left < $n && $arr[$left] > $arr[$largest]) {
		$largest = $left;
	}

	if ($right < $n && $arr[$right] > $arr[$largest]) {
		$largest = $right;
	}

	if ($largest != $i) {
		$temp = $arr[$i];
		$arr[$i] = $arr[$largest];
		$arr[$largest] = $temp;

		heapify($arr, $n, $largest);
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
heap_sort($array);

echo "Отсортированный массив:\n";
foreach ($array as $element) {
	echo $element, " ";
}
echo "";