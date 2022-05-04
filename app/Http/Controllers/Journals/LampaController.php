<?php

namespace App\Http\Controllers\Journals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use App\Models\Organization;
use App\Models\Journals\Lampa;
use App\Http\Requests\LampaRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LampaController extends Controller
{
    public function main(Request $request) {
        $lampas = $items = array();
        $stat = new Lampa();
        $items = $stat->getwhere($request)->with('user')->orderBy('updated_at', 'desc')->paginate(5000);

        $cities = Person::distinct()->pluck('city');
        $organizations = Organization::distinct()->orderBy('org', 'asc')->pluck('org');
        $departments = Organization::distinct()->orderBy('department', 'asc')->pluck('department');
        $our_departments = Lampa::distinct()->orderBy('department', 'asc')->pluck('department');
        $our_lampas = Lampa::distinct()->orderBy('lampa', 'asc')->pluck('lampa');
        return view('Journals/lampa', compact('items', 'organizations', 'departments', 'cities', 'request', 'lampas', 'our_departments', 'our_lampas'));
    }

    public function new(LampaRequest $request) {
        $user = User::find(auth()->user()->id);
        session(['department' => $request->department, 'lampa' => $request->lampa, 'condition' => $request->condition, 'rad_mode' => $request->rad_mode]);
        $time = explode(':', $request->time_on);
        $time_on = Carbon::createFromTime($time[0], $time[1]);
        $time = explode(':', $request->time_off);
        $time_off = Carbon::createFromTime($time[0], $time[1]);
        $duration = $time_on->diffInMinutes($time_off, false);
        $lampa = new Lampa();
        $duration_all = $lampa->getwhere($request->all())->latest()->first();
        if (!$duration_all) $duration_all = 0; else $duration_all = $duration_all->duration_all;
        $user = $user->lampa()->Create($request->all() + ['duration' => $duration, 'duration_all' => $duration_all + $duration]);
        if ($duration_all/60 > env('LAMPA_NARABOTKA')) session()->flash('warning', 'Пора заменить лампу в помещении <b>'.$request->lampa.'</b> Время наработки: <b>'.round($duration_all/60, 0) .' '. trans_choice('час|часа|часов', round($duration_all/60, 0), [], 'ru').'</b>');
        if ($user) return back()->with('success', 'Режим включения бактерицидной лампы зарегистрирован');
        else return back()->with('error', 'Не удалось зарегистрировать режим включения бактерицидной лампы');
    }

    public function zamena(Request $request) {
      if (Lampa::where('department', $request->department)->where('lampa', $request->lampa)->update(['duration_all' => 0]))
      return back()->with('success', 'Лампа в помещении <b>'.$request->lampa.'</b> подразделения <b>'.$request->department.'</b> заменена. Отсчёт наработки начнётся заново');
    }

    public function narabotka() {
      $items = array();
      $items = Lampa::select('*', DB::raw('max(duration_all) as duration_all'))->groupBy('department', 'lampa')->orderBy('duration_all', 'desc')->get();
      return view('Journals/narabotka-lamp', compact('items'));
    }
}
