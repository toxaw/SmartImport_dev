<?php
class Import
{
	protected $filename, $importId, $brandReplace, $modelReplace, $brandModelRepalce, $brandReplaceAll, $modelReplaceAll, $brandModelRepalceAll;

	public function setConfig($config)
	{
		$this->filename = $config['filename'] ?? '';

		$this->importId = $config['import_id'] ?? 0;

		$this->brandReplace = $config['brand_replace'] ?? [];
		
		$this->modelReplace = $config['model_replace'] ?? [];
		
		$this->brandModelRepalce = $config['brand_model_repalce'] ?? [];

		$this->brandReplaceAll = $config['brand_replace_all'] ?? [];
		
		$this->modelReplaceAll = $config['model_replace_all'] ?? [];
		
		$this->brandModelRepalceAll = $config['brand_model_repalce_all'] ?? [];				
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

		if(isset($this->brandReplace[$brand]))
		{
			$replace = str_replace($brand, $this->brandReplace[$brand], $replace);
		}

		return $replace;
	}

	public function modelReplace($model)
	{
		$replace = $model;

		if(isset($this->modelReplaceAll[$model]))
		{
			$replace = $this->modelReplaceAll[$model];
		}

		if(isset($this->modelReplace[$model]))
		{
			$replace = str_replace($model, $this->modelReplace[$model], $replace);
		}

		return $replace;
	}

	public function brandModelReplace($brandModel)
	{
		$replace = $brandModel;

		if(isset($this->brandModelReplaceAll[$brandModel]))
		{
			$replace = $this->brandModelReplaceAll[$brandModel];
		}

		if(isset($this->brandModelReplace[$brandModel]))
		{
			$replace = str_replace($brand, $this->brandModelReplace[$brandModel], $replace);
		}

		return $replace;
	}
}
