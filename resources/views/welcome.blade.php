@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reservering kinderverjaardag {{ $year }}</div>
                <div class="panel-body">
                    <p></p>
                    <div style="margin-bottom: 2px;">
                            <a href="/" class="btn btn-default btn-sm">Vandaag</a>
                    </div>
                        <ul class="nav nav-pills nav-justified">
                            @foreach($months as $key => $monthly)
                                @if($month == $key + 1)

                                    <li class="active"><a href="{{$key + 1}}-{{$year}}">{{$monthly}}</a></li>
                                @else
                                    @if($key == 5)
                        </ul>
                        <ul class="nav nav-pills nav-justified">
                                    @endif
                                    <li class="month-tab"><a href="{{$key + 1}}-{{$year}}">{{$monthly}}</a></li>

                                @endif

                            @endforeach
                        </ul>
                  <table class="calendar">
                    <tr>
                      <th>
                      </th>
                    </tr>

                    <tr>
                      <td class="weekday">Zo</td>
                      <td class="weekday">Ma</td>
                      <td class="weekday" >Di</td>
                      <td class="weekday">Wo</td>
                      <td class="weekday">Do</td>
                      <td class="weekday">Vr</td>
                      <td class="weekday">Za</td>
                    </tr>

                      @for($i = 0; $i < $blank; $i++)
                        <td class="blank">
                        </td>
                      @endfor
                      @for($i = 1; $i < $month_days; $i++)
                        @php
                        $availableDate = $i. "-".$title."-".$year;

                        $show = false;
                          foreach($available as $availables => $date){
                            foreach($s as $v => $c){
                              if($availableDate == $date AND $c == 1 AND $v == $availables){
                                @endphp<td class="day" id="dayEvent" style="background-color:mediumseagreen;"><a href="reservation/create/{{$availables}}/{{$date}}">{{$i}}<br /></a></td>@php
                                $show = true;
                               }
                               elseif($availableDate == $date AND $c == 2 AND $v == $availables){
                                @endphp<td class="day" id="dayEvent" style="background-color:yellow;">{{$i}}<br /></td>@php
                                $show = true;
                              }
                              elseif($availableDate == $date AND $c == NULL AND $v == $availables){
                                @endphp<td class="day" id="dayEvent" style="background-color:indianred;">{{$i}}<br /></td>@php
                                $show = true;
                              }
                              }
                           }
                        if($show == true){}
                        else{
                          if($day == $i)
                          @endphp<td class="day" id="dayEvent">@if($day == $i)<b><u>{{$i}}</u></b>@else{{$i}}@endif<br /></td><?php
                        }?>
                        @if(($i + $blank) % 7 == 0)
                      </tr><tr>
                        @else
                        @endif
                      @endfor
                    @for($i = 6; ($i + $blank + $month_days) % 7 != 0; $i++)
                    <td class="blank"></td>
                    @endfor

                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
