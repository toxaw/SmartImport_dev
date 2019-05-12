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
		return $file->COMMODITIES[0]->COMMODITY;
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

		$objectWheel = new ObjectWheel($item->SMNFCODE);

		// цена
		
		$objectWheel->setPrice($price);

		// количество

		$objectWheel->setCount($count);

		// закупчная цена

		$objectWheel->setPurchasingPrice($item->NPRICE_PREPAYMENT);

		// бренд

		$objectWheel->setBrand($item->SMARKA);

		// модель

		$objectWheel->setModel($item->SMODEL);

		// ширина диска

		$objectWheel->setWidth($item->SWIDTH);
		
		// диаметр обода

		$objectWheel->setDiameter($item->SDIAMETR);

		// число крепежных отверстий

		$objectWheel->setBoltsCount($item->SHOLESQUANT);

		// диаметр расположения крепежных отверстий

		$objectWheel->setBoltsSpacing($item->SPCD);

		// диаметр расположения крепежных отверстий 2

		$objectWheel->setBoltsSpacing2($item->SDPCD);

		// диаметр центрального отверстия

		$objectWheel->setDia($item->SDIA);

		// вылет диска

		$objectWheel->setEt($item->SWHEELOFFSET);

		// код цвета диска

		$objectWheel->setColor($item->SCOLOR);

		return $objectWheel;
	}
};
