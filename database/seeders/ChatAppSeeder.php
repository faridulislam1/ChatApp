<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ChatApp;

class ChatAppSeeder extends Seeder
{
  
     public function run(): void
    {
        $userIds = User::pluck('id')->toArray();

        foreach (range(1, 2000) as $i) {
            $sender = $userIds[array_rand($userIds)];
            $receiver = $userIds[array_rand($userIds)];
            while ($receiver === $sender) {
                $receiver = $userIds[array_rand($userIds)];
            }
            ChatApp::create([
                'sender_id' => $sender,
                'receiver_id' => $receiver,
                'message' => "Message {$i} from user {$sender} to user {$receiver}",
            ]);
        }
    }
    
}
