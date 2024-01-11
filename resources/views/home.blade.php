@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-5">
            <div class="p-3 mr-5 mb-5 text-light col-md-6 col-12 col-lg-3 d-flex align-items-start justify-content-center flex-column rounded rounded-2"
                style="background-image: radial-gradient( circle farthest-corner at 10% 20%,  rgba(100,43,115,1) 0%, rgba(4,0,4,1) 90% ); height: 130px; box-shadow: 10px 10px 6px rgba(100,43,115,.4)">
                <span class="font-weight-bold" style="font-size: 36px">{{ $data['violation_count'] }}</span>
                <span style="font-size: 16px">Pelanggaran Dilakukan Siswa</span>
            </div>
            <div class="p-3 mr-5 mb-5 text-light col-md-6 col-12 col-lg-3 d-flex align-items-start justify-content-center flex-column rounded rounded-2"
                style="background-image: linear-gradient( 111.4deg, rgba(27,24,113,1) 6.5%, rgba(7,7,9,1) 93.2% ); height: 130px; box-shadow: 10px 10px 6px rgba(27,24,113,.4)">
                <span class="font-weight-bold" style="font-size: 36px">{{ $data['achievement_count'] }}</span>
                <span style="font-size: 16px">Prestasi Dicapai Siswa</span>
            </div>
            <div class="p-3 mr-5 mb-5 text-light col-md-6 col-12 col-lg-3 d-flex align-items-start justify-content-center flex-column rounded rounded-2"
                style="background-image: linear-gradient( 99deg,  rgba(115,18,81,1) 10.6%, rgba(28,28,28,1) 118% ); height: 130px; box-shadow: 10px 10px 6px rgba(115,18,81,.4)">
                <span class="font-weight-bold" style="font-size: 36px">{{ $data['task_count'] }}</span>
                <span style="font-size: 16px">Tugas Diselesaikan Siswa</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-12">
                <div class="input-group mb-3">
                    <select class="custom-select" id="select-year">
                        <option value="{{ $data['year_now'] }}">{{ $data['year_now'] }}</option>
                        <option value="{{ $data['one_year_ago'] }}">{{ $data['one_year_ago'] }}</option>
                        <option value="{{ $data['two_year_ago'] }}">{{ $data['two_year_ago'] }}</option>
                    </select>
                    <div class="input-group-append">
                        <label class="input-group-text" for="select-year">Tahun</label>
                    </div>
                </div>
            </div>
        </div>
        <div id="grafik">

        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        import Highcharts from 'https://code.highcharts.com/es-modules/masters/highcharts.src.js';

        const jsonData = JSON.stringify(@json($data))
        const dataWeb = JSON.parse(jsonData)

        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
            'November', 'Desember'
        ]
        
        function generateChart(violations, achievements, tasks) {
            Highcharts.chart('grafik', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Grafik Siswa'
                },
                xAxis: {
                    categories: dataWeb.months
                },
                yAxis: {
                    title: {
                        text: 'Jumlah'
                    }
                },
                series: [{
                    name: 'Pelanggaran',
                    data: violations
                }, {
                    name: 'Prestasi',
                    data: achievements
                }, {
                    name: 'Tugas',
                    data: tasks
                }]
            });
        }

        generateChart(dataWeb.violations, dataWeb.achievements, dataWeb.tasks, dataWeb.months)

        const select = document.querySelector("#select-year")

        select.addEventListener('input', event => {
            let year
            for (let data in dataWeb.all_violation) {
                if (event.target.value === data) {
                    year = data
                }
            }

            let newData = {
                violations: dataWeb.all_violation[`${year}`],
                achievements: dataWeb.all_achievement[`${year}`],
                tasks: dataWeb.all_task[`${year}`],
            }

            // generateDataChart(newData)
            
        })

        function generateDataChart(data) {
            let months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
            let newViolations = []
            let newAchievements = []
            let newTasks = []

            months.foreach(item => {
                newViolations.push(data.violations.filter(item => item.month === item).length());
                newAchievements.push(data.violations.filter(item => item.month === item).length());
                newTasks.push(data.violations.filter(item => item.month === item).length());
            })

            generateChart(newViolations, newAchievements, newTasks)
        }
    </script>
@endpush

