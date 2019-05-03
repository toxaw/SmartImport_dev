<?php
class ObjectTire extends ObjectProduct
{
	private $width, $height, $diameter, $loadIndex, $speedIndex;

	private $isPin;

	public function setWidth($width)
	{
		$this->width = $width;
	}

	public function getWidth()
	{
		return $this->width;
	}

	public function setHeight($height)
	{
		$this->height = $height;
	}

	public function getHeight()
	{
		return $this->height;
	}

	public function setDiameter($diameter)
	{
		$this->diameter = $diameter;
	}

	public function getDiameter()
	{
		return $this->diameter;
	}

	public function setLoadIndex($loadIndex)
	{
		$this->loadIndex = $loadIndex;
	}

	public function getLoadIndex()
	{
		return $this->loadIndex;
	}

	public function setSpeedIndex($speedIndex)
	{
		$this->speedIndex = $speedIndex;
	}

	public function getSpeedIndex()
	{
		return $this->speedIndex;
	}

	public function setIsPin()
	{
		$this->isPin = true;
	}

	public function isPin()
	{
		return $this->isPin;
	}				
}