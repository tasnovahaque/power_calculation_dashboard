<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use App\Models\Data;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataController extends Controller
{
    public function index()
    {
        return view('pages.upload_data');
    }
    public function history()
    {
        return view('pages.history', [
            'weekly' => null,
            "monthly" => null
        ]);
    }
    public function calculation()
    {
        return view('pages.calculation');
    }
    public function addDevicePageShow()
    {
        return view('pages.add-device');
    }
    public function import(Request $request)
    {
        Excel::import(new DataImport, $request->file('file'));

        return redirect()->back()->with('success', 'File imported successfully!');
    }
    public function addDevice(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $user->device_id = $request->device_id;
        $user->device_api = $request->device_api;
        $user->save();
        return redirect()->back()->with('success', 'Device Added');
    }
    public function fetchData(Request $request)
    {
        $data = Data::whereBetween('record_time', [$request->start_datetime, $request->end_datetime])->where('device_id', auth()->user()->device_id)->get();
        if($data == null || $data->count() == 0){
            return null;
        }else{
            $total_energy = 0;
            foreach($data as $singleData){
                $total_energy += $singleData->energy;
            }
            $total_current = $total_energy / 220;
            $total_cost = $total_energy * $request->cost;

            return [
                'device_id' => $data[0]->device_id,
                'start_time' => $request->start_datetime,
                'end_time' => $request->end_datetime,
                'total_energy' => $total_energy,
                'total_current' => $total_current,
                'total_cost' => $total_cost,
            ];
        }
    }
    public function getHistoryData(Request $request)
    {
        $device_id = auth()->user()->device_id;
        $data = Data::where('device_id', $device_id)->whereBetween('record_time', [$request->start_datetime, $request->end_datetime])->get();

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
            return view('pages.history', [
                'weekly' => $weeklyResults,
                "monthly" => $monthlyResults
            ]);
        }else{
            return view('pages.history', [
                'weekly' => null,
                "monthly" => null
            ]);
        }
        return view('dashboard');
    }
}
