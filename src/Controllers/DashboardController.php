<?php

namespace Abelvan\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController
{
    private $models;

    public function greet(String $name)
    {
        dd(__DIR__.'/../Con/dashboard.php');
        return 'Hi ' . $name . '! Sample route working';
    }

    public function dashboard()
    {
        $models = config('AbelvanDashboard.models-table');
        $modelCounts = config('AbelvanDashboard.models-count-card');
        $toChartDatas = config('AbelvanDashboard.chart-data');
        $cardBackgroundColor = config('AbelvanDashboard.card-background-color');
        $tableStyles = config('AbelvanDashboard.table.table-style');
        $tableSearch = config('AbelvanDashboard.table.table-search');
        $tableBackgroundColor = config('AbelvanDashboard.table.table-color');
        $tableTextColor = config('AbelvanDashboard.table.table-text-color');
        $backgroundColor = config('AbelvanDashboard.background-color');
        $navbar = config('AbelvanDashboard.navbar');
        $modelDatas = [];
        $getTotalCount = [];
        $modelNames = [];
        $columns = [];
        $modelPaths = [];
        foreach ($models as $model => $column) {
            $modelPaths[] = $model;
            $modelNames[] = substr($model, strrpos($model, '\\' )+1);
            $columns[] = $column;
            $modelDatas[] = $model::latest()->take(5)->orderBy('created_at','desc')->get();
            
        }
        foreach ($modelCounts as $model) {
            $getTotalCount[] = $model::count();
        }

        foreach($toChartDatas as $toChartData) {
            $chartData[] = [substr($toChartData, strrpos($toChartData, '\\' )+1), $toChartData::count()];
        }

        return view('Abelvan::dashboard',compact('backgroundColor', 'modelCounts', 'models','modelNames','modelDatas', 'getTotalCount', 'columns', 'cardBackgroundColor', 'tableStyles', 'modelPaths', 'tableSearch', 'tableBackgroundColor', 'tableTextColor', 'chartData', 'navbar'));
    }

    public function searchData(Request $request)
    {
        $tableName = $request->table;
        $keyword = $request->data;
        $columns = explode(' ',$request->columns);
        $getData =  $tableName::where(function($q) use($columns, $keyword){
            foreach ($columns as $key => $value) {
                $searchedDatas = $q->orWhere($value,'like','%'.$keyword.'%');
            }
            return $searchedDatas;
        });
        $getData = $getData->select($columns)->take(5)->orderBy('created_at','desc')->get();
        return response()->json(['getData' => $getData, 'columns' => $columns, 'modelName' => $request->model_name]);
    }
}