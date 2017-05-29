<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Date;
use App\Reservation;
use App\Validation;
use Input;

/**
 * Class DateController
 * @package App\Http\Controllers
 */
class DateController extends Controller
{
    public $days;
    public $months;
    public $date;
    public $day;
    public $month;
    public $year;
    public $newYear;
    public $bool;
    public $currentYear;
    public $currentMonth;

    public $first_day;
    public $title;
    public $month_days;
    public $blank;
    public $count;

    /**DateController constructor.
     * Make all calendar variables usable trough whole project
     * Translating English months to Dutch
     **/
    public function __construct()
    {
        $this->date = time('+1 day');
        $this->day = date('j', $this->date);
        $this->month = date('m', $this->date);
        $this->year = date('Y', $this->date);
        $this->currentYear = date('Y', $this->date);

        $this->newYear = 12;
        $this->bool = NULL;

        $this->first_day = mktime(0,0,0,$this->month, 1, $this->year);
        $this->title = date('F', $this->first_day);
        $this->month_days = cal_days_in_month(0, $this->month, $this->year)+ (1);
        $this->blank = date('w', strtotime("{$this->year}-{$this->month}-01"));

        $this->count = reservation::where('available', 2)->count();

        $this->daysOriginal = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $this->daysTranslated = array('Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag');

        $this->monthsOriginal = array('January', 'February', 'March', 'April', 'May', 'June', 'July ',
            'August', 'September', 'October', 'November', 'December');
        $this->monthsTranslated = array('Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli',
            'augustus', 'September', 'Oktober', 'November', 'December');

        $this->dataCollection = array('title' => $this->title, 'year' => $this->year, 'month' => $this->month, 'day' => $this->day,
            'month_days' => $this->month_days, 'blank' => $this->blank ,  'newYear' => $this->newYear, 'bool' => $this->bool,
            'days' => $this->days, 'months' => $this->months, 'count' => $this->count, 'currentYear' => $this->currentYear);

        $this->days = str_replace($this->daysOriginal, $this->daysTranslated, $this->daysTranslated);
        $days["days"] = $this->daysOriginal;
        $this->dataCollection = array_merge($this->dataCollection, $days);

        $this->months = str_replace($this->monthsOriginal, $this->monthsTranslated, $this->monthsTranslated);
        $months["months"] = $this->monthsOriginal;
        $this->dataCollection = array_merge($this->dataCollection, $months);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('dashboard/create')->with($this->dataCollection);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($month)
    {
        $date = date::all();
        $epoch = strtotime($month);
        $data = array('month' => $month, 'epoch' => $epoch, 'date' => $date);
        $this->dataCollection = array_merge($this->dataCollection, $data);
      return view('dashboard/create')->with($this->dataCollection);
    }

    /**
     * Create more days with one click
     * Input from checkboxes from website
     * Then strtotime timestring for example : first monday of December 2017
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAllDays()
    {
        $year = Input::get('year');
        $month = Input::get('month');
        $days = Input::get('days');
        $dayCounter = array('first' ,'second', 'third', 'fourth', 'last');

        foreach($month as $months)
        {
            $month = str_replace($this->monthsTranslated, $this->monthsOriginal, $months);
            foreach($days as $day)
            {
                $d = str_replace($this->daysTranslated, $this->daysOriginal, $day);
                foreach($dayCounter as $dayCount)
                {
                    $g = strtotime($dayCount . " " . $d ." of ". $month . " ". $year);

                    $date = Reservation::updateOrCreate(array('date' => $g, 'available' => 1));
                }
            }
        }
        return redirect()->back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $date = new reservation;
          $date->date = Input::get('date');
          $date->available = true;
          $date->timestamps = false;
          $date->save();
          return redirect()->action('HomeController@calendar');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showDate($id, $month)
    {
        $customerData = reservation::find($id);
        $data = array('month' => $month, 'customerData' => $customerData);
        $this->dataCollection = array_merge($this->dataCollection, $data);
        return view('dashboard/show')->with($this->dataCollection);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validation($id){
        $validate = reservation::find($id);
        $validate->available = NULL;
        $validate->timestamps = NULL;
        $validate->save();
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customerData = reservation::find($id);
        $data = array('customerData' => $customerData);
        $this->dataCollection = array_merge($this->dataCollection, $data);
        return view('dashboard/edit')->with($this->dataCollection);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customerData = reservation::find($id);
        $customerData->customer_name = Input::get('customer_name');
        $customerData->customer_email = Input::get('customer_email');
        $customerData->customer_phone = Input::get('customer_phone');
        $customerData->description = Input::get('description');
        $customerData->amount = Input::get('amount');
        $customerData->option = Input::get('number');
        if($customerData->option == "") {
            $customerData->option = NULL;
        }
        $customerData->timestamps = false;
        $customerData->save();
        $date = date('j-F-y', $customerData->date);

        return redirect()->action('DateController@showDate', [$customerData->id, $date]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $date = reservation::find($id);
        $date->delete();

        return redirect()->action('HomeController@calendar');
    }
}
