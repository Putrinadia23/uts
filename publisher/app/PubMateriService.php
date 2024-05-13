<?php

namespace App;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class PubMateriService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function materiUpdate($message)
    {
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $channel->exchange_declare('materi_update', 'direct', false, false, false);
        $channel->queue_declare('materi_update_queue', false, false, false, false);
        $channel->queue_bind('materi_update_queue', 'materi_update', 'materi_update');
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, 'materi_update', 'materi_update');
        echo " [x] Sent $message to materi_update / materi_update_queue.\n";
        $channel->close();
        $connection->close();
    }

    public function materiDelete($message){
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $channel->exchange_declare('materi_delete', 'direct', false, false, false);
        $channel->queue_declare('materi_delete_queue', false, false, false, false);
        $channel->queue_bind('materi_delete_queue', 'materi_delete', 'materi_delete');
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, 'materi_delete', 'materi_delete');
        echo " [x] Sent $message to materi_delete / materi_delete_queue.\n";
        $channel->close();
        $connection->close();
    }
}
