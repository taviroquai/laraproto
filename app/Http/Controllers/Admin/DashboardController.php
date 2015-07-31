<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Visit;

class DashboardController extends BaseController
{
    
    public function index()
	{
        $most_content = \DB::table('visits')
            ->select(\DB::raw('count(contents.id) as total, contents.id, contents.title'))
            ->join('contents', 'contents.id', '=', 'visits.content_id')
            ->whereNotNull('content_id')
            ->take(10)
            ->get();
        $less_content = \DB::table('visits')
            ->select(\DB::raw('count(contents.id) as total, contents.id, contents.title'))
            ->join('contents', 'contents.id', '=', 'visits.content_id')
            ->whereNotNull('content_id')
            ->take(10)
            ->get();
		return view('admin/dashboard', compact('most_content', 'less_content'));
	}

}
