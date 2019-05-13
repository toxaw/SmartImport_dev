<?php

return  [
		'uploads' =>
					[
						'virbacauto.xml' => 
										[
											'url' => 'https://www.virbacavto.ru/technical/get/tires/nco.xml',
											'method' => 0
										],
						'virbacauto_wheels.xml' => 
										[
											'url' => 'https://www.virbacavto.ru/bitrix/catalog_export/wheels.xml',
											'method' => 0
										],
						'M18605.xml' => 
										[
											'url' => 'https://b2b.pwrs.ru/export_data/M18605.xml',
											'method' => 0
										],
						'svrauto.xml' => 
										[
											'url' => 'https://webmim.svrauto.ru/api/v1/catalog/unload?access-token=tPPzPXidtV3PfeeFgtFwJ6meqdD8rPZT&format=xml&types=1%3B2&stores=true',
											'method' => 0
										],
						'WinterTyresVIP.csv' => 
										[
											'url' => 'http://partner.pin-avto.ru/Prices/WinterTyresVIP.xls',
											'method' => 2
										],
						'terminal.yst.ru.xml' => 
										[
											'url' => 'http://terminal.yst.ru/api/xml/tyre/22b8904a-5b26-48f5-8fad-6f1a71fa8a54?typeofrests=1',
											'method' => 1
										],
						'terminal.yst.ru_wheels.xml' => 
										[
											'url' => 'http://terminal.yst.ru/api/xml/disk/22b8904a-5b26-48f5-8fad-6f1a71fa8a54',
											'method' => 1
										],
						'load-price-xml.xml' => 
										[
											'url' => 'https://rostov.trektyre.ru/load-price-xml?url=856ed9fc109e4ab6bc015a50f4878dee&oplata=0s',
											'method' => 0
										],
						'intershina.agora.ru.xml' => 
										[
											'url' => 'https://intershina.agora.ru/api/rest/v1/export-data/?',
											'method' => 0
										],
						'shinservice-b2b-shops.xml' => 
										[
											'url' => 'https://www.shinservice.ru/xml/shinservice-b2b-shops.xml?id=88922976&t=1549797623721',
											'method' => 0
										],			
					],
		'imports' => 
					[
						'virbac' => 	
										[
											'filename' => 'virbacauto.xml',
											'import_id' => '56631'
										],
						'fortochki' => 	
										[
											'filename' => 'M18605.xml',
											'import_id' => '71567'
										],
						'mim' => 		
										[
											'filename' => 'svrauto.xml',
											'import_id' => '56091'
										],
						'pinauto' => 	
										[
											'filename' => 'WinterTyresVIP.csv',
											'import_id' => '52115'
										],
						'shin_re' => 	
										[
											'filename' => 'intershina.agora.ru.xml',
											'import_id' => '104439'
										],
						'shinservice' => 
										[
											'filename' => 'shinservice-b2b-shops.xml',
											'import_id' => '105086'
										],
						'trektyre'	=> 
										[
											'filename' => 'load-price-xml.xml',
											'import_id' => '104438'
										],	
						'yst'	=> 
										[
											'filename' => 'terminal.yst.ru.xml',
											'import_id' => '103478'
										],
						'virbac_wheels' => 
										[
											'filename' => 'virbacauto_wheels.xml',
											'import_id' => '335208'							
										],
						'fortochki_wheels' => 
										[
											'filename' => 'M18605.xml',
											'import_id' => '329069'							
										],
						'mim_wheels' => 		
										[
											'filename' => 'svrauto.xml',
											'import_id' => '367949'
										],
						'shin_re_wheels' => 	
										[
											'filename' => 'intershina.agora.ru.xml',
											'import_id' => '361182'
										],
						'shinservice_wheels' => 
										[
											'filename' => 'shinservice-b2b-shops.xml',
											'import_id' => '369582'
										],													
						'yst_wheels'	=> 
										[
											'filename' => 'terminal.yst.ru_wheels.xml',
											'import_id' => '350554'
										],															
					]
		];