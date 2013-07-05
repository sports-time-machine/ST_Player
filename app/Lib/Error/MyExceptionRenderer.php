<?php
class MyExceptionRenderer extends ExceptionRenderer {
	public function __construct(Exception $exception) {
		parent::__construct($exception);
		$this->controller->layout = 'myerror';
	}
}