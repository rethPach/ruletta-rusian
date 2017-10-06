<?php

class Player
{
	public function __construct($name)
	{
		$this->name = $name;
		$this->die = false;
	}

	protected function setName($name)
	{
		$size = strlen($name);
		if(!($size >= 2 && $size <= 15)) 
			throw new Exception("BadPlayerName");
		
		$this->name = $name;
	}

	public function shotInYourHead(Armor $armor)
	{
		if($this->die) return;
		if($armor->trigger() === 'b') $this->die = true;
	}

	public function isDie()
	{
		return $this->die;
	}

	public function isLive()
	{
		return !$this->isDie();
	}

	public function toScore()
	{
		return $this->name;
	}
}