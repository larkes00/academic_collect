<?php
$methods = [
	'submitAmbassador' => [
		'params' => [
			[
				'name' => 'firstname',
				'source' => 'p',
				'pattern' => 'name',
				'required' => true
			],
			[
				'name' => 'secondname',
				'source' => 'p',
				'pattern' => 'name',
				'required' => true
			],
			[
				'name' => 'position',
				'source' => 'p',
				'pattern' => 'position',
				'required' => false,
				'default' => 'не вказано'
			],
			[
				'name' => 'phone',
				'source' => 'p',
				'pattern' => 'ukr_phone',
				'required' => true
			],
			[
				'name' => 'email',
				'source' => 'p',
				'pattern' => 'email',
				'required' => false,
				'default' => 'не вказано'
			],
			[
				'name' => 'iban',
				'source' => 'p',
				'pattern' => 'iban',
				'required' => false,
				'default' => 'не вказано'
			],
		]
	]
];