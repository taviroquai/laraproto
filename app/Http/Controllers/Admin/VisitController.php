<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Visit;

class VisitController extends BaseController
{
    
    /**
     * Get visits index
     * 
     * @return \Illuminate\View\View
     */
    public function index()
	{
		return view('admin/visits');
	}
    
    /**
     * Get all visits
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function json()
	{
        $visits = Visit::with('content', 'user')
                ->addSelect(\DB::raw('visits.*, count(id) as visits'))
                ->groupBy('http_url', 'user_id', 'content_id')
                ->orderBy('created_at', 'desc')
                ->get();
		return response()->json(['data' => $visits]);
	}
    
    /**
     * Get visits flot data
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function visitsTotalsJson()
    {
        $totals = \DB::table('visits')
            ->select(\DB::raw('unix_timestamp(created_at) as x, count(id) as y'))
            ->groupBy(\DB::raw('day(created_at)'))
            ->get();
        $data = [];
        foreach ($totals as $item) {
            $data[] = [$item->x.'000', $item->y];
        }
        return response()->json(['data' => $data]);
    }

}
