<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ChatApp;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
    {
        $this->seedUsers();
        $this->seedChatMessages();
         $this->call(OrderSeeder::class);
    }

    
    private function seedUsers(): void
    {
        User::factory(100)->create([
            'status' => 0,
        ]);

        User::factory()->create([
            'name' => 'Test User1',
            'email' => 'testaas1@example.com',
            'status' => 0,
        ]);
    }


    private function seedChatMessages(): void
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
