<?php

class Home_Controller extends Controller {

	public function action_index()
	{
		$view = View::make('home.index');
		$view->title = 'Home &raquo; Laravel App';
		$view->heading = 'Laravel App';

		return $view;
	}

}