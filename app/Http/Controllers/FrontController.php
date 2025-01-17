<?php

namespace App\Http\Controllers;

use App\Models\CarService;
use App\Models\City;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //

    public function __construct() {}

    public function index()
    {
        $cities = City::all();

        $services = CarService::all();
        return view('front.index', compact('cities', 'services'));
    }
}
