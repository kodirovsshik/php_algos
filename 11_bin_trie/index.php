<?php

function swap(&$x, &$y)
{
	$tmp = $x;
	$x = $y;
	$y = $tmp;
}

class node
{
	public $val;
	public $next;

	public function __construct($val = false)
	{
		$this->val = $val;
		$this->next = array();
	}
}

function traverse_tree($root, $callable, $level = 0)
{
	if (is_null($root))
		return;
	$callable($root, $level);
	foreach ($root->next as $n)
		traverse_tree($n, $callable, $level + 1);
}

function print_trie($root, $l = 0, $s = "")
{
	if ($root === null)
		return;
	if ($root->val)
		echo str_repeat("    ", $l), $s, "\n";
	foreach ($root->next as $c => $n)
        print_trie($n, $l + 1, $s . $c);
}

function insert_trie(&$root, $val, $l = 0)
{
	if ($root === null)
		$root = new node();
	if ($l == strlen($val))
		$root->val = true;
	else
		insert_trie($root->next[$val[$l]], $val, $l + 1);
}
function search_trie($root, $val, $l = 0)
{
	if (is_null($root))
		return false;
	if ($l == strlen($val))
		return (bool)$root->val;
	return search_trie($root->next[$val[$l]], $val, $l + 1);
}
function delete_trie_val(&$root, $val, $l = 0)
{
	if ($root === null)
		return;
	if ($l == strlen($val))
		$root->val = false;
	else
		delete_trie_val($root->next[$val[$l]], $val, $l + 1);
}
function delete_trie(&$root)
{
	if (is_null($root))
		return;
	foreach ($root->next as $n)
		delete_trie($n);
	$root = null;
}



$tree = new node();
$vals = ["abcd", "abce", "a", "ac", "ab"];
$deletee = "ab";

$tree_info = function () use (&$tree, $deletee) {
	print_trie($tree);
	echo "Поиск значения $deletee: ", (int) search_trie($tree, $deletee), "\n";
};



echo "Создание бора\n\n";
foreach ($vals as $val)
	insert_trie($tree, $val);

$tree_info();



echo "\nУдаление элемента \"$deletee\"\n\n";
delete_trie_val($tree, $deletee);

$tree_info();



echo "\nУдаление бора\n\n";
delete_trie($tree);

$tree_info();



echo "";

