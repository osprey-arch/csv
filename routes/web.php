<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    
    return view('welcome',[
        'users' => App\Models\User::all()
    ]);
});
Route::post('import', function () {
    
    $fileName = time().'_'.request()->file->getClientOriginalName();
    request()->file('file')->storeAs('reports', $fileName, 'public');
    
    Excel::import(new UsersImport, request()->file('file'));
    return redirect()->back()->with('success','Data Imported Successfully');
});

Route::get('export-csv', function () {
    return Excel::download(new UsersExport, 'users.csv');
});