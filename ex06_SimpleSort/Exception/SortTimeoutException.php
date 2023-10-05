<?php

namespace Otus\ex06_SimpleSort\Exception;

class SortTimeoutException extends \Exception
{
	protected $message = 'Timeout';
	protected $code = 'timeout';
}