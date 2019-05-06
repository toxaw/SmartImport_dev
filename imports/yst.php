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
		return $file->tyre;
	}

	public function getFormatItem($item)
	{
		// игнорирование старых шин

		if (preg_match('/\*\(20(1[0-5])|(0[0-9])\)/ui', $item->name)) 
		{
			return false;
		}

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

		$objectTire = new ObjectTire($item->article);

		// цена
		
		$objectTire->setPrice($price);

		// количество

		$objectTire->setCount($count);

		// закупчная цена

		$objectTire->setPurchasingPrice($item->price);

		// бренд

		$objectTire->setBrand($item->brand);

		// модель

		$objectTire->setModel($item->model);

		// ширина

		$objectTire->setWidth($item->width);

		// высота

		$objectTire->setHeight($item->height);
		
		// диаметр

		$objectTire->setDiameter(str_replace(array('R', 'C'), '', $item->diametr));

		// индекс скорости

		$objectTire->setLoadIndex($item->load_index);
		
		// индекс нагрузки

		$objectTire->setSpeedIndex($item->speed_index);

		// шипованность

		if((string)$item->thorn == '1')
		{
			$objectTire->setIsPin();
		}

		return $objectTire;
	}
};
