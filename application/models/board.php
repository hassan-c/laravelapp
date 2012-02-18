<?php

class Board extends Eloquent {

	public static $table = 'boards';

	public function forums()
	{
		return $this->has_many('Forum');
	}

}