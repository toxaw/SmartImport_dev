<?php
$dirPath = __DIR__ . '/';

$importIncludePath = $dirPath . 'import_include/';

$importsPath = $dirPath . 'imports/';

$classesPath = $dirPath . 'classes/';

$importsOffersPath = $dirPath . 'import_offers/';

$importConfig = require $dirPath . 'import_config.php';

$parentClass = 'Import';

$implementClass = 'iImport';

$csvConverterApiKey = 'NCNIbfbE0Aqcz4zk1eemkr4zgcJN81lpiRojkvquGJYz1oZa7znbDOHxHVNb8cJR';

require $classesPath . 'ImportConfig.php';

require $classesPath . 'ImportItem.php';

require $classesPath . 'ImportUpload.php';

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

	if(!isset($importConfig['imports'][$importName]))
	{
		throw new Exception("'$importName' не имеет обязательных настроек.", 1);		
	}

	$config = $importConfig['imports'][$importName];

	$config = $importConfigDB->getConfig($config);

	$objectImport->setConfig($config);

	$objectsImport[$importName] = $objectImport;
}
//---Установка маскимального времени выполнения скрипта

set_time_limit(3600);

//----------------------------------------------------------Удаленное выкачивание выгрузок

/**/$timeStartUpload = time();

if(isset($importConfig['uploads']))
{
	$importUpload = new ImportUpload($csvConverterApiKey, $importsOffersPath, $importConfig['uploads']);

	$importUpload->start();

	$resultImportUpload = $importUpload->getReportText();

	/**/

	echo $resultImportUpload;

	/**/
}

//----------------------------------------------------------Обход выгрузок

$importItem = new ImportItem($importsOffersPath, $objectsImport);

/**/$timeStartItem = time();

$objectsItem = $importItem->run();

echo '<pre>';

//print_r($objectsItem);

die('[' . count($objectsItem) . '][time Uploads:' . ($timeStartItem - $timeStartUpload) . '][time Item:' . (time() - $timeStartItem) . '][time:' . (time() - $timeStartUpload) . ']');

die('done');