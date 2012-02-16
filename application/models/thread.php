<?php

class Thread extends Eloquent {

	public static $table = 'threads';
	public static $timestamps = true;

	public function replies()
	{
		return $this->has_many('Reply');
	}

}