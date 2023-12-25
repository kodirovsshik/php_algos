<?php
function shell_sort(&$arr)
{
    $n = count($arr);
    $gap = (int) ($n / 2);
    while ($gap > 0) {
        for ($i = $gap; $i < $n; $i++) {
            $temp = $arr[$i];
            $j = $i;

            while ($j >= $gap && $arr[$j - $gap] > $temp) {
                $arr[$j] = $arr[$j - $gap];
                $j -= $gap;
            }

            $arr[$j] = $temp;
        }

        $gap = (int) ($gap / 2);
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
shell_sort($array);

echo "Отсортированный массив:\n";
foreach ($array as $element) {
    echo $element, " ";
}
echo "";