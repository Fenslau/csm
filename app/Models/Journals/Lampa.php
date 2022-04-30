<?php

namespace App\Models\Journals;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Lampa extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
      return $this->belongsTo(User::class);
    }

    public function getwhere($request) {
      $stat = $this;
      if (!empty($request->city)) $stat = $stat->where('city', $request->city);
      if (!empty($request->department)) $stat = $stat->where('department', $request->department);
      elseif (!empty(session('department'))) $stat = $stat->where('department', session('department'));
      elseif (auth()->user()) $stat = $stat->where('department', auth()->user()->department);

      if (!empty($request->lampa)) $stat = $stat->where('lampa', $request->lampa);
      elseif (!empty(session('lampa'))) $stat = $stat->where('lampa', session('lampa'));
      if (!empty($request->calendar_from)) $stat = $stat->where('updated_at', '>=', $request->calendar_from);
      if (!empty($request->calendar_to)) $stat = $stat->where('updated_at', '<=', date('Y-m-d', strtotime($request->calendar_to)+60*60*24));
      if (empty($request->calendar_to) AND empty($request->calendar_from)) $stat = $stat->whereMonth('updated_at', now()->month);
      return $stat;
    }

}
