<?php

namespace Otus\ex18_Vertex;

interface Visitable
{
	public function accept(Visitor $visitor): void;
}
