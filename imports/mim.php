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
		return $file->COMMODITIES[1]->COMMODITY;
	}

	public function getFormatItem($item)
	{
		// формирование цены для клиента и количество

		$price = 0;

		$count = intval($item->NREST);

		if (intval($item->NPRICE_RRP) == 0) 
		{
			if (intval($item->NPRICE_PREPAYMENT) != 0) 
			{
				$price = intval($item->NPRICE_PREPAYMENT) * 1.1;
			}
		} 
		else 
		{
			$price = $item->NPRICE_RRP;
		}		
		
		// ингорирование, если нет цены или количества

		if (!($price > 0 && $count > 0 && $item->TERRITORY_NAME == 'Пескова'))
		{
			return false;
		}
		
		//ид

		$objectTire = new ObjectTire($item->SMNFCODE);

		// цена
		
		$objectTire->setPrice($price);

		// количество

		$objectTire->setCount($count);

		// закупчная цена

		$objectTire->setPurchasingPrice($item->NPRICE_PREPAYMENT);

		// бренд

		$objectTire->setBrand($item->SMARKORIG);

		// модель

		$objectTire->setModel($item->SMODEL);

		// ширина

		$objectTire->setWidth($item->SWIDTH);

		// высота

		$objectTire->setHeight($item->SHEIGHT);
		
		// диаметр

		$objectTire->setDiameter($item->SDIAMETR);

		// индекс скорости

		$objectTire->setLoadIndex($item->SLOAD);
		
		// индекс нагрузки

		$objectTire->setSpeedIndex($item->SSPEED);

		// шипованность

		if((string)$item->STHORNING == 'Ш.')
		{
			$objectTire->setIsPin();
		}

		return $objectTire;
	}
};
