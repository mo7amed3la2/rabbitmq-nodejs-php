<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('ORDER_SERVICE', false, true, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
  echo " [x] Received {$msg->body} \n";
};

$channel->basic_consume('ORDER_SERVICE', '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}