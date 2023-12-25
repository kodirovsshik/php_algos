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
	public $left, $right;

	public function __construct($val = NAN)
	{
		$this->val = $val;
	}

	public function __toString()
	{
		$result = "";

		$result .= "[";
		$result .= $this->val;
		$result .= ", ";
		$result .= nodeToStr($this->right);
		$result .= ", ";
		$result .= nodeToStr($this->left);
		$result .= "]";

		return $result;
	}
}

function nodeToStr($n)
{
	if (is_null($n))
		return "[]";
	return (string) $n;
}

function traverse_tree($root, $callable, $level = 0)
{
	if (is_null($root))
		return;
	traverse_tree($root->right, $callable, $level + 1);
	$callable($root, $level);
	traverse_tree($root->left, $callable, $level + 1);
}

function print_trie($root, $l = 0)
{
    traverse_tree(
        $root,
        function ($n, $l) {
            $x = $n->val;
            if ($x === null)
                $x = "x";
            echo str_repeat("    ", $l);
            echo $x, "\n";
        }
    );
    return;

    if ($root === null)
        return;

    print_trie($root->right, $l + 1);
	if ($root->val !== null)
    {
        echo str_repeat("    ", $l);
        echo $root->val, "\n";
    }
    print_trie($root->left, $l + 1);
}

function insert_trie(&$root, $val, $bits = null)
{
	if ($bits === null)
		$bits = $val;

    if ($root === null)
		$root = new node(null);

	if ($bits == 0)
    {
		$root->val = $val;
		return;
    }

    $newbits = $bits >> 1;
	if ($bits & 1)
		insert_trie($root->right, $val, $newbits);
	else
		insert_trie($root->left, $val, $newbits);
}

function count_tree_pred($root, $callable)
{
	$c = 0;
	traverse_tree(
		$root,
		function ($n, $l) use (&$c, $callable) {
			$c += $callable($n, $l);
		}
	);
	return $c;
}
function tree_size($root)
{
	return count_tree_pred($root, function ($n, $l) {
		return 1;
	});
}
function search_tree($root, $val)
{
	if (is_null($root))
		return false;
	if ($root->val == $val)
		return true;
	if ($val < $root->val)
		return search_tree($root->left, $val);
	else
		return search_tree($root->right, $val);
}
function delete_trie_val(&$root, $val)
{
	if (is_null($root))
		return;

	if ($root->val == $val) {
        $root->val = null;
        return;
	}

	if ($val < $root->val)
		delete_trie_val($root->left, $val);
	else
		delete_trie_val($root->right, $val);
}
function delete_tree(&$root)
{
	if (is_null($root))
		return;
	delete_tree($root->left);
	delete_tree($root->right);
	$root = null;
}



$tree = null;
$vals = [3, 2, 7, 5, 4, 8, 9, 6];
$deletee = 7;

$tree_info = function () use (&$tree, $deletee) {
	print_trie($tree);
	echo "Поиск значения $deletee: ", (int) search_tree($tree, $deletee), "\n";
};



echo "Создание поразрадного дерева\n\n";
foreach ($vals as $val)
	insert_trie($tree, $val);

$tree_info();



echo "\nУдаление элемента $deletee\n\n";
delete_trie_val($tree, $deletee);

$tree_info();



echo "\nУдаление дерева\n\n";
delete_tree($tree);

$tree_info();



echo "";

