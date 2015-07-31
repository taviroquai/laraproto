
@extends('admin/layout')

@section('style')
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Dashboard</h1>

        <h2>Visits</h2>
        <div id="visitsChart" style="height:300px" ></div>

        <div class="row">
            <div class="col-md-6">
                
                <h2>Most 10 Visited Content</h2>
                <table id="example" class="display table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th class="col-md-1">Visits</th>
                        </tr>
                    </thead>

                    @foreach($most_content as $item)
                    <tr>
                        <td>
                            <a href="{{ url('admin/content/'.$item->id) }}">
                                {{ $item->title }}
                            </a>
                        </td>
                        <td>{{ $item->total }}</td>
                    </tr>
                    @endforeach

                </table>

            </div>
            <div class="col-md-6">
                
                <h2>Less 10 Visited Content</h2>
                <table id="example" class="display table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th class="col-md-1">Visits</th>
                        </tr>
                    </thead>

                    @foreach($less_content as $item)
                    <tr>
                        <td>
                            <a href="{{ url('admin/content/'.$item->id) }}">
                                {{ $item->title }}
                            </a>
                        </td>
                        <td>{{ $item->total }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        
    </div>
</div>
@stop

@section('script')
<script src="{{ asset('assets/js/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.flot.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.flot.time.min.js') }}"></script>
<script type="text/javascript">

    function initVisitsChart(el, data) {
        $.plot($(el), [ { data: data, label: "Visits"} ], {
            series: {
                lines: { show: true,
                         lineWidth: 2,
                         fill: true, fillColor: { colors: [ { opacity: 0.5 }, { opacity: 0.2 } ] }
                      },
                points: { show: true, 
                          lineWidth: 2 
                      },
                shadowSize: 0
            },
            grid: { hoverable: true, 
                    clickable: true, 
                    tickColor: "#f9f9f9",
                    borderWidth: 0
                  },
            colors: ["#3B5998"],
             xaxis: {mode: "time", min: new Date("2015-07-01"), max: new Date("2016-01-01")},
             yaxis: {ticks:3, tickDecimals: 0},
        });

        function showTooltip(x, y, contents) {
            $('<div id="tooltip">' + contents + '</div>').css( {
                position: 'absolute',
                display: 'none',
                top: y + 5,
                left: x + 5,
                border: '1px solid #fdd',
                padding: '2px',
                'background-color': '#dfeffc',
                opacity: 0.80
            }).appendTo("body").fadeIn(200);
        }

        var previousPoint = null;
        $(el).bind("plothover", function (event, pos, item) {
            $("#x").text(pos.x.toFixed(2));
            $("#y").text(pos.y.toFixed(2));

                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2),
                            tdate = new Date(parseInt(x));
                        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                        var year = tdate.getFullYear();
                        var month = months[tdate.getMonth()];
                        var date = tdate.getDate();
                        var x_string = year + '-' + month + '-' + date;
                        showTooltip(item.pageX, item.pageY, item.series.label + " of " + x_string + " = " + y);
                    }
                }
                else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
        });
    }
    
    $.getJSON('{{ url("admin/visits/totals") }}', function (r) {
        initVisitsChart("#visitsChart", r.data);
    });
</script>
@stop
