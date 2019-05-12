<?php

return new class extends Import implements iImport
{	
	private $shops;
	
	public function __construct()
	{
		$this->shops = 
		[
			'641'	=> true,
			'668'	=> true
		];
	}

	public function before($file)
	{

	}

	public function getItems($file)
	{
		return $file->wheels->wheel;
	}

	public function getFormatItem($item)
	{
		// формирование цены для клиента и количество

		$price = intval($item['retail_price']);

		$count = 0;

		if (!($price > 0)) 
		{
			$price = intval($item['price']) * 1.1;
		}

		foreach ($item->shop_stock->qty as $shop) 
		{
			if (isset($this->shops[intval($shop['shop_id'])])) 
			{
				$count += intval($shop['stock']);
			}
		}

		// ингорирование, если нет цены или количества

		if (!($price > 0 && $count > 0))
		{
			return false;
		}
		
		//ид

		$objectWheel = new ObjectWheel($item['sku']);

		// цена
		
		$objectWheel->setPrice($price);

		// количество

		$objectWheel->setCount($count);

		// закупчная цена

		$objectWheel->setPurchasingPrice($item['price']);

		// бренд

		$objectWheel->setBrand($item['brand']);

		// модель

		$objectWheel->setModel($item['model']);

		//отдельно ширины и даметра нет - будем ковырять

		$size = explode('/', $item['size']);			

		$width = floatval(str_replace(',', '.', trim(str_replace(['J', 'j'], '', $size[1]))));

		$diameter = floatval(str_replace(',', '.', trim($size[0])));
		
		// ширина диска

		$objectWheel->setWidth($width);
		
		// диаметр обода

		$objectWheel->setDiameter($diameter);

		// число крепежных отверстий

		$objectWheel->setBoltsCount($item['bp']);

		// диаметр расположения крепежных отверстий

		$objectWheel->setBoltsSpacing($item['pcd']);

		// диаметр расположения крепежных отверстий 2

		$objectWheel->setBoltsSpacing2($item['pcd2']);

		// диаметр центрального отверстия

		$objectWheel->setDia($item['centerbore']);

		// вылет диска

		$objectWheel->setEt($item['et']);

		// код цвета диска

		$objectWheel->setColor($item['color']);

		return $objectWheel;
	}
};
