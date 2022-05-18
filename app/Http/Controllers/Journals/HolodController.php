<?php

namespace App\Http\Controllers\Journals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use App\Models\Organization;
use App\Models\Journals\Holod;
use App\Models\Journals\Holodlist;
use App\Models\Department;
use App\Http\Requests\HolodRequest;
use App\Http\Requests\HolodNewRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HolodController extends Controller
{
    public function main(Request $request) {
      $items = array();
      $stat = new Holod();
      $items = $stat->getwhere($request)->with('user')->orderBy('updated_at', 'desc')->paginate(5000);
      $holodilniks = (['1', '2', '3', '4', '5', '6']);
      $cities = Person::distinct()->pluck('city');
      $organizations = Organization::distinct()->orderBy('org', 'asc')->pluck('org');
      $departments = Holodlist::distinct()->orderBy('department', 'asc')->pluck('department');
      $our_departments = Holodlist::distinct()->orderBy('department', 'asc')->pluck('department');
      $our_holodilniks = Holodlist::distinct()->orderBy('holodilnik', 'asc')->pluck('holodilnik');
      return view('Journals/holod', compact('items', 'organizations', 'departments', 'cities', 'holodilniks', 'request', 'our_departments', 'our_holodilniks'));
  }

  public function list() {
      $items = array();
      $items = Holodlist::orderBy('created_at', 'desc')->get();
      if (isset(auth()->user()->city)) $departments = Department::where('city', auth()->user()->city)->distinct()->pluck('department');
      else $departments = Department::distinct()->pluck('department');
      return view('Journals/holod-list', compact('items', 'departments'));
  }

  public function del(Request $request) {
      if (Holodlist::where('department', $request->department)->where('holodilnik', $request->holodilnik)->delete())
      return back()->with('success', 'Холодильник удалён');
      else return back()->with('error', 'Не удалось удалить холодильник');
  }

  public function newholod(HolodNewRequest $request) {
      session(['department' => $request->department]);
      if (Holodlist::where('department', $request->department)->where('holodilnik', $request->holodilnik)->first())
      return back()->with('warning', 'Такой холодильник уже существует в подразделении '.$request->department);
      else {
        if (Holodlist::Create(['department' => $request->department, 'holodilnik' => $request->holodilnik]))
        return back()->with('success', 'Холодильник добавлен');
        else return back()->with('error', 'Не удалось добавить холодильник');
      }
  }

  public function getholodilnik(Request $request) {
    $holodilniks = Holodlist::where('department', $request->dep)->orderBy('holodilnik', 'asc')->pluck('holodilnik');
    if ($request->select) {
      $data = view('inc.select-holodilnik', compact('holodilniks'))->render();
    }
    else {
      $data = view('inc.radio-holodilnik', compact('holodilniks'))->render();
    }
    return response()->json(['options' => $data]);
  }

  public function new(HolodRequest $request) {
    $user = User::find(auth()->user()->id);
    session(['department' => $request->department, 'temperature' => $request->temperature, 'holodilnik' => $request->holodilnik]);

    $user = $user->holod()->updateOrCreate(['created_at' => today(), 'city' => $request->city, 'organization' => $request->organization, 'department' => $request->department, 'holodilnik' => $request->holodilnik], [$request->time => $request->temperature]);
    if ($user) return back()->with('success', 'Температурный режим зарегистрирован');
    else return back()->with('error', 'Не удалось зарегистрировать температурный режим');
  }
}
