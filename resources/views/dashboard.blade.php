
@extends('layouts.app')

@section('content')
    <h3>{{ $title }}</h3>
    <div class="row">
        <div class="col-md-6">
    <canvas id="myChart"></canvas>
        </div>
        <div class="col-md-6">
    <canvas id="myChartBar"></canvas>
        </div>
    @endsection

    @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart (
        document.getElementById('myChart'),
        {
                        type:'pie',
                        data: {
                        labels:[
                        'Terbayar',
                        'Belum Terbayar',
                        ],
            datasets: [
                    {
                        label: 'Invoices Status',
                        data: [{{$terbayar}}, {{$belumTerbayar}}],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                        ],
                        borderColor: [
                            'rgb(0, 0, 0)',
                            'rgb(0, 0, 0)', 
                        ],
                        hoverOffset: 4,
                    }
                ]
            }  
        }
        
    );
     new Chart (
        document.getElementById('myChartBar'),
        {
                        type:'bar',
                        data: {
                        labels:[
                        'Terbayar',
                        'Belum Terbayar',
                        ],
            datasets: [
                    {
                        label: 'Invoices Status',
                        data: [{{$terbayar}}, {{$belumTerbayar}}],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                        ],
                        borderColor: [
                            'rgb(0, 0, 0)',
                            'rgb(0, 0, 0)', 
                        ],
                        hoverOffset: 4,
                    }
                ]
            }  
        }
        
    );
});
</script>

