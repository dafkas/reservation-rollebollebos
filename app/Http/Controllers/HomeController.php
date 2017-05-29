<?php

namespace App\Http\Controllers;
use App\Date;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Reservation;

class HomeController extends ReservationController
{

    /**
     * HomeController constructor.
     * Extends ReservationController parent construct.
     */
    public function __construct()
    {
        //$this->middleware('auth');

        parent::__construct();


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = reservation::all();
        $data = array('date' => $date);
        $this->dataCollection = array_merge($this->dataCollection, $data);
        return view('dashboard/home')->with($this->dataCollection);
    }

    public function calendar()
    {
        return view('dashboard/calendar')->with($this->dataCollection);
    }

    /**
     * @param $month
     * @param $year
     * @return $this
     */

}
