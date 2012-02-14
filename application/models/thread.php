<?php

class Thread extends Eloquent {

	public static $table = 'threads';
	public static $timestamps = true;

	public function forum()
	{
		return $this->belongs_to('forum');
	}

}