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
		return $file->product;
	}

	public function getFormatItem($item)
	{
		// формирование цены для клиента и количество

		$price = intval($item->rs);

		$count = intval(str_replace('более ', '', $item->StockRostov));

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

		$objectTire = new ObjectTire($item->atricle);

		// цена
		
		$objectTire->setPrice($price);

		// количество

		$objectTire->setCount($count);

		// закупчная цена

		$objectTire->setPurchasingPrice($item->price);

		// бренд

		$objectTire->setBrand($item->producer);

		// модель

		$objectTire->setModel($item->model);

		// ширина

		$objectTire->setWidth($item->width);

		// высота

		$objectTire->setHeight($item->h);
		
		// диаметр

		$objectTire->setDiameter(str_replace(array('R', 'C'), '', $item->radius));

		// индекс скорости

		$objectTire->setLoadIndex($item->li);
		
		// индекс нагрузки

		$objectTire->setSpeedIndex($item->ss);

		// шипованность

		if((string)$item->stud == 'Y')
		{
			$objectTire->setIsPin();
		}

		return $objectTire;
	}
};
