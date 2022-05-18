<?php

namespace App\Http\Controllers\Journals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use App\Models\Organization;
use App\Models\Journals\Lampa;
use App\Models\Journals\Lampalist;
use App\Models\Department;
use App\Http\Requests\LampaRequest;
use App\Http\Requests\LampaNewRequest;
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
        $departments = Lampalist::distinct()->orderBy('department', 'asc')->pluck('department');
        $our_departments = Lampalist::distinct()->orderBy('department', 'asc')->pluck('department');
        $our_lampas = Lampalist::distinct()->orderBy('lampa', 'asc')->pluck('lampa');
        return view('Journals/lampa', compact('items', 'organizations', 'departments', 'cities', 'request', 'lampas', 'our_departments', 'our_lampas'));
    }

    public function list() {
        $items = array();
        $items = Lampalist::orderBy('created_at', 'desc')->get();
        if (isset(auth()->user()->city)) $departments = Department::where('city', auth()->user()->city)->distinct()->pluck('department');
        else $departments = Department::distinct()->pluck('department');
        return view('Journals/lampa-list', compact('items', 'departments'));
    }

    public function del(Request $request) {
        if (Lampalist::where('department', $request->department)->where('lampa', $request->lampa)->delete())
        return back()->with('success', 'Лампа удалёна');
        else return back()->with('error', 'Не удалось удалить лампу');
    }

    public function newlampa(LampaNewRequest $request) {
        session(['department' => $request->department]);
        $request->duration_all = $request->duration_all*60;
        if ($request->duration_all !== NULL)
        $lampa = Lampalist::updateOrCreate(['lampa' => $request->lampa], $request->all());
        else $lampa = Lampalist::updateOrCreate(['lampa' => $request->lampa], $request->except('duration_all'));
        if ($lampa)
        return back()->with('success', 'Лампа добавлена');
        else return back()->with('error', 'Не удалось добавить лампу');
    }

    public function getlampa(Request $request) {
      $lampas = Lampalist::where('department', $request->dep)->orderBy('lampa', 'asc')->pluck('lampa');
      $data = view('inc.select-lampa', compact('lampas'))->render();
      return response()->json(['options' => $data]);
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
        $duration_all = Lampalist::where('lampa', $request->lampa)->first()->duration_all;
        if (!$duration_all) $duration_all = 0;
        $user = $user->lampa()->Create($request->all() + ['duration' => $duration, 'duration_all' => $duration_all + $duration]);
        Lampalist::where('lampa', $request->lampa)->update(['duration_all' => $duration_all + $duration]);
        if ($duration_all/60 > env('LAMPA_NARABOTKA')) {
          session()->flash('warning', 'Пора заменить лампу <b>'.$request->lampa.'</b> Время наработки: <b>'.round($duration_all/60, 0) .' '. trans_choice('час|часа|часов', round($duration_all/60, 0), [], 'ru').'</b>');
        }
        if ($user) return back()->with('success', 'Режим включения бактерицидной лампы зарегистрирован');
        else return back()->with('error', 'Не удалось зарегистрировать режим включения бактерицидной лампы');
    }

    public function zamena(Request $request) {
      if (Lampalist::where('department', $request->department)->where('lampa', $request->lampa)->update(['duration_all' => 0]))
      return back()->with('success', 'Лампа <b>'.$request->lampa.'</b> подразделения <b>'.$request->department.'</b> заменена. Отсчёт наработки начнётся заново');
    }

    public function narabotka() {
      $items = array();
      $items = Lampalist::groupBy('department', 'lampa')->orderBy('duration_all', 'desc')->get();
      return view('Journals/narabotka-lamp', compact('items'));
    }
}
