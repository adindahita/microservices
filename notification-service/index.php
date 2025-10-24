<?php
require __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('user_events', false, false, false, false);

echo "Waiting for user events...\n";

$callback = function($msg) {
    echo "Received: ", $msg->body, "\n";
};

$channel->basic_consume('user_events', '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
