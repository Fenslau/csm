<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OtkazRequest;
use App\Http\Requests\ReasonaddRequest;
use App\Http\Requests\ThemeaddRequest;
use App\Models\User;
use App\Models\Otkazy;
use App\Models\Department;
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
      $items = $stat->getwhere($request)->with('reason', 'theme')->select('*', DB::raw('MAX(created_at) as maxdate, count(*) as count'))->orderBy('maxdate', 'desc')->groupBy('department', 'theme_id', 'reason_id')->paginate(5000);
      $user_info = $stat->whereIn('created_at', array_column($items->toArray()['data'], 'maxdate'))->orderBy('created_at', 'desc')->get()->toArray();
      $i = 0;
      foreach ($items as &$item) {
        $item->user_id = $user_info[$i]['user_id'];
        $item->organization = $user_info[$i]['organization'];
        $item->city = $user_info[$i]['city'];
        $i++;
      }
      $items->load('user');
      $themes = Theme::where('active', 1)->orderBy('theme', 'asc')->get();
      $reasons = Reason::where('active', 1)->orderBy('reason', 'asc')->get();
      // $cities = Person::distinct()->pluck('city');
      $organizations = Organization::distinct()->orderBy('org', 'asc')->pluck('org');
      // $popular_departments = Otkazy::select('department', DB::raw('count(*) as popular'))->groupBy('department')->orderBy('popular', 'desc')->pluck('department')->toArray();
      // $all_departments = Organization::distinct()->orderBy('department', 'asc')->pluck('department')->toArray();
      // $departments = array_merge($popular_departments, array_diff($all_departments, $popular_departments));

      $cities = Department::distinct()->pluck('city');
      if (isset(auth()->user()->city)) $departments = Department::where('city', auth()->user()->city)->distinct()->pluck('department');
      else $departments = Department::distinct()->pluck('department');
      return view('otkazy', compact('request', 'items', 'reasons', 'organizations', 'departments', 'cities', 'themes'));
    }

    public function getdepartments(Request $request) {
      if ($request->city) {
        $departments = Department::where('city', $request->city)->distinct()->pluck('department');
        $data = view('inc.select-department', compact('departments'))->render();
        return response()->json(['options' => $data]);
      }
    }

    public function new(OtkazRequest $request) {
      $user = User::find(auth()->user()->id);
      session(['department' => $request->department]);
        foreach ($request->department as $department) {
          $otkaz = new Otkazy($request->except('department') + ['department' => $department]);
          if (!$user->otkazy()->save($otkaz)) $fail = TRUE;
        }
      if (!isset($fail)) return back()->with('success', '?????????? ??????????????????????????????');
      else return back()->with('error', '???? ?????????????? ???????????????????????????????? ??????????');
    }

    public function statistic(Request $request) {
      $stat = new Otkazy;
      $our_organizations = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->select('organization', DB::raw('count(*) as count, sum(cost) as cost'))->groupBy('organization')->orderBy('count', 'desc')->get()->toArray();
      foreach ($our_organizations as &$organization) {
          $organization['departments'] = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->where('organization', $organization['organization'])->select('department', DB::raw('count(*) as count, sum(cost) as cost'))->groupBy('department')->get()->toArray();
          $organization['organization'] = str_replace('"', '', $organization['organization']);
      }
      $our_departments = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->select('department', DB::raw('count(*) as count, sum(cost) as cost'))->groupBy('department')->orderBy('count', 'desc')->get();
      foreach ($our_departments as &$department) {
          $department->themes = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->select('*', DB::raw('COUNT(*) as count, sum(cost) as cost'))->where('department', $department->department)->groupBy('theme_id')->orderBy('count', 'desc')->get();

          $department->reasons = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->with('reason')->select('*', DB::raw('COUNT(*) as count, sum(cost) as cost'))->where('department', $department->department)->groupBy('reason_id')->orderBy('count', 'desc')->get();

          $department->dates = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->where('department', $department->department)->orderBy('otkazies.created_at', 'desc')->get(['otkazies.id','otkazies.theme_id','otkazies.reason_id','otkazies.user_id','otkazies.omsdms','otkazies.city','otkazies.organization','otkazies.department','otkazies.created_at','themes.id','themes.theme','themes.cost'])->groupBy(function($date) {
             return Carbon::parse($date->created_at)->format('d.m');
          })->take(30)->reverse();
      }
//dd($our_departments->toArray());
      $our_reasons = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->with('reason')->select('reason_id', DB::raw('count(*) as count, sum(cost) as cost'))->groupBy('reason_id')->orderBy('count', 'desc')->get();
      foreach ($our_reasons as &$reason) {
          $reason->departments = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->select('*', DB::raw('COUNT(*) as count, sum(cost) as cost'))->where('reason_id', $reason->reason_id)->groupBy('department')->orderBy('count', 'desc')->get();
          // $reason->themes = $stat->getwhere($request)->select('*', DB::raw('COUNT(*) as count'))->where('reason_id', $reason->reason_id)->groupBy('theme_id')->orderBy('count', 'desc')->get();
          $reason->dates = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->where('reason_id', $reason->reason_id)->orderBy('otkazies.created_at', 'desc')->get(['otkazies.id','otkazies.theme_id','otkazies.reason_id','otkazies.user_id','otkazies.omsdms','otkazies.city','otkazies.organization','otkazies.department','otkazies.created_at','themes.id','themes.theme','themes.cost'])->groupBy(function($date) {
             return Carbon::parse($date->created_at)->format('d.m');
          })->take(30)->reverse();
      }

      $our_themes = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->with('theme')->select('theme_id', DB::raw('count(*) as count, sum(cost) as cost'))->groupBy('theme_id')->orderBy('count', 'desc')->get();
      foreach ($our_themes as &$theme) {
          $theme->departments = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->select('*', DB::raw('COUNT(*) as count, sum(cost) as cost'))->where('theme_id', $theme->theme_id)->groupBy('department')->orderBy('count', 'desc')->get();
          // $theme->reasons = $stat->getwhere($request)->select('*', DB::raw('COUNT(*) as count'))->where('theme_id', $theme->theme_id)->groupBy('reason_id')->orderBy('count', 'desc')->get();
          $theme->dates = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->where('theme_id', $theme->theme_id)->orderBy('otkazies.created_at', 'desc')->get(['otkazies.id','otkazies.theme_id','otkazies.reason_id','otkazies.user_id','otkazies.omsdms','otkazies.city','otkazies.organization','otkazies.department','otkazies.created_at','themes.id','themes.theme','themes.cost'])->groupBy(function($date) {
             return Carbon::parse($date->created_at)->format('d.m');
          })->take(30)->reverse();
      }
      $our_cities = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->select('city', DB::raw('count(*) as count, sum(cost) as cost'))->groupBy('city')->orderBy('count', 'desc')->get();

      $our_oplata = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->select('omsdms', DB::raw('count(*) as count, sum(cost) as cost'))->groupBy('omsdms')->orderBy('count', 'desc')->get();
      foreach ($our_oplata as &$oplata) {
        $oplata->departments = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->select('*', DB::raw('COUNT(*) as count, sum(cost) as cost'))->where('omsdms', $oplata->omsdms)->groupBy('department')->get()->toArray();
        $oplata->themes = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->select('*', DB::raw('COUNT(*) as count, sum(cost) as cost'))->where('omsdms', $oplata->omsdms)->groupBy('theme_id')->get()->toArray();
        $oplata->reasons = $stat->getwhere($request)->join('themes', 'otkazies.theme_id', 'themes.id')->select('*', DB::raw('COUNT(*) as count, sum(cost) as cost'))->where('omsdms', $oplata->omsdms)->groupBy('reason_id')->get()->toArray();
      }

          $dep_op = array();
          foreach ($our_oplata as $oplata) {
             $dep_op[$oplata->omsdms] = array();
             foreach ($our_departments as $department) {
               if (array_search($department->department, array_column($oplata->departments, 'department')) !== FALSE) $dep_op[$oplata->omsdms][] = $oplata->departments[array_search($department->department, array_column($oplata->departments, 'department'))]['count'];
               else $dep_op[$oplata->omsdms][] = 0;
             }
          }
          $dep_op_cost = array();
          foreach ($our_oplata as $oplata) {
             $dep_op_cost[$oplata->omsdms] = array();
             foreach ($our_departments as $department) {
               if (array_search($department->department, array_column($oplata->departments, 'department')) !== FALSE) $dep_op_cost[$oplata->omsdms][] = $oplata->departments[array_search($department->department, array_column($oplata->departments, 'department'))]['cost'];
               else $dep_op_cost[$oplata->omsdms][] = 0;
             }
          }

          $theme_op = array();
          foreach ($our_oplata as $oplata) {
             $theme_op[$oplata->omsdms] = array();
             foreach ($our_themes as $theme) {
               if (array_search($theme->theme->id, array_column($oplata->themes, 'theme_id')) !== FALSE) $theme_op[$oplata->omsdms][] = $oplata->themes[array_search($theme->theme->id, array_column($oplata->themes, 'theme_id'))]['count'];
               else $theme_op[$oplata->omsdms][] = 0;
             }
          }
          $theme_op_cost = array();
          foreach ($our_oplata as $oplata) {
             $theme_op_cost[$oplata->omsdms] = array();
             foreach ($our_themes as $theme) {
               if (array_search($theme->theme->id, array_column($oplata->themes, 'theme_id')) !== FALSE) $theme_op_cost[$oplata->omsdms][] = $oplata->themes[array_search($theme->theme->id, array_column($oplata->themes, 'theme_id'))]['cost'];
               else $theme_op_cost[$oplata->omsdms][] = 0;
             }
          }

          $reason_op = array();
          foreach ($our_oplata as $oplata) {
             $reason_op[$oplata->omsdms] = array();
             foreach ($our_reasons as $reason) {
               if (array_search($reason->reason->id, array_column($oplata->reasons, 'reason_id')) !== FALSE) $reason_op[$oplata->omsdms][] = $oplata->reasons[array_search($reason->reason->id, array_column($oplata->reasons, 'reason_id'))]['count'];
               else $reason_op[$oplata->omsdms][] = 0;
             }
          }
          $reason_op_cost = array();
          foreach ($our_oplata as $oplata) {
             $reason_op_cost[$oplata->omsdms] = array();
             foreach ($our_reasons as $reason) {
               if (array_search($reason->reason->id, array_column($oplata->reasons, 'reason_id')) !== FALSE) $reason_op_cost[$oplata->omsdms][] = $oplata->reasons[array_search($reason->reason->id, array_column($oplata->reasons, 'reason_id'))]['cost'];
               else $reason_op_cost[$oplata->omsdms][] = 0;
             }
          }

      $reasons = Reason::orderBy('reason')->get();
      $themes = Theme::orderBy('theme')->get();
      $organizations = Organization::distinct()->orderBy('org')->pluck('org');
      // $departments = Organization::distinct()->orderBy('department')->pluck('department');
      // $cities = Person::distinct()->pluck('city');
      $cities = Department::distinct()->pluck('city');
      $departments = Department::distinct()->pluck('department');

      return view('stat-otkaz', compact('our_organizations', 'our_departments', 'our_reasons', 'our_themes', 'our_cities', 'our_oplata', 'request', 'reasons', 'organizations', 'departments', 'cities', 'themes', 'dep_op', 'dep_op_cost', 'theme_op', 'theme_op_cost', 'reason_op', 'reason_op_cost'));
    }

    public function editreasons() {
      $reasons = array();
      $reasons = Reason::where('active', 1)->get();
      return view('otkazy-edit-reasons', compact('reasons'));
    }

    public function editthemes() {
      $themes = array();
      $themes = Theme::where('active', 1)->get();
      return view('otkazy-edit-themes', compact('themes'));
    }

    public function editcosts() {
      $items = array();
      $items = Theme::where('active', 1)->get();
      return view('otkazy-edit-costs', compact('items'));
    }
    public function updatecosts(Request $request) {
      $numeric = TRUE;
      foreach ($request->all() as $key => $value) {
        if (is_numeric($key)) {
          if (is_numeric($value) AND $value >= 0) Theme::find($key)->update(['cost' => $value]);
          elseif ($value) $numeric = FALSE;
        }
      }
      if ($numeric) return back()->with('success', '?????????????????? ?????????????? ??????????????????');
      else return back()->with('warning', '?????????????????? ???????????? ?????????????????? ?????????????????? ???????????????????? ???????????????? ?? ???? ???????? ????????????????');
    }

    public function reasonadd(ReasonaddRequest $request) {
      $reason = Reason::updateOrCreate(
        ['reason' => $request->reason],
        ['active' => 1]
    );
      if ($reason) return back()->with('success', '?????????? ?????????????? ???????????? ??????????????????');
      else return back()->with('error', '???? ?????????????? ???????????????? ?????????????? ????????????');
    }

    public function reasondel(Request $request) {
      $reason = Reason::find($request->name)->update(['active' => 0]);
      if ($reason) return response()->json( array('success' => true));
      else return response()->json( array('success' => false));
    }

    public function themeadd(ThemeaddRequest $request) {
      $theme = Theme::updateOrCreate(
        ['theme' => $request->theme],
        ['active' => 1, 'cost' => $request->cost]
    );
      if ($theme) return back()->with('success', '?????????? ???????? ???????????? ??????????????????');
      else return back()->with('error', '???? ?????????????? ???????????????? ???????? ????????????');
    }

    public function themedel(Request $request) {
      $theme = Theme::find($request->name)->update(['active' => 0]);
      if ($theme) return response()->json( array('success' => true));
      else return response()->json( array('success' => false));
    }
}
