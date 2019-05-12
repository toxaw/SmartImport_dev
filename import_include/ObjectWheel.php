<?php
class ObjectWheel extends ObjectProduct
{
	private $width, $diameter, $boltsCount, $boltsSpacing, $boltsSpacing2, $dia, $et;

	private $color;

	public function setWidth($width)
	{
		$this->width =  floatval(str_replace(',', '.', $width));
	}

	public function getWidth()
	{
		return $this->width;
	}

	public function setDiameter($diameter)
	{
		$this->diameter =  floatval(str_replace(',', '.', $diameter));
	}

	public function getDiameter()
	{
		return $this->diameter;
	}

	public function setBoltsCount($boltsCount)
	{
		$this->boltsCount =  intval($boltsCount);
	}

	public function getBoltsCount()
	{
		return $this->boltsCount;
	}

	public function setBoltsSpacing($boltsSpacing)
	{
		$this->boltsSpacing =  floatval(str_replace(',', '.', $boltsSpacing));
	}

	public function getBoltsSpacing()
	{
		return $this->boltsSpacing;
	}

	public function setBoltsSpacing2($boltsSpacing2)
	{
		$this->boltsSpacing2 =  floatval(str_replace(',', '.', $boltsSpacing2));
	}

	public function getBoltsSpacing2()
	{
		return $this->boltsSpacing2;
	}

	public function setDia($dia)
	{
		$this->dia =  floatval(str_replace(',', '.', $dia));
	}

	public function getDia()
	{
		return $this->dia;
	}

	public function setEt($et)
	{
		$this->et =  floatval(str_replace(',', '.', $et));
	}

	public function getEt()
	{
		return $this->et;
	}

	public function setColor($color)
	{
		$this->color =  (string)$color;
	}

	public function getColor()
	{
		return $this->color;
	}	
}