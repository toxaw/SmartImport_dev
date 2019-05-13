<?php
require __DIR__ . '/cloudconvert-api/vendor/autoload.php';

use \CloudConvert\Api;

class ImportUpload {

	private $csvKey, $importArray, $loadDirectory, $report;

	public function __construct($csvKey, $loadDirectory, $importArray)
	{
		$this->csvKey = $csvKey;

		$this->importArray = $importArray;

		$this->loadDirectory = $loadDirectory . '/';
	}

	public function start()
	{
		$this->report = [];

		foreach ($this->importArray as $key => $value) 
		{
			$filename = $this->loadDirectory . $key;

			$path = $value['url'];

			$code = isset($value['code']) ? $value['code'] : [];

			$result = false;

			$sizeFileBefore = $this->getFileSize($filename);

			switch ($value['method']) {
				case 0:
					$result = $this->getXML($filename, $path, $code);

					break;
				case 1:
					$result = $this->getXMLtoCURL($filename, $path, $code);

					break;
				case 2:
					$result = $this->getCSVtoCURL($filename, $path, $code);

					break;
				default:
					$result = $this->getXML($filename, $path, $code);	

					break;
			}

			clearstatcache();

			$sizeFileAfter = $this->getFileSize($filename);

			$this->report[$key] = [	'name' => $key,
								   	'completed' => $result,
									'size_before' => $sizeFileBefore,
									'size_after' => $sizeFileAfter
								  ];

		}
	}

	public function getReportArray()
	{
		return $this->report;
	}

	public function getReportText()
	{
		$arr = [];

		foreach ($this->report as $key => $value) 
		{
			$sizeFormat = 'размер до ' . $value['size_before']['format'] . ', размер после ' . $value['size_after']['format']
						 . ', разница ' . $this->getDiffSize($value['size_before']['byte'], $value['size_after']['byte'])['format'];

			$arr[] = $value['name'] . ' [' . $sizeFormat . '] [' . ($value['completed'] ? 'успешно' : 'неуспешно') . ']';
		}

		return '<pre>' . implode("\r\n", $arr) . '</pre>';
	}

	private function getXML($filename, $path, $code)
	{
		if(!($content = file_get_contents($path)))
		{
			return false;
		}

		$content = $this->codeContent($content, $code);

		return file_put_contents($filename, $content);
	}

	private function getXMLtoCURL($filename, $path, $code)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $path);
		
		curl_setopt($ch,CURLOPT_HTTPHEADER,[
		        "Accept: application/xml"
		    ]);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$content = curl_exec($ch);

		if(!$content) 
		{
			return false;
		}

		$content = $this->codeContent($content, $code);

		return file_put_contents($filename, $content);
	}

	private function getCSVtoCURL($filename, $path, $code)
	{
		$api = new Api($this->csvKey);

		$api->convert([
		        'inputformat' => 'xls',
		        'outputformat' => 'csv',
		        'input' => 'upload',
		        'file' => fopen($path, 'r'),
		    ])
		    ->wait()
		    ->download($filename);

		return $this->codeFile($filename, $code);
	}

	private function getFileSize($filename)
	{
		if(is_file($filename))
		{
			$sizeByte = filesize($filename);

			return ['byte' => $sizeByte, 'format' =>  $sizeByte ? $this->formatBytes($sizeByte) : '0'];
		}
		else 
		{
			return ['byte' => 0,'format' => '0'];
		}
	}

	private function getDiffSize($sizeByte1, $sizeByte2)
	{
		$diff = abs($sizeByte1 - $sizeByte2);

		return ['byte' => $diff, 'format' =>  $diff ? $this->formatBytes($diff) : '0'];
	}

	private function formatBytes($size, $precision = 2)
	{
	    $base = log($size, 1024);
	    
	    $suffixes = array('', 'K', 'M', 'G', 'T');   

	    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
	}

	private function codeFile($filename, $code)
	{
		if($code)
		{
			if($content = file_get_contents($filename))
			{
				$content = $this->codeContent($content, $code);

				return file_put_contents($filename, $content);
			}
			else
			{
				return false;
			}
		}

		return true;
	}

	private function codeContent($content, $code)
	{
		if($code)
		{
			foreach ($code as $value) 
			{
				$content = iconv($value[0], $value[1], $content);
			}
		}

		return $content;
	}
}