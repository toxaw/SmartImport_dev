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
		return $file->tires;
	}

	public function getFormatItem($item)
	{
		// формирование цены для клиента и количество

		$price = 0;

		$count = 0;

		$price = intval($item->price_rostovND_rozn);
		
		if(!($price > 0)) 
		{
			$price = intval($tire->price_rostovND) * 1.1;
		}

		$count = intval(str_replace("более ", "", $item->rest_rostovND));
		
		// ингорирование, если нет цены или количества

		if (!($price > 0 && $count > 0))
		{
			return false;
		}
		
		//ид

		$objectTire = new ObjectTire($item->cae);

		// цена
		
		$objectTire->setPrice($price);

		// количество

		$objectTire->setCount($count);

		// закупчная цена

		$objectTire->setPurchasingPrice($item->price_rostovND);

		// бренд

		$objectTire->setBrand($item->brand);

		// модель

		$objectTire->setModel($item->model);

		// ширина

		$objectTire->setWidth($item->width);

		// высота

		$objectTire->setHeight($item->height);
		
		// диаметр

		$objectTire->setDiameter(str_replace(array("R","C"), "", $item->diameter));

		// индекс скорости

		$objectTire->setLoadIndex($item->load_index);
		
		// индекс нагрузки

		$objectTire->setSpeedIndex($item->speed_index);

		// шипованность

		if(isset($item->thorn) && (string)$item->thorn == "Да")
		{
			$objectTire->setIsPin();
		}

		return $objectTire;
	}
};
