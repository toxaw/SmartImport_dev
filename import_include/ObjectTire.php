<?php
class ObjectTire extends ObjectProduct
{
	private $width, $height, $diameter, $loadIndex, $speedIndex;

	private $isPin;

	public function setWidth($width)
	{
		$this->width = (string)$width;
	}

	public function getWidth()
	{
		return $this->width;
	}

	public function setHeight($height)
	{
		$this->height = (string)$height;
	}

	public function getHeight()
	{
		return $this->height;
	}

	public function setDiameter($diameter)
	{
		$this->diameter = (string)$diameter;
	}

	public function getDiameter()
	{
		return $this->diameter;
	}

	public function setLoadIndex($loadIndex)
	{
		$this->loadIndex = (string)$loadIndex;
	}

	public function getLoadIndex()
	{
		return $this->loadIndex;
	}

	public function setSpeedIndex($speedIndex)
	{
		$this->speedIndex = (string)$speedIndex;
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