<?php

function read($prompt)
{
	echo $prompt;
	return readline();
}

function search_rightmost_char($s, $c, $i = 0)
{
    $n = strlen($s);
    $top = $n - 1;

	for (; $i < $top; ++$i)
        if ($s[$top - $i] == $c)
            break;
    return min($i, $top);
}

function search($s, $sub)
{
	$n = strlen($s);
	$nsub = strlen($sub);

	$i = $nsub - 1;
	$k = 0;
	while ($i < $n) {
		echo "$s\n";
		echo str_repeat(' ', $i - ($nsub - 1)), "$sub\n";
		echo str_repeat(' ', $i - $k), "^\n";

		$c = $s[$i - $k];
		if ($c == $sub[$nsub - 1 - $k])
        {
			$k++;
			if ($k != $nsub)
				continue;

			echo "Подстрока найдена на позиции ", $i - $nsub + 1, "\n";
            $k = 0;
            ++$i;
		}
		else
        {
			$i += search_rightmost_char($sub, $c, $k);
            $k = 0;
		}
	}
}


$s = read("Введите строку: ");
$sub = read("Введите подстроку: ");

search($s, $sub);

echo "";

