<?php

class fighter {
	public $position;
	public $type;
	public $speed;
	public $id;
	public $name;
	
	function __construct( $key, $title, $posx, $posy, $typ ) {
		$this -> position['x'] = $posx;
		$this -> position['y'] = $posy;
		$this -> type = $typ;
		$this -> id = $key;
		$this -> name = $title;
	}
}

?>