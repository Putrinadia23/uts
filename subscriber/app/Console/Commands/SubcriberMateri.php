<?php

namespace App\Console\Commands;

use App\Models\Materi;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class SubcriberMateri extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consume:subcriber-materi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $updateCallback = function ($msg) {
            $data = json_decode($msg->body, true);
            $materi = Materi::find($data['materi_id']);

            $materi->update([
                'title' => $data['title'],
                'category' => $data['category'],
                'content' => $data['content'],
            ]);
            echo ' [x] Materi berhasil diubah ', "\n";
        };

        $deleteCallback = function ($msg) {
            $data = json_decode($msg->body, true);
            $materi = Materi::find($data['id']);

            $materi->delete();
            echo ' [x] Materi berhasil DiDelete', "\n";
        };
        $channel->queue_declare('materi_update_queue', false, false, false, false);
        $channel->basic_consume('materi_update_queue', '', false, true, false, false, $updateCallback);

        $channel->queue_declare('materi_delete_queue', false, false, false, false);
        $channel->basic_consume('materi_delete_queue', '', false, true, false, false, $deleteCallback);
        echo 'Waiting for new message', " \n";
        while ($channel->is_consuming()) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }
}
