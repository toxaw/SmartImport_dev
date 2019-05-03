<?php
class ImportItem
{
	private $objectsImport, $importsOffersPath;

	public function __construct($importsOffersPath, $objectsImport)
	{
		$this->importsOffersPath = $importsOffersPath;

		$this->objectsImport = $objectsImport;
	}

	public function run()
	{
		foreach ($this->objectsImport as $importName => $objectImport) 
		{
			$fname = $this->importsOffersPath . $objectImport->getFileName();
			
			$xml = simplexml_load_file($fname);

			$objectImport->before($xml);

			$this->items($objectImport, $objectImport->getItems($xml));
		}
	}

	private function items($objectImport, $items)
	{
		echo '<pre>';

		foreach ($items as $item) 
		{print_r($item);
			$formatItem = $objectImport->getFormatItem($item);
die();
			/*if($formatItem)
			{
				print_r($formatItem);
			}*/
		}
	}
}