<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OtkazRequest;
use App\Http\Requests\ReasonaddRequest;
use App\Http\Requests\ThemeaddRequest;
use App\Models\User;
use App\Models\Otkazy;
use App\Models\Theme;
use App\Models\Reason;
use App\Models\Person;
use App\Models\Organization;

class OtkazController extends Controller
{
    public function main() {
      $themes = $reasons = $items = array();
      $items = Otkazy::with('user', 'reason')->orderBy('created_at', 'desc')->paginate(25);
      $themes = Theme::where('active', 1)->get();
      $reasons = Reason::where('active', 1)->get();
      $cities = Person::distinct()->pluck('city');
      $organizations = Organization::distinct()->pluck('org');
      $departments = Organization::distinct()->pluck('department');

      return view('otkazy', compact('items', 'reasons', 'organizations', 'departments', 'cities', 'themes'));
    }

    public function new(OtkazRequest $request) {
//dd($request->all());
      $user = User::find(auth()->user()->id);
      $otkaz = new Otkazy($request->all());
      $user->otkazy()->save($otkaz);
      if ($user) return back()->with('success', 'Отказ зарегистрирован');
      else return back()->with('error', 'Не удалось зарегистрировать отказ');
    }

    public function statistic(Request $request) {
      $items = array();
      session()->forget(['city', 'organization', 'department', 'group', 'theme', 'reason', 'calendar_from', 'calendar_to']);
      session($request->all());

      $reasons = Reason::where('active', 1)->pluck('reason');
      $themes = Theme::where('active', 1)->pluck('theme');
      $organizations = Organization::distinct()->pluck('org');
      $departments = Organization::distinct()->pluck('department');
      $cities = Person::distinct()->pluck('city');

      return view('stat-otkaz', compact('items', 'reasons', 'organizations', 'departments', 'cities', 'themes'));
    }

    public function editreasons() {
      $items = array();
      $reasons = Reason::where('active', 1)->get();
      return view('otkazy-edit-reasons', compact('reasons'));
    }

    public function editthemes() {
      $items = array();
      $themes = Theme::where('active', 1)->get();
      return view('otkazy-edit-themes', compact('themes'));
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

    public function themeadd(ThemeaddRequest $request) {
      $theme = Theme::updateOrCreate(
        ['theme' => $request->theme],
        ['active' => 1]
    );
      if ($theme) return back()->with('success', 'Новая тема отказа добавлена');
      else return back()->with('error', 'Не удалось добавить тему отказа');
    }

    public function themedel(Request $request) {
      $theme = Theme::find($request->name)->update(['active' => 0]);
      if ($theme) return response()->json( array('success' => true));
      else return response()->json( array('success' => false));
    }
}
