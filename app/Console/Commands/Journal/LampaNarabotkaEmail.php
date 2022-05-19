<?php

namespace App\Console\Commands\Journal;

use Illuminate\Console\Command;
use App\Models\Journals\Lampalist;
use App\Models\User;
use App\Mail\JournalLampaNarabotka;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class LampaNarabotkaEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lampanarabotka:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $items['7700'] = Lampalist::whereBetween('duration_all', [7700*60, 7725*60])->get()->toArray();
      $items['8000'] = Lampalist::where('duration_all', '>', 7975*60)->get()->toArray();

      if (!empty($items['7700']) OR !empty($items['8000'])) {
        $user = new User();
        $users = $user->whereHas('roles.permissions', function (\Illuminate\Database\Eloquent\Builder $query) {
            $query->where('permission_slug', 'lampa_all_view');
        })->get();

        Mail::to($users)->queue(new JournalLampaNarabotka($items));
      }
    }
}
