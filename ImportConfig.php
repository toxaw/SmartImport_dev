<?php

class ImportConfig
{
	private $configs;

	public function __construct()
	{
		$this->configs[56631] = 
		[
			'model_replace_all' => 
			[
				"HKPL" => "Hakkapeliitta",
				"IC-7" => "Ice Cruiser 7",
				"IG-35" => "IG35",
				"CARGO SPEED" => "CARGOSPEED",
				"С" => "C",
				"OBGSi5"  => "Observe GSi-5",
				"PXT1R"  => "Proxes T1-R"
			]
		];	
	}

	public function getConfig($array)
	{
		$config = $this->configs[$array['import_id']] ?? [];

		return array_merge($array, $config);
	}
}