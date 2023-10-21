<?php

namespace Otus\ex10_AVL;

abstract class Visitor
{
	abstract public function visit(Node $node);
}
