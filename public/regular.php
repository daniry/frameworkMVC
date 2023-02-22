<?php

$url = '/post/892';

$re = '/\/(?P<controller>[a-zA-Z]+)\/(?<id>[0-9]+)/m';

//$re_str = '/\/[a-zA-Z]+\//';

preg_match($re, $url, $matches);

//preg_match('/[0-9]+/', $url, $id);

$controller = $matches['controller'];
$id = $matches['id'];

var_dump($controller, $id);