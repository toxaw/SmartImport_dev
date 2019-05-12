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
		return $file->tires->tire;
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

		$objectTire = new ObjectTire($item['sku']);

		// цена
		
		$objectTire->setPrice($price);

		// количество

		$objectTire->setCount($count);

		// закупчная цена

		$objectTire->setPurchasingPrice($item['price']);

		// бренд

		$objectTire->setBrand($item['brand']);

		// модель

		$objectTire->setModel($item['model']);

		// ширина

		$objectTire->setWidth($item['width']);

		// высота

		$objectTire->setHeight($item['profile']);
		
		// диаметр

		$objectTire->setDiameter(str_replace(['R', 'C'], '', $item['diam']));

		// индекс скорости

		$objectTire->setLoadIndex($item['load']);
		
		// индекс нагрузки

		$objectTire->setSpeedIndex($item['speed']);

		// шипованность

		if(isset($item['pin']) && (string)$item['pin'] == 'Y')
		{
			$objectTire->setIsPin();
		}

		return $objectTire;
	}
};
