<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $device_id = auth()->user()->device_id;
        $data = Data::where('device_id', $device_id)->get();

        if($data){  
            $dataCollection = collect($data);

            $monthlyData = $dataCollection->groupBy(function ($item) {
                return Carbon::parse($item['record_time'])->format('m');
            });
            $monthlyResults = $monthlyData->map(function ($monthData) {
                $totalEnergy = $monthData->sum('energy'); 
                $totalCurrent = $monthData->sum('current'); 
                
                $averageEnergy = $totalEnergy / $monthData->count();
                $averageCurrent = $totalCurrent / $monthData->count();
            
                return [
                    'average_energy' => number_format($averageEnergy, 2),
                    'average_current' => number_format($averageCurrent, 2),
                ];
            });

            $weeklyData = $dataCollection->groupBy(function ($item) {
                return Carbon::parse($item['record_time'])->format('l'); 
            });
            $weeklyResults = $weeklyData->map(function ($dayData) {
                $totalEnergy = $dayData->sum('energy'); 
                $averageEnergy = $totalEnergy / $dayData->count(); 
            
                $totalCurrent = $dayData->sum('current'); 
                $averageCurrent = $totalCurrent / $dayData->count(); 

                return [
                    'average_energy' => number_format($averageEnergy, 2), 
                    'average_current' => number_format($averageCurrent, 2), 
                ];
            });
            return view('dashboard', [
                'weekly' => $weeklyResults,
                "monthly" => $monthlyResults
            ]);
        }else{
            return null;
        }
        return view('dashboard');
    }
}
