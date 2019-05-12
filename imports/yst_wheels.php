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
		return $file->disk;
	}

	public function getFormatItem($item)
	{
		// формирование цены для клиента и количество

		$price = intval($item->price_recomend_im);

		$count = intval(str_replace('более ', '', $item->restrnd));

		if (!($price > 0)) 
		{
			$price = intval($item->price) * 1.1;
		}
		
		// ингорирование, если нет цены или количества

		if (!($price > 0 && $count > 0))
		{
			return false;
		}
		
		//ид

		$objectWheel = new ObjectWheel($item->article);

		// цена
		
		$objectWheel->setPrice($price);

		// количество

		$objectWheel->setCount($count);

		// закупчная цена

		$objectWheel->setPurchasingPrice($item->price);

		// бренд

		$objectWheel->setBrand($item->brand);

		// модель

		$objectWheel->setModel($item->model);
		
		// ширина диска

		$objectWheel->setWidth($item->width);
		
		// диаметр обода

		$objectWheel->setDiameter($item->diametr);

		// число крепежных отверстий

		$objectWheel->setBoltsCount($item->bolts_count);

		// диаметр расположения крепежных отверстий

		$objectWheel->setBoltsSpacing($item->bolts_spacing);

		// диаметр расположения крепежных отверстий 2

		$objectWheel->setBoltsSpacing2(0);

		// диаметр центрального отверстия

		$objectWheel->setDia($item->dia);

		// вылет диска

		$objectWheel->setEt($item->et);

		// код цвета диска

		$objectWheel->setColor($item->color);

		return $objectWheel;
	}
};
