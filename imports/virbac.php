<?php

return new class extends Import implements iImport
{
	private $rndStores;

	public function __construct()
	{
		$this->rndStores =
		[
			"39511c5e-73e0-11db-b06c-001279921194",
			"94ef7f0d-cc50-11df-ab00-0014c263a2cd",
			"39511c5f-73e0-11db-b06c-001279921194",
			"39511c67-73e0-11db-b06c-001279921194",
			"39511c68-73e0-11db-b06c-001279921194",
			"39511c69-73e0-11db-b06c-001279921194",
			"2791f977-730d-11db-ad64-001111410f5e",
			"4a821581-6ac4-11e6-940a-80c16e78acc1",
			"4a821582-6ac4-11e6-940a-80c16e78acc1"
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
		// игнорирование старых шин

		if (preg_match('/\(шина\s*20(1[0-5])|(0[0-9])\s*г.*?\)/ui', $item->name)) 
		{
			return false;
		}

		// формирование цены для клиента и количество

		$price = 0;

		$count = 0;

		if (intval($item->prices->mic) > 0) 
		{
			$price = intval($item->prices->mic);
		} 
		elseif (intval($item->prices->mrc) > 0) 
		{
			$price = intval($item->prices->mrc);
		} 
		else 
		{
			$price = intval($item->prices->price) * 1.1;
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

		$objectTire = new ObjectTire($item->article);

		// цена
		
		$objectTire->setPrice($price);

		// количество

		$objectTire->setCount($count);

		// закупчная цена

		$objectTire->setPurchasingPrice($item->prices->price);

		// бренд

		$objectTire->setBrand($item->props->brend);

		// модель

		$objectTire->setModel($item->props->model);

		// ширина

		$objectTire->setWidth($item->props->shirina_protektora);

		// высота

		$objectTire->setHeight($item->props->vysota_profilya);
		
		// диаметр

		$objectTire->setDiameter(str_replace("\"", "", $item->props->diametr_oboda_v_dyuymakh));

		// индекс скорости

		$objectTire->setLoadIndex($item->props->indeks_nagruzki);
		
		// индекс нагрузки

		$objectTire->setSpeedIndex($item->props->indeks_skorosti);

		// шипованность

		if((string)$item->props->tip_shiny == "Шипованные")
		{
			$objectTire->setIsPin();
		}

		return $objectTire;
	}
};
