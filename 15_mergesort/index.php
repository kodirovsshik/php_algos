<?php

function swap(&$x, &$y)
{
	$tmp = $x;
	$x = $y;
	$y = $tmp;
}

function merge(&$sorted, $b1, $b2)
{
    $n1 = count($b1);
    $n2 = count($b2);
    $i = 0;
    $j = 0;

    while ($i < $n1 && $j < $n2) {
        if ($b1[$i] < $b2[$j])
            $sorted[] = $b1[$i++];
        else
            $sorted[] = $b2[$j++];
    }
    while ($i < $n1)
        $sorted[] = $b1[$i++];
    while ($j < $n2)
        $sorted[] = $$b2[$j++];
}

function split($arr, &$a1, &$a2)
{
    $a1 = array();
    $a2 = array();

    $block = array();
    $last = -INF;
    for ($i = 0; $i < count($arr); ++$i)
    {
        $next = (int)$arr[$i];
        if ($next < $last)
        {
            $a1[] = $block;
            swap($a1, $a2);
            $block = array();
        }
        $block[] = $next;
        $last = $next;
    }
    $a1[] = $block;
}
function get_block($arr, $n)
{
    if (array_key_exists($n, $arr))
        return $arr[$n];
    return array();
}

function dump_block_array($a, $n, $iter)
{
    $fname = sprintf("f%d.%d.txt", $iter, $n);
    $f = fopen($fname, "w");
    foreach ($a as $block)
    {
        foreach ($block as $x)
            fprintf($f, "%g ", $x);
        fprintf($f, "' ");
    }
}
function dump_array($a, $iter)
{
    $fname = sprintf("f%d.txt", $iter + 1);
    $f = fopen($fname, "w");
    foreach ($a as $x)
        fprintf($f, "%g ", $x);
}
function merge_sort(&$arr, $iter = 1)
{
    $a1 = $a2 = null;
    split($arr, $a1, $a2);
    dump_block_array($a1, 1, $iter);
    dump_block_array($a2, 2, $iter);

    $n1 = count($a1);
    $n2 = count($a2);
    $arr = array();


    $n = max($n1, $n2);
    for ($i = 0; $i < $n; ++$i)
        merge($arr, get_block($a1, $i), get_block($a2, $i));

    if ($n1 * $n2 != 0)
    {
        dump_array($arr, $iter);
        merge_sort($arr, $iter + 1);
    }
}

function read($prompt)
{
	echo $prompt;
	return ;
}
function read_array($n)
{
    $fname = sprintf("f%d.txt", $n);
    $f = fopen($fname, "r");
    $s = rtrim(fgets($f));
	return explode(' ', $s);
}

$a = read_array(1);
merge_sort($a);
