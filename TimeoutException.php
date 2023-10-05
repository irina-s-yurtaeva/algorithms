<?php

namespace Otus;

class TimeoutException extends \Exception
{
	protected $message = 'Timeout';
	protected $code = 'timeout';
}