<?php

return new class extends Import implements iImport
{
	private $rndStores, $assocProperty;

	public function __construct()
	{
		$this->rndStores =
		[
			'39511c5e-73e0-11db-b06c-001279921194',
			'94ef7f0d-cc50-11df-ab00-0014c263a2cd',
			'39511c5f-73e0-11db-b06c-001279921194',
			'39511c67-73e0-11db-b06c-001279921194',
			'39511c68-73e0-11db-b06c-001279921194',
			'39511c69-73e0-11db-b06c-001279921194',
			'2791f977-730d-11db-ad64-001111410f5e',
			'4a821581-6ac4-11e6-940a-80c16e78acc1',
			'4a821582-6ac4-11e6-940a-80c16e78acc1'
		];

		$this->assocProperty = [
				  'Артикул'											=> 'article',
				  'Бренд' 											=> 'brand',
				  'Модель' 											=> 'model',
				  'Ширина диска в дюймах / Вид закраины' 			=> 'width',
				  'Диаметр обода в дюймах' 							=> 'diameter',
				  'Число/диаметр расположения крепежных отверстий'	=> 'bolts_count_spacing',
				  'Диаметр центрального отверстия ' 				=> 'dia',
				  'Вылет диска в мм.(ЕТ)' 							=> 'et',
				  'Цвет диска 1' 									=> 'color',
				  'Цена' 											=> 'purchasing_price',
				  'МИЦ' 											=> 'price'
				];		
	}

	public function before($file)
	{

	}

	public function getItems($file)
	{
		return $file->shop->offers->offer;
	}

	public function getFormatItem($item)
	{
		$param = [];

		foreach ($item as $key => $value) 
		{	
			$attributeName = $value->attributes()['name'] . '';
			
			$param[$this->assocProperty[$attributeName]] = $value . '';				
		}

		// формирование цены для клиента и количество

		$price = intval($param['price']);

		$count = 0;

		if (!($price > 0)) 
		{
			$price = intval($param['purchasing_price']) * 1.1;
		}

		foreach ($item->stores->store as $store) 
		{
			$store_id = strval($store['id']);

			if (in_array($store_id, $this->rndStores)) 
			{
				$count += intval($store);
			}
		}
		
		// ингорирование, если нет цены или количества

		if (!($price > 0 && $count > 0))
		{
			return false;
		}
		
		//ид

		$objectWheel = new ObjectWheel($param['article']);

		// цена
		
		$objectWheel->setPrice($price);

		// количество

		$objectWheel->setCount($count);

		// закупчная цена

		$objectWheel->setPurchasingPrice($param['purchasing_price']);

		// бренд

		$objectWheel->setBrand($param['brand']);

		// модель

		$objectWheel->setModel($param['model']);

		// ширина диска

		$objectWheel->setWidth(str_replace('j', '', $param['width']));
		
		// диаметр обода

		$objectWheel->setDiameter(str_replace('"', '', $param['diameter']));

		$boltsCountSpacing = explode('/', $param['bolts_count_spacing']);

		// число крепежных отверстий

		$objectWheel->setBoltsCount($boltsCountSpacing[0]);

		// диаметр расположения крепежных отверстий

		$objectWheel->setBoltsSpacing($boltsCountSpacing[1]);

		// диаметр расположения крепежных отверстий 2

		$objectWheel->setBoltsSpacing2($boltsCountSpacing[2] ?? 0);

		// диаметр центрального отверстия

		$objectWheel->setDia($param['dia']);

		// вылет диска

		$objectWheel->setEt($param['et']);

		// код цвета диска

		$objectWheel->setColor($param['color']);

		return $objectWheel;
	}
};
