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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OtkazController extends Controller
{
    public function main(Request $request) {
      $themes = $reasons = $items = array();
      $stat = new Otkazy;
      //$items = Otkazy::with('user', 'reason')->orderBy('created_at', 'desc')->paginate(25);
      $items = $stat->getwhere($request)->with('reason', 'theme', 'user')->select('*', DB::raw('MAX(created_at) as maxdate, count(*) as count'))->orderBy('maxdate', 'desc')->groupBy('department', 'theme_id', 'reason_id')->paginate(5000);
      $themes = Theme::where('active', 1)->orderBy('theme', 'asc')->get();
      $reasons = Reason::where('active', 1)->orderBy('reason', 'asc')->get();
      $cities = Person::distinct()->pluck('city');
      $organizations = Organization::distinct()->orderBy('org', 'asc')->pluck('org');
      $departments = Organization::distinct()->orderBy('department', 'asc')->pluck('department');

      return view('otkazy', compact('request', 'items', 'reasons', 'organizations', 'departments', 'cities', 'themes'));
    }

    public function getdepartments(Request $request) {
      if ($request->org) {
        $departments = Organization::where('org', $request->org)->distinct()->orderBy('department', 'asc')->pluck('department');
        $data = view('inc.select-department', compact('departments'))->render();
        return response()->json(['options' => $data]);
      }
    }

    public function new(OtkazRequest $request) {
      $user = User::find(auth()->user()->id);
      session(['call' => $request->call]);
      $otkaz = new Otkazy($request->except('call'));
      $user->otkazy()->save($otkaz);
      if ($user) return back()->with('success', 'Отказ зарегистрирован');
      else return back()->with('error', 'Не удалось зарегистрировать отказ');
    }

    public function statistic(Request $request) {
      $items = array();
      $stat = new Otkazy;
      $our_organizations = $stat->getwhere($request)->select('organization', DB::raw('count(*) as count'))->groupBy('organization')->get()->toArray();
      foreach ($our_organizations as &$organization) {
          $organization['departments'] = $stat->getwhere($request)->where('organization', $organization['organization'])->select('department', DB::raw('count(*) as count'))->groupBy('department')->get()->toArray();
          $organization['organization'] = str_replace('"', '', $organization['organization']);
      }

      $our_reasons = $stat->getwhere($request)->with('reason')->select('reason_id', DB::raw('count(*) as count'))->groupBy('reason_id')->orderBy('count', 'desc')->get();
      foreach ($our_reasons as &$reason) {
          $reason->dates = $stat->getwhere($request)->where('reason_id', $reason->reason_id)->orderBy('created_at', 'desc')->get()->groupBy(function($date) {
             return Carbon::parse($date->created_at)->format('d.m');
          })->take(30)->reverse();
      }

      $our_themes = $stat->getwhere($request)->with('theme')->select('theme_id', DB::raw('count(*) as count'))->groupBy('theme_id')->orderBy('count', 'desc')->get();
      foreach ($our_themes as &$theme) {
          $theme->dates = $stat->getwhere($request)->where('theme_id', $theme->theme_id)->orderBy('created_at', 'desc')->get()->groupBy(function($date) {
             return Carbon::parse($date->created_at)->format('d.m');
          })->take(30)->reverse();
      }

      $reasons = Reason::orderBy('reason')->get();
      $themes = Theme::orderBy('theme')->get();
      $organizations = Organization::distinct()->orderBy('org')->pluck('org');
      $departments = Organization::distinct()->orderBy('department')->pluck('department');
      $cities = Person::distinct()->pluck('city');

      return view('stat-otkaz', compact('our_organizations', 'our_reasons', 'our_themes', 'request', 'items', 'reasons', 'organizations', 'departments', 'cities', 'themes'));
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
