@extends('layouts.app')

@section('content')
<div class="container py-4 animate__animated animate__fadeInUp">
    <h3 class="text-center mb-4 fw-bold text-primary">{{ $title }}</h3>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-lg p-3 bg-gradient" style="background: linear-gradient(to right, #f6d365, #fda085); border-radius: 20px;">
                <div class="card-body">
                    <h5 class="text-black text-center fw-bold">Grafik status invoice</h5>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-lg p-3 bg-gradient" style="background: linear-gradient(to right, #a18cd1, #fbc2eb); border-radius: 20px;">
                <div class="card-body">
                    <h5 class="text-white text-center">Bar Chart</h5>
                    <canvas id="myChartBar"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
<!-- Optional Animate.css (for smooth animation) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const pieConfig = {
    type: 'pie',
    data: {
        labels: ['Terbayar', 'Belum Terbayar'],
        datasets: [{
            label: 'Invoices Status',
            data: [{{ $terbayar }}, {{ $belumTerbayar }}],
            backgroundColor: ['#00C9A7', '#FF6B6B'],
            borderWidth: 2,
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Perbandingan Invoice Terbayar vs Belum Terbayar',
                color: '#ffffff',
                font: {
                    size: 16,
                    weight: 'bold'
                },
                padding: {
                    top: 10,
                    bottom: 10
                }
            },
            legend: {
                position: 'bottom',
                labels: {
                    color: '#fff',
                    font: {
                        weight: 'bold'
                    }
                }
            }
        },
        animation: {
            animateRotate: true,
            duration: 1500
        }
    }
};

const barConfig = {
    type: 'bar',
    data: {
        labels: ['Terbayar', 'Belum Terbayar'],
        datasets: [{
            label: 'Invoices Status',
            data: [{{ $terbayar }}, {{ $belumTerbayar }}],
            backgroundColor: ['#51cf66', '#ff922b'],
            borderRadius: 10
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Statistik Jumlah Invoice',
                color: '#000',
                font: {
                    size: 16,
                    weight: 'bold'
                },
                padding: {
                    top: 10,
                    bottom: 10
                }
            }
        },
        animation: {
            duration: 1200,
            easing: 'easeOutBounce'
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
};


    new Chart(document.getElementById('myChart'), pieConfig);
    new Chart(document.getElementById('myChartBar'), barConfig);
});
</script>
@endpush
