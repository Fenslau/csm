<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otkazy extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user() {
      return $this->belongsTo(User::class);
    }

    public function reason() {
      return $this->belongsTo(Reason::class);
    }

    public function theme() {
      return $this->belongsTo(Theme::class);
    }

    public function getwhere($request) {
      $stat = $this;
      if (!empty($request->city)) $stat = $stat->whereIn('city', $request->city);
      if (!empty($request->organization)) $stat = $stat->whereIn('organization', $request->organization);
      if (!empty($request->department)) $stat = $stat->whereIn('department', $request->department);
      if (!empty($request->theme_id)) $stat = $stat->whereIn('theme_id', $request->theme_id);
      if (!empty($request->reason_id)) $stat = $stat->whereIn('reason_id', $request->reason_id);
      if (!empty($request->calendar_from)) $stat = $stat->where('created_at', '>=', $request->calendar_from);
      if (!empty($request->calendar_to)) $stat = $stat->where('created_at', '<=', date('Y-m-d', strtotime($request->calendar_to)+60*60*24));
      if (empty($request->calendar_to) AND empty($request->calendar_from)) $stat = $stat->whereMonth('created_at', now()->month);
      return $stat;
    }
}
