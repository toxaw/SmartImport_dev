<?php
class ImportItem
{
	private $objectsImport, $importsOffersPath, $objectsItem;

	public function __construct($importsOffersPath, $objectsImport)
	{
		$this->importsOffersPath = $importsOffersPath;

		$this->objectsImport = $objectsImport;
	}

	public function &run()
	{
		foreach ($this->objectsImport as $importName => $objectImport) 
		{
			$fname = $this->importsOffersPath . $objectImport->getFileName();
			
			$xml = simplexml_load_file($fname);

			$objectImport->before($xml);

			$this->items($objectImport, $objectImport->getItems($xml));
		}

		return $this->objectsItem;
	}

	private function items($objectImport, $items)
	{	
		foreach ($items as $item) 
		{
			$objectItem = $objectImport->getFormatItem($item);
			
			if($objectItem)
			{
				$objectItem->setImportId($objectImport->getImportId()); 
				
				$this->replace($objectItem, $objectImport);
				
				$this->objectsItem[] = $objectItem;
			}
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