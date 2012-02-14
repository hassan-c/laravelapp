<?php

class Comment extends Eloquent {

	public static $table = 'comments';

	public function posts()
	{
		return $this->belongs_to('Post');
	}
	
}