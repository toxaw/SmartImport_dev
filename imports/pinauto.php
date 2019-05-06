<?php

return new class extends Import implements iImport
{
	private $col;

	public function __construct()
	{
		$this->col =
		[
			'Артикул'			=> 2,
			'Наименование'		=> 3,
			'Количество'		=> 7,
			'Закупочная цена'	=> 10,
			'Цена' 				=> 12,
			'Ширина' 			=> 14,
			'Профиль' 			=> 15,
			'Диаметр' 			=> 16,
			'Индекс скорости' 	=> 17,
			'Индекс нагрузки'	=> 18,
			'Сезонность'		=> 19,
			'Шипы'				=> 20,
			'Производитель'		=> 21,
			'Модель' 			=> 22
		];	
	}

	public function before($file)
	{

	}

	public function getItems($file)
	{
		return $file;
	}

	public function getFormatItem($item)
	{
		// формирование цены для клиента и количество

		$price = 0;

		$count = intval(str_replace(['>', '<'], '', $item[$this->col['Количество']]));

		$price = intval($item[$this->col['Цена']]);

		if (!($price > 0)) 
		{
			$price = intval($item[$this->col['Закупочная цена']]) * 1.1;
		}
		
		// ингорирование, если нет цены или количества

		if (!($price > 0 && $count > 0))
		{
			return false;
		}
		
		//ид

		$objectTire = new ObjectTire($item[$this->col['Артикул']]);

		// цена
		
		$objectTire->setPrice($price);

		// количество

		$objectTire->setCount($count);

		// закупчная цена

		$objectTire->setPurchasingPrice($item[$this->col['Закупочная цена']]);

		// бренд

		$objectTire->setBrand($item[$this->col['Производитель']]);

		// модель

		$objectTire->setModel($item[$this->col['Модель']]);

		// ширина

		$objectTire->setWidth(str_replace('/', '', $item[$this->col['Ширина']]));

		// высота

		$objectTire->setHeight(str_replace('/', '', $item[$this->col['Профиль']]));
		
		// диаметр

		$objectTire->setDiameter(str_replace(['SUV', 'C', 'R'], '', $item[$this->col['Диаметр']]));

		// индекс скорости

		$objectTire->setLoadIndex(preg_replace('/\/?\s*\(.+?\)/', '', $item[$this->col['Индекс нагрузки']]));
		
		// индекс нагрузки

		$objectTire->setSpeedIndex(preg_replace('/\s*\(.+?\)/', '', $item[$this->col['Индекс скорости']]));

		// шипованность

		if($item[$this->col['Шипы']] == 'шипованная')
		{
			$objectTire->setIsPin();
		}

		return $objectTire;
	}
};
