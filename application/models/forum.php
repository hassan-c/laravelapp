<?php

class Forum extends Eloquent {

	public static $table = 'forums';

	public function threads()
	{
		return $this->has_many('Thread');
	}

}