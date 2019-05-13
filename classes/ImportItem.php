<?php
class ImportItem
{
	private $objectsImport, $importsOffersPath, $objectsItem, $itemsMethod;

	public function __construct($importsOffersPath, $objectsImport)
	{
		$this->importsOffersPath = $importsOffersPath;

		$this->objectsImport = $objectsImport;

		$this->itemsMethod = 
		[
			'xml' => 'XML',
			'csv' => 'CSV'
		];
	}

	public function &run()
	{
		foreach ($this->objectsImport as $importName => $objectImport) 
		{
			$fname = $this->importsOffersPath . $objectImport->getFileName();
			
			$pathInfo = pathinfo($fname);

			switch ($pathInfo['extension']) 
			{
				case 'xml':
					$fopen = simplexml_load_file($fname);

					break;
				
				case 'csv':
					$fopen = fopen($fname, "r");

					break;
				
				default:
					throw new Exception('\'' . $objectImport->getFileName() . '\' -  неизвестное раширение файла', 1);

					break;
			}

			$objectImport->before($fopen);

			$itemsMethod = 'items' . $this->itemsMethod[$pathInfo['extension']];

			$this->$itemsMethod($objectImport, $objectImport->getItems($fopen));
		}

		return $this->objectsItem;
	}

	private function itemsXML($objectImport, $items)
	{	
		foreach ($items as $item) 
		{
			$this->item($objectImport, $item);
		}
	}

	private function itemsCSV($objectImport, $items)
	{	
		while (($item = fgetcsv($items, 10000, ",")) !== FALSE)
		{
			$this->item($objectImport, $item);
		}
	}

	private function item($objectImport, $item)
	{
		$objectItem = $objectImport->getFormatItem($item);
		
		if($objectItem)
		{
			$objectItem->setImportId($objectImport->getImportId()); 
			
			$this->replace($objectItem, $objectImport);
			
			$this->objectsItem[] = $objectItem;
		}
	}

	private function replace($objectItem, $objectImport)
	{
		$brandModel = $objectItem->getBrandModel();

		if(!$brandModel)
		{
			$brand = $objectItem->getBrand();

			$brand = $objectImport->brandReplace($brand);
			
			$model = $objectItem->getModel();

			$model = $objectImport->modelReplace($model);

			$brandModel = $brand . ' ' . $model;
		}

		$brandModel = $objectImport->brandModelReplace($brandModel);

		$objectItem->setBrandModel($brandModel);

		return $objectItem;
	}
}