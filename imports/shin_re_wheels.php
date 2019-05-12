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
		foreach ($file->prices->rim as $item) 
		{
			$this->itemOffers[strval($item->cae)] =
			[
				'wholesale'	=> intval($item->price->price[1]->price),
				'price'		=> intval($item->price->price[0]->price)
			];
		}
		
		foreach ($file->rests->rim as $item) 
		{
			$this->itemOffers[strval($item->cae)]['count'] = intval($item->rests->rest->rest);
		}
	}

	public function getItems($file)
	{
		return $file->products->rim;
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

		$objectWheel = new ObjectWheel($item->cae);

		// цена
		
		$objectWheel->setPrice($price);

		// количество

		$objectWheel->setCount($count);

		// закупчная цена

		$objectWheel->setPurchasingPrice($this->itemOffers[strval($item->cae)]['wholesale']);

		// брендМодель
		
		//т.к. модель не пришла, будет ее вытаскивать

		$brandModel = str_replace('Диск ', '', $item->name);

		$brandModel = str_replace($item->width . 'x' . $item->diameter, '', $brandModel);

		$brandModel = str_replace($item->bolts_count . 'x' . $item->bolts_spacing, '', $brandModel);

		$brandModel = str_replace('D' . str_replace('.', ',', $item->dia), '', $brandModel);

		$brandModel = str_replace('ET' . str_replace('.', ',', $item->et), '', $brandModel);

		$brandModel = trim(preg_replace('/\s{1,}/ui',' ', $brandModel));

		$brandModelExplode = explode(' ', $brandModel);

		$colorExplode = explode(' ', trim(preg_replace('/\s{1,}/ui', ' ', $item->color)));

		for($i = min(count($brandModelExplode), count($colorExplode)), $mi = count($brandModelExplode), $ci = count($colorExplode); $i>=0; $i--, $mi--, $ci--)
		{
			if($brandModelExplode[$mi] == $colorExplode[$ci])
			{
				$brandModelExplode[$mi] = '';
			}
		}

		$brandModel = trim(preg_replace('/\s{1,}/ui',' ',implode(' ', $brandModelExplode)));
		
		$objectWheel->setBrandModel($brandModel);

		// ширина диска

		$objectWheel->setWidth($item->width);
		
		// диаметр обода

		$objectWheel->setDiameter($item->diameter);

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
