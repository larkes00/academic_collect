<?php
$patterns = [
  'name' => [
    'regex' => '/^([А-ЯЁ]{1}[а-яё])|([A-Z]{1}[a-z])$/u'
  ],
  'position' => [
    'regex' => '/^.*$/u'
  ],
  'ukr_phone' => [
    'regex' =>'/^\+?3?8?0?\d{3}\d{2}\d{2}\d{2}$/',
    'replacement' => '/^\+?3?8?0?/',
    'callback' => function ()
    {
      return "+380";
    }
  ],
  'email' => [
    'regex' => '/^[a-zA-Z\d\W]+@[a-zA-Z\d\W]+$/'
  ],
  'iban' => [
    'regex' => '/^[a-zA-Z]{2}\s?[0-9]{2}\s?(?:[a-zA-Z0-9]\s?){4}(?:[0-9]\s?){7}\s?(?:[a-zA-Z0-9]?\s?){0,16}$/'
  ]
];
