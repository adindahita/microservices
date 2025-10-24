<?php
require __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Koneksi ke RabbitMQ
$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

// Pastikan queue ada
$channel->queue_declare('user_events', false, false, false, false);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = ['user' => $_POST['user'] ?? 'anonymous', 'email' => $_POST['email'] ?? 'unknown'];
    $msg = new AMQPMessage(json_encode($data));
    $channel->basic_publish($msg, '', 'user_events');
    
    echo "Event user berhasil dikirim ke RabbitMQ!";
} else {
    echo "<h2>Form User Event</h2>
	  <form method='POST'>
	    Nama: <input name='user'><br>
	    Email: <input name='email'><br>
	    <button type='submit'>Kirim</button> 
	  </form>";
}

$channel->close();
$connection->close();
