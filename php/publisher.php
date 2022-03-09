<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

echo "Hello! What is your name (enter below):\n";
$strName = fread(STDIN, 80);
echo 'Hello ', $strName, "\n";

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('ORDER_SERVICE', false, true, false, false);

$msg = new AMQPMessage("{$strName} Order's Added!");
$channel->basic_publish($msg, '', 'ORDER_SERVICE');

echo " [x] Sent 'Ali Order's Added {$strName}!'\n";

$channel->close();
$connection->close();
