<?php

class Reply extends Eloquent {

	public static $table = 'replies';
	public static $timestamps = true;

	public function thread()
	{
		return $this->belongs_to('Thread');
	}
	
}