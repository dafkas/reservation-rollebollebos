<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Date;
use App\Reservation;
use App\Mail\ReservationConfirmation;
use Auth;
use Input;

/**
 * Class ReservationController
 * @package App\Http\Controllers
 */
class ReservationController extends DateController
{
    /**
     * @return $this
     */
    public $data;
    public $query;
    public $available;
    public $s;
    public $var;
    public $dataCollection;

    /**
     * ReservationController constructor.
     * Make all variables and load parent constructor DateController
     */
    public function __construct()
    {
        parent::__construct();

        $this->data = DB::table('reservations')->pluck('date', 'id');
        $this->query = DB::table('reservations')->pluck('available', 'id');
        $this->available = [];
        $this->s = [];
        $this->var = json_decode($this->data);
        foreach($this->var as $a => $id){
            $this->available[$a] = date("j-F-Y", $id);
            $b = json_decode($this->query);
            foreach($b as $c => $vailable){
                $this->s[$c] = $vailable;
            }
        }
        $this->dataCollection = array('title' => $this->title, 'year' => $this->year, 'month' => $this->month, 'day' => $this->day,
            'month_days' => $this->month_days, 'blank' => $this->blank ,  'newYear' => $this->newYear, 'bool' => $this->bool,
            'days' => $this->days, 'months' => $this->months, 'available' => $this->available, 's' => $this->s, 'count' => $this->count);

        if($this->month == 11 || $this->month == 12){
            $this->year = $this->year + 1;
            $this->month = 1;
            $this->first_day = mktime(0,0,0,$this->month, 1, $this->year);
            $this->title = date('F', $this->first_day);
            $this->month_days = cal_days_in_month(0, $this->month, $this->year)+ (1);
            $this->blank = date('w', strtotime("{$this->year}-{$this->month}-01"));
            $data = array('year' => $this->year, 'month' => $this->month, 'title' => $this->title, 'month_days' => $this->month_days, 'blank' => $this->blank);
            $this->dataCollection = array_merge($this->dataCollection, $data);
        }
    }

    /**
     * Return welcome page.
     * @return $this
     */
    public function index()
    {

      return view('welcome')->with($this->dataCollection);
    }

    /**
     * Swap between months
     * @param $month
     * @param $year
     * @return $this
     */

    public function swapMonths($month, $year)
    {
        $blank = date('w', strtotime("{$year}-{$month}-01"));
        $month_days = cal_days_in_month(0, $month, $year) + (1);
        $epoch = mktime(0, 0, 0, $month);
        $title =  date('F', $epoch);
        $data = array('month' => $month, 'year' => $year, 'title' => $title, 'blank' => $blank, 'month_days' => $month_days);
        $this->dataCollection = array_merge($this->dataCollection, $data);
        $page = "welcome";
        if($user = Auth::user())
        {
            $page = "dashboard/calendar";
        }
        return view($page)->with($this->dataCollection);
    }
   /**
    * Jump to month function still working on this...
    * Trying to switch between months without showing this in the URL
    * @return $this
    **/
    public function jumpToMonth()
    {
        $jumpMonth = Input::get('jumpMonth');
        $blank = date('w', strtotime("{$this->year}-{$jumpMonth}-01"));
        $month_days = cal_days_in_month(0, $jumpMonth, $this->year) + (1);
        $epoch = mktime(0, 0, 0, $jumpMonth);
        $title =  date('F', $epoch);
        $page = "welcome";
        if($user = Auth::user())
        {
            $page = "dashboard/calendar";
        }
        $data = array('month' => $jumpMonth, 'title' => $title, 'blank' => $blank, 'month_days' => $month_days);
        $this->dataCollection = array_merge($this->dataCollection, $data);

        return view($page)->with($this->dataCollection);
    }

    /**
     * Create reservation with datestring EPOCH
     * @param $id
     * @param $available
     * @return $this
     */
    public function createReservation($id, $available){
      $dateString = strtotime($available);
      $reservation = reservation::find($id);
      $data = array('available' => $available, 'dateString' => $dateString,
        'reservation' => $reservation, 'id' => $id);
      $this->dataCollection = array_merge($this->dataCollection, $data);
      return view('create')->with($this->dataCollection);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReservation($id){
      $reservation = reservation::find($id);
      $reservation->customer_name = Input::get('customer_name');
      $reservation->customer_email = Input::get('customer_email');
      $reservation->customer_phone = Input::get('customer_phone');
      $reservation->description = Input::get('description');
      $reservation->amount = Input::get('amount');
      $reservation->option = Input::get('number');

      if($reservation->option == "") {
            $reservation->option = NULL;
      }

      $reservation->date = Input::get('date');
      $reservation->available = 2;
      $reservation->timestamps = false;
      $reservation->save();

//      Mail::to($reservation->customer_email)->send(new ReservationConfirmation);


      return redirect()->action('ReservationController@index');
    }
}
