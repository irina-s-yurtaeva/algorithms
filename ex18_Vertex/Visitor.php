<?php

namespace Otus\ex18_Vertex;

abstract class Visitor
{
	abstract public function visit(Vertex|Edge $node);
}
