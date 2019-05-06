<?php

return new class extends Import implements iImport
{
	private $itemOffers;

	public function __construct()
	{
		$this->itemOffers = [];	
	}

	public function before($file)
	{
		foreach ($file->prices->tire as $item) 
		{
			$this->itemOffers[strval($item->cae)] =
			[
				'wholesale'	=> intval($item->price->price[1]->price),
				'price'		=> intval($item->price->price[0]->price)
			];
		}
		
		foreach ($file->rests->tire as $item) 
		{
			$this->itemOffers[strval($item->cae)]['count'] = intval($item->rests->rest->rest);
		}
	}

	public function getItems($file)
	{
		return $file->products->tire;
	}

	public function getFormatItem($item)
	{
		// формирование цены для клиента и количество

		$price = intval($this->itemOffers[strval($item->cae)]['price']);

		$count = intval($this->itemOffers[strval($item->cae)]['count']);

		if (!($price > 0)) 
		{
			$price = intval($this->itemOffers[strval($item->cae)]['wholesale']) * 1.1;
		}
		
		// ингорирование, если нет цены или количества

		if (!($price > 0 && $count > 0))
		{
			return false;
		}
		
		//ид

		$objectTire = new ObjectTire(str_replace([' шип', 'н/ш'], '', $item->cae));

		// цена
		
		$objectTire->setPrice($price);

		// количество

		$objectTire->setCount($count);

		// закупчная цена

		$objectTire->setPurchasingPrice($this->itemOffers[strval($item->cae)]['wholesale']);

		//брендМодель

		$name = str_replace([' XL ', ' XL', ' STUD '], ' ', strval($item->name));

		$name = str_replace([' шип', 'н/ш'], '', $name);

		$nameExplode = explode(' ', trim(preg_replace('/\s{2,}/ui', ' ', $name)));

		$diameterBef = str_replace($item->width . '/' . $item->height, '', $nameExplode[0]);

		$diameter = [];

		preg_match('/[0-9]{1,2}[\.,]?[0-9]{0,2}/',$diameterBef, $diameter);

		$indexes = $nameExplode[1];

		$loadIndexMath = [];

		if(!(preg_match('/[0-9]{1,}\/[0-9]{1,}/ui', $indexes, $loadIndexMath)))
		{	
			$loadIndexMath = [];
			
			preg_match('/[0-9]{1,}/ui', $indexes, $loadIndexMath);
		}

		array_shift($nameExplode);
		
		array_shift($nameExplode);

		$objectTire->setBrandModel(implode(' ', $nameExplode));

		// ширина

		$objectTire->setWidth($item->width);

		// высота

		$objectTire->setHeight($item->height);
		
		// диаметр

		$objectTire->setDiameter($diameter[0]);

		// индекс скорости

		$objectTire->setLoadIndex($loadIndexMath[0]);
		
		// индекс нагрузки

		$objectTire->setSpeedIndex(str_replace($loadIndexMath[0], '', $indexes));

		// шипованность

		if(isset($item->is_studded) && (string)$item->is_studded == 'Есть')
		{
			$objectTire->setIsPin();
		}

		return $objectTire;
	}
};
