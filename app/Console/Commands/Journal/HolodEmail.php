<?php

namespace App\Console\Commands\Journal;

use Illuminate\Console\Command;
use App\Models\Journals\Holod;
use App\Models\User;
use App\Mail\JournalHolod;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class HolodEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'holod:email';

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
        $items_today = Holod::select('department', 'holodilnik', 'created_at')->where('created_at', today())->where(function ($query) {
            $query->where('utro', '')
            ->orWhere('vecher', '');
        })->get();
        $items = Holod::select('department', 'holodilnik', DB::raw('MAX(created_at) as created_at'))->groupBy('department', 'holodilnik')->get();
        $i=0;
        foreach($items as $item) {
          if ($item->created_at->timezone('Asia/Krasnoyarsk') == today() OR $item->created_at->timezone('Asia/Krasnoyarsk') < today()->subDays(2)) {
            unset($items[$i]);
          }
          $i++;
        }
        $items = array_merge($items->toArray(), $items_today->toArray());
        if (!empty($items)) {
          $user = new User();
          $users = $user->whereHas('roles.permissions', function (\Illuminate\Database\Eloquent\Builder $query) {
              $query->where('permission_slug', 'holod_all_view');
          })->get();

          Mail::to($users)->queue(new JournalHolod($items));
        }
    }
}
