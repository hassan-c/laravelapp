<?php

class Comment extends Eloquent {

	public static $table = 'comments';

	public function post()
	{
		return $this->belongs_to('Post');
	}
	
}