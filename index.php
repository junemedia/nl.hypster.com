<?php

ini_set('display_errors', true);

require __DIR__ . '/vendor/autoload.php';

use Liquid\Liquid;
use Liquid\Template;
use Guzzle\Http\Client;

Liquid::set('INCLUDE_SUFFIX', 'tpl');
Liquid::set('INCLUDE_PREFIX', '');

$path = dirname(__FILE__) . DIRECTORY_SEPARATOR;

$liquid = new Template($path . 'templates' . DIRECTORY_SEPARATOR);
$liquid->parse(file_get_contents($path . 'templates' . DIRECTORY_SEPARATOR . 'daily.tpl'));

// get feed content
$client = new Client('http://api.hypster.com');
$feed = $client->get('/posts/daily')->send()->json();

// gotta throw in some stuff that would come from Maropost
$feed['contact'] = array('email' => 'johns@junemedia.com');
$feed['campaign'] = array('id' => time());

echo $liquid->render($feed);
