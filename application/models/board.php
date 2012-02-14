<?php

class Board extends Eloquent {

	public static $table = 'boards';

	public function boards()
	{
		return $this->has_many('Forum');
	}

}