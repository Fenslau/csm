<?php

namespace App\Http\Controllers\Journals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use App\Models\Organization;
use App\Models\Journals\Holod;
use App\Http\Requests\HolodRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HolodController extends Controller
{
    public function main(Request $request) {
      $items = array();
      $stat = new Holod;
      $items = $stat->getwhere($request)->with('user')->orderBy('updated_at', 'desc')->paginate(5000);
      $holodilniks = (['1', '2', '3']);
      $cities = Person::distinct()->pluck('city');
      $organizations = Organization::distinct()->orderBy('org', 'asc')->pluck('org');
      $departments = Organization::distinct()->orderBy('department', 'asc')->pluck('department');
      $our_departments = Holod::distinct()->orderBy('department', 'asc')->pluck('department');
      $our_holodilniks = Holod::distinct()->orderBy('holodilnik', 'asc')->pluck('holodilnik');
      return view('Journals/holod', compact('items', 'organizations', 'departments', 'cities', 'holodilniks', 'request', 'our_departments', 'our_holodilniks'));
  }

  public function new(HolodRequest $request) {
    $user = User::find(auth()->user()->id);
    session(['department' => $request->department, 'temperature' => $request->temperature, 'holodilnik' => $request->holodilnik]);

    $user = $user->holod()->updateOrCreate(['created_at' => today(), 'city' => $request->city, 'organization' => $request->organization, 'department' => $request->department, 'holodilnik' => $request->holodilnik], [$request->time => $request->temperature]);
    if ($user) return back()->with('success', 'Температурный режим зарегистрирован');
    else return back()->with('error', 'Не удалось зарегистрировать температурный режим');
  }
}
