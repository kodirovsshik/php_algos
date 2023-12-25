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

function print_tree($root)
{
    traverse_tree(
        $root,
        function ($n, $l) {
            echo str_repeat("    ", $l);
            echo $n->val, "\n";
        }
    );
}

function insert_tree(&$root, $val)
{
    return insert_tree_subtree($root, new node($val));
}
function insert_tree_subtree(&$root, $subtree)
{
    if (is_null($root)) {
        $root = $subtree;
        return;
    }

    if ($subtree->val < $root->val)
        return insert_tree_subtree($root->left, $subtree);
    else
        return insert_tree_subtree($root->right, $subtree);
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
function delete_tree_val(&$root, $val)
{
    if (is_null($root))
        return;
    if ($root->val == $val) {
        $l = $root->left;
        $r = $root->right;
        if (is_null($l))
            swap($l, $r);
        $root = $l;
        if (!is_null($r))
            insert_tree_subtree($root, $r);
        return;
    }

    if ($val < $root->val)
        return delete_tree_val($root->left, $val);
    else
        return delete_tree_val($root->right, $val);
}
function delete_tree(&$root)
{
    if (is_null($root))
        return;
    delete_tree($root->left);
    delete_tree($root->right);
    $root = null;
}

function create_optimal_tree($arr, $b = 0, $e = null)
{
    if (is_null($e))
        $e = sizeof($arr);

    $n = $e - $b;
    if ($n <= 0)
        return null;

    $m = (int)(($b + $e) / 2);
    $n = new node($arr[$m]);
    $n->left = create_optimal_tree($arr, $b, $m);
    $n->right = create_optimal_tree($arr, $m + 1, $e);
    return $n;
}



$tree = null;
$vals = [3, 2, 7, 5, 4, 8, 9, 6];
$deletee = 7;

$tree_info = function () use (&$tree, $deletee) {
    print_tree($tree);
    echo is_null($tree) ? "[]" : $tree, "\n";
    echo "Поиск значения $deletee: ", (int) search_tree($tree, $deletee), "\n";
};



echo "Создание оптимального дерева\n\n";
sort($vals);
$tree = create_optimal_tree($vals);

$tree_info();



echo "\nУдаление элемента $deletee\n\n";
delete_tree_val($tree, $deletee);

$tree_info();



echo "\nУдаление дерева\n\n";
delete_tree($tree);

$tree_info();



echo "";
