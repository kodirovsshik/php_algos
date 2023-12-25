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
    public $height;

    public function __construct($val = NAN)
    {
        $this->val = $val;
        $this->left = null;
        $this->right = null;
        $this->height = 1;
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

    public function get_balance_factor()
    {
        $leftHeight = node_height($this->left);
        $rightHeight = node_height($this->right);
        return $leftHeight - $rightHeight;
    }

    public function update_local_height()
    {
        $leftHeight = node_height($this->left);
        $rightHeight = node_height($this->right);
        $this->height = max($leftHeight, $rightHeight) + 1;
    }
}

function node_height($n)
{
    return is_null($n) ? 0 : $n->height;
}


function tree_rotate_right($y)
{
    $x = $y->left;
    $T2 = $x->right;

    $x->right = $y;
    $y->left = $T2;

    $y->update_local_height();
    $x->update_local_height();

    return $x;
}

function tree_rotate_left($x)
{
    $y = $x->right;
    $T2 = $y->left;

    $y->left = $x;
    $x->right = $T2;

    $x->update_local_height();
    $y->update_local_height();

    return $y;
}
function balance_tree(&$root)
{
    if ($root === null)
        return null;

    $root->update_local_height();
    $balancing = $root->get_balance_factor();

    if ($balancing > 1) {
        // Left subtree is taller
        if ($root->left->get_balance_factor() < 0)
            // Left-Right case
            $root->left = tree_rotate_left($root->left);
        // Left-Left case
        $root = tree_rotate_right($root);
    } elseif ($balancing < -1) {
        // Right subtree is taller
        if ($root->right->get_balance_factor() > 0) {
            // Right-Left case
            $root->right = tree_rotate_right($root->right);
        }
        // Right-Right case
        $root = tree_rotate_left($root);
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
    if (is_null($root)) {
        $root = new node($val);
        return;
    }

    if ($val < $root->val)
        insert_tree($root->left, $val);
    else
        insert_tree($root->right, $val);

    $root->update_local_height();
    balance_tree($root);
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
    if ($root === null)
        return;

    if ($val < $root->val)
        delete_tree_val($root->left, $val);
    else if ($val > $root->val)
        delete_tree_val($root->right, $val);
    else if ($root->left === null || $root->right === null) {
        $child = ($root->left !== null) ? $root->left : $root->right;
        $root = $child;
    } else {
        $mingreater = find_leftmost($root->right);
        $root->val = $mingreater->val;
        delete_tree_val($root->right, $mingreater->val);
    }

    if ($root !== null)
        balance_tree($root);
}

function find_leftmost($current)
{
    while ($current->left !== null) {
        $current = $current->left;
    }
    return $current;
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
$deletee = 5;

$tree_info = function () use (&$tree, $deletee) {
    print_tree($tree);
    echo is_null($tree) ? "[]" : $tree, "\n";
    echo "Поиск значения $deletee: ", (int) search_tree($tree, $deletee), "\n";
};



echo "Создание сбалансированного двоичного дерева\n\n";
foreach ($vals as $val)
    insert_tree($tree, $val);

$tree_info();



echo "\nУдаление элемента $deletee\n\n";
delete_tree_val($tree, $deletee);

$tree_info();



echo "\nУдаление дерева\n\n";
delete_tree($tree);

$tree_info();



echo "\n";

