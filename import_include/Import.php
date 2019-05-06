<?php
class Import
{
	protected $filename, $importId, $brandReplace, $modelReplace, $brandModelreplace, $brandReplaceAll, $modelReplaceAll, $brandModelreplaceAll;

	public function setConfig($config)
	{
		$this->filename = $config['filename'] ?? '';

		$this->importId = $config['import_id'] ?? 0;

		$this->brandReplace = $config['brand_replace'] ?? [];
		
		$this->modelReplace = $config['model_replace'] ?? [];
		
		$this->brandModelReplace = $config['brand_model_replace'] ?? [];

		$this->brandReplaceAll = $config['brand_replace_all'] ?? [];
		
		$this->modelReplaceAll = $config['model_replace_all'] ?? [];
		
		$this->brandModelReplaceAll = $config['brand_model_replace_all'] ?? [];		
	}

	public function getFileName()
	{
		return $this->filename;
	}

	public function getImportId()
	{
		return $this->importId;
	}

	public function brandReplace($brand)
	{
		$replace = $brand;

		if(isset($this->brandReplaceAll[$brand]))
		{
			$replace = $this->brandReplaceAll[$brand];
		}

		$replace = $this->brandReplace ? str_replace(array_keys($this->brandReplace), $this->brandReplace, $replace) : $replace;

		return $replace;
	}

	public function modelReplace($model)
	{
		$replace = $model;

		if(isset($this->modelReplaceAll[$model]))
		{
			$replace = $this->modelReplaceAll[$model];
		}

		$replace = $this->modelReplace ? str_replace(array_keys($this->modelReplace), $this->modelReplace, $replace) : $replace;

		return $replace;
	}

	public function brandModelReplace($brandModel)
	{
		$replace = $brandModel;

		if(isset($this->brandModelReplaceAll[$brandModel]))
		{
			$replace = $this->brandModelReplaceAll[$brandModel];
		}

		$replace = $this->brandModelReplace ? str_replace(array_keys($this->brandModelReplace), $this->brandModelReplace, $replace) : $replace;

		return $replace;
	}
}
