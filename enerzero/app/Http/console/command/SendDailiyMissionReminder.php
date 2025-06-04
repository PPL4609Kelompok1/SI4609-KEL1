<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendDailyMissionReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-mission-reminder';

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
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            $user->notify(new \App\Notifications\DailyChallengeNotification());
        }
        $this->info('Notifikasi misi harian telah dikirim ke semua user.');
    }
}