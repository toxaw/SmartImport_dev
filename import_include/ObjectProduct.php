<?php
class ObjectProduct
{
	private $id, $importId;

	private $brand, $model, $brandModel;

	private $price, $purchasingPrice, $count;

	public function __construct($id)
	{
		$this->id = (string)$id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setImportId($importId)
	{
		$this->importId = $importId;
	}

	public function getImportId()
	{
		return $this->importId;
	}

	public function setBrand($brand)
	{
		$this->brand = (string)$brand;
	}

	public function getBrand()
	{
		return $this->brand;
	}

	public function setModel($model)
	{
		$this->model = (string)$model;
	}

	public function getModel()
	{
		return $this->model;
	}

	public function setBrandModel($brandModel)
	{
		$this->brandModel = (string)$brandModel;
	}

	public function getBrandModel()
	{
		return $this->brandModel;
	}

	public function setPrice($price)
	{
		$this->price = intval($price);
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function setPurchasingPrice($purchasingPrice)
	{
		$this->purchasingPrice = intval($purchasingPrice);
	}

	public function getPurchasingPrice()
	{
		return $this->purchasingPrice;
	}

	public function setCount($count)
	{
		$this->count = intval($count);
	}

	public function getCount()
	{
		return $this->count;
	}				
}