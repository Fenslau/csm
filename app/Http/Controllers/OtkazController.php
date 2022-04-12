<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OtkazRequest;
use App\Http\Requests\ReasonaddRequest;
use App\Models\User;
use App\Models\Otkazy;
use App\Models\Reason;
use App\Models\Organization;
use App\Models\Person;

class OtkazController extends Controller
{
    public function main() {
      $reasons = $items = array();
      $items = Otkazy::with('user', 'reason')->orderBy('created_at', 'desc')->paginate(25);
      $reasons = Reason::where('active', 1)->get();
      $organizations = Organization::distinct()->pluck('org');
      $divisions = Organization::distinct()->pluck('department');
      $cities = Person::distinct()->pluck('city');
      return view('otkazy', compact('items', 'reasons', 'organizations', 'divisions', 'cities'));
    }

    public function new(OtkazRequest $request) {
      $user = User::find(auth()->user()->id);
      $otkaz = new Otkazy($request->all());
      $user->otkazy()->save($otkaz);
      if ($user) return back()->with('success', 'Отказ зарегистрирован');
      else return back()->with('error', 'Не удалось зарегистрировать отказ');
    }

    public function stat(Request $request) {
      $items = array();
      session()->forget(['city', 'organization', 'division', 'group', 'theme', 'reason', 'calendar_from', 'calendar_to']);
      session($request->all());

      return view('stat-otkaz', compact('items'));
    }

    public function editreasons() {
      $items = array();
      $reasons = Reason::where('active', 1)->get();
      return view('otkazy-edit-reasons', compact('reasons'));
    }

    public function editcosts() {
      $items = array();
      $reasons = Reason::where('active', 1)->get();
      return view('otkazy-edit-costs', compact('items'));
    }

    public function reasonadd(ReasonaddRequest $request) {
      $reason = Reason::updateOrCreate(
        ['reason' => $request->reason],
        ['active' => 1]
    );
      if ($reason) return back()->with('success', 'Новая причина отказа добавлена');
      else return back()->with('error', 'Не удалось добавить причину отказа');
    }

    public function reasondel(Request $request) {
      $reason = Reason::find($request->name)->update(['active' => 0]);
      if ($reason) return response()->json( array('success' => true));
      else return response()->json( array('success' => false));
    }
}
