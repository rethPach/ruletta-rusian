<?php

class Armor
{
	public function __construct($cylinder, $startingCylinder)
	{
		$this->setCylinder($cylinder);
		$this->setStartingCylinder($startingCylinder);
	}

	public function setCylinder($cylinder)
	{
		$this->assertThatCylinderHaveBulletIntoRange(1, 1002, $cylinder);
		$this->assertThatCylinderIsAllBulletsValid($cylinder);
		$this->cylinder = $cylinder;
	}

	public function setStartingCylinder($startingCylinder)
	{
		$this->assertThatstartingCylinderIntoRange(0, 35, $startingCylinder);
		$this->startingCylinder = $startingCylinder;
	}


	protected function assertThatCylinderHaveBulletIntoRange($from, $to, $cylinder) {
		if($this->intoRango($from, $to, count($cylinder)))
			throw new Exception("BulletsInsuficientes");
	}

	protected function assertThatCylinderIsAllBulletsValid($cylinder) {
		$filters = array_filter($cylinder, function($bullet) {
			return in_array($bullet, ["b", "e"]);
		});

		if (count($cylinder) != count($filters))
			throw new Exception("BadBulletException");		
	}

	protected function intoRango($from, $to, $n)
	{
		return (!($n >= $from && $n <= $to));
	}

	protected function assertThatstartingCylinderIntoRange($from, $to, $startingCylinder) {
		if($this->intoRango($from, $to, $startingCylinder))
			throw new Exception("BulletsInsuficientes");
	}


	public function trigger()
	{
		$resultTrigger = $this->cylinder[$this->startingCylinder];
		$this->cylinder[$this->startingCylinder] = 'e';
		$this->startingCylinder = (
			($this->startingCylinder + 1) % count($this->cylinder)
		);
		return $resultTrigger;
	}

	public function haveBullets()
	{
		$bullets = array_filter($this->cylinder, function($bullet) {
			return $bullet == 'b';
		});

		return count($bullets) > 0;
	}
}
