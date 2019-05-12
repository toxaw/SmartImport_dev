<?php

return new class extends Import implements iImport
{
	public function __construct()
	{

	}

	public function before($file)
	{

	}

	public function getItems($file)
	{
		return $file->rims;
	}

	public function getFormatItem($item)
	{
		// формирование цены для клиента и количество

		$count = intval(str_replace('более ', '', $item->rest_rostovND));

		$price = intval($item->price_rostovND_rozn);

		$purchasingPrice = intval($item->price_rostovND);

		if (!$count)
		{
			$count = intval(str_replace('более ', '', $item->rest_sk6));

			$price = intval($item->price_sk6_rozn);

			$purchasingPrice = intval($item->price_sk6);
		}

		//если нет цены то расчитываем через формулу из закупочной

		if(!($price > 0))
		{
			$price = intval($purchasingPrice) * 1.1;
		}

		// ингорирование, если нет цены или количества

		if (!($price > 0 && $count > 0))
		{
			return false;
		}
		
		//ид

		$objectWheel = new ObjectWheel($item->cae);

		// цена
		
		$objectWheel->setPrice($price);

		// количество

		$objectWheel->setCount($count);

		// закупчная цена

		$objectWheel->setPurchasingPrice($purchasingPrice);

		// бренд

		$objectWheel->setBrand($item->brand);

		// модель

		$objectWheel->setModel($item->model);

		// ширина диска

		$objectWheel->setWidth($item->width);
		
		// диаметр обода

		$objectWheel->setDiameter($item->diameter);

		// число крепежных отверстий

		$objectWheel->setBoltsCount($item->bolts_count);

		// диаметр расположения крепежных отверстий

		$objectWheel->setBoltsSpacing($item->bolts_spacing);

		// диаметр расположения крепежных отверстий 2

		$objectWheel->setBoltsSpacing2($item->bolts_spacing2);

		// диаметр центрального отверстия

		$objectWheel->setDia($item->dia);

		// вылет диска

		$objectWheel->setEt($item->et);

		// код цвета диска

		$objectWheel->setColor($item->color);

		return $objectWheel;
	}
};
