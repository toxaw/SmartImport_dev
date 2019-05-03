<?php
$dirPath = __DIR__ . '/';

$importIncludePath = $dirPath . 'import_include/';

$importsPath = $dirPath . 'imports/';

$importsOffersPath = $dirPath . 'import_offers/';

$importConfig = require $dirPath . 'import_config.php';

$parentClass = 'Import';

$implementClass = 'iImport';

require 'ImportConfig.php';

require 'ImportItem.php';

//----------------------------------------------------------

$importConfigDB = new ImportConfig();

spl_autoload_register(
	function ($class) use ($importIncludePath) 
	{
    	require $importIncludePath . $class . '.php';
	}
);

//----------------------------------------------------------Подготовка выгрузок

$scanResult = array_diff(scandir($importsPath), ['.', '..']);

$objectsImport = [];

foreach ($scanResult as $importFileObject) 
{
	$objectImport = require $importsPath . $importFileObject;

	$interfaces = class_implements($objectImport);

	$parent = get_parent_class($objectImport);

	if(!($interfaces && isset($interfaces[$implementClass])))
	{
		throw new Exception("'$importFileObject' не наследует интерфейс '$implementClass'.", 1);		
	}

	if($parent != $parentClass)
	{
		throw new Exception("'$importFileObject' не наследует класс '$parentClass'.", 1);
	}

	$importName = preg_replace('/\.php$/', '', $importFileObject); 

	if(!isset($importConfig[$importName]))
	{
		throw new Exception("'$importName' не имеет обязательных настроек.", 1);		
	}

	$config = $importConfig[$importName];

	$config = $importConfigDB->getConfig($config);

	$objectImport->setConfig($config);

	$objectsImport[$importName] = $objectImport;
}

//----------------------------------------------------------Обход выгрузок

$importItem = new ImportItem($importsOffersPath, $objectsImport);

$objectsItem = $importItem->run();

echo '<pre>';

die('[' . count($objectsItem) . ']');

die('done');