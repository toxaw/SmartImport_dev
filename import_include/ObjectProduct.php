<?php
class ObjectTire
{
	private $id;

	private $brand, $model;

	private $price, $purchasingPrice, $count;

	public function __construct($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setBrand($brand)
	{
		$this->brand = $brand;
	}

	public function getBrand()
	{
		return $this->brand;
	}

	public function setModel($model)
	{
		$this->model = $model;
	}

	public function getModel()
	{
		return $this->model;
	}

	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function setPurchasingPrice($purchasingPrice)
	{
		$this->purchasingPrice = $purchasingPrice;
	}

	public function getPurchasingPrice()
	{
		return $this->purchasingPrice;
	}

	public function setCount($count)
	{
		$this->count = $count;
	}

	public function getCount()
	{
		return $this->count;
	}				
}