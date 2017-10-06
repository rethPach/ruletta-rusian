<?php

class RoulleteRusian
{
	
	public function __construct($cylinder, $startingCylinder, $startingPlayer, $players)
	{
		$this->armor = new Armor($cylinder, $startingCylinder);
		$this->setPlayers($players);
		$this->setStartingPlayer($startingPlayer, $players);
	}

	protected function setStartingPlayer($startingPlayer, $players)
	{
		$keyPlayerX = 'none';

		foreach ($players as $key => $player)
			if($player == $startingPlayer) $keyPlayerX = $key;

		if($keyPlayerX == 'none') 
			throw new Exception("player not found");

		/*if(!($keyPlayerX >= 2 && $keyPlayerX <= 15)) 
			throw new Exception("PlayerKeyIncorrect");*/

		$this->startingPlayer = $keyPlayerX;
	}

	protected function setPlayers($players)
	{
		$size = count($players);

		if(!($size >= 1 && $size <= 100)) 
			throw new Exception("PlayerNumberInvalid");

		$this->players = [];

		foreach ($players as $key => $player) {
			$this->players[] = new Player($player);
		}
			
	}

	public function play()
	{
		$i = $this->startingPlayer;

		while($this->armor->haveBullets() && $this->haveManyOnePlayerLive()) {
			$this->players[$i]->shotInYourHead($this->armor);
			$i = ($i + 1) % count($this->players);
		}

		return $this->score();
	}

	protected function haveManyOnePlayerLive()
	{
		$playersDie = count(array_filter($this->players, function($player) {
			return $player->isDie();
		}));

		return ( (count($this->players) - $playersDie ) > 1 );
	}

	protected function score()
	{
		$players = array_filter($this->players, function($player) {
			return $player->isLive();
		});

		$names = array_map(function($player) {
			return $player->toScore();
		}, $players);

		array_multisort($names);

		return $names;

	}
}