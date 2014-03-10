<?php
header('Content-Type: application/json; charset=utf8');
header('Access-Control-Allow-Origin: http://dashboard.localhost.net/');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Methods: POST');

$data = array(
  'log' => Log::getAll(),
  'res' => $controller->data
);

echo json_encode($data);
