@extends('layouts.app')

@section('content')
<div class="container">
    

    <div class="row p-2">
        <div class="p-3 mr-5 mb-5 text-light col-md-6 col-12 col-lg-3 d-flex align-items-start justify-content-center flex-column rounded rounded-2" style="background-image: radial-gradient( circle farthest-corner at 10% 20%,  rgba(100,43,115,1) 0%, rgba(4,0,4,1) 90% ); height: 130px; box-shadow: 10px 10px 6px rgba(100,43,115,.4)">
            <span class="font-weight-bold" style="font-size: 36px">{{ $violation_count }}</span>
            <span style="font-size: 16px">Jumlah Pelanggaran Dilakukan</span>
        </div>
        <div class="p-3 mr-5 mb-5 text-light col-md-6 col-12 col-lg-3 d-flex align-items-start justify-content-center flex-column rounded rounded-2" style="background-image: linear-gradient( 111.4deg, rgba(27,24,113,1) 6.5%, rgba(7,7,9,1) 93.2% ); height: 130px; box-shadow: 10px 10px 6px rgba(27,24,113,.4)">
            <span class="font-weight-bold" style="font-size: 36px">{{ $achievment_count }}</span>
            <span style="font-size: 16px">Jumlah Prestasi Dicapai</span>
        </div>
        <div class="p-3 mr-5 mb-5 text-light col-md-6 col-12 col-lg-3 d-flex align-items-start justify-content-center flex-column rounded rounded-2" style="background-image: linear-gradient( 99deg,  rgba(115,18,81,1) 10.6%, rgba(28,28,28,1) 118% ); height: 130px; box-shadow: 10px 10px 6px rgba(115,18,81,.4)">
            <span class="font-weight-bold" style="font-size: 36px">{{ $task_count }}</span>
            <span style="font-size: 16px">Jumlah Tugas Diselesaikan</span>
        </div>
        <div class="p-3 mr-5 mb-5 text-light col-md-6 col-12 col-lg-3 d-flex align-items-start justify-content-center flex-column rounded rounded-2" style="background-image: radial-gradient( circle farthest-corner at 10% 20%,  rgba(0,107,141,1) 0%, rgba(0,69,91,1) 90% ); height: 130px; box-shadow: 10px 10px 6px rgba(0,107,141,.4)">
            <span class="font-weight-bold" style="font-size: 36px">{{ $student_count }}</span>
            <span style="font-size: 16px">Jumlah Siswa</span>
        </div>
        <div class="p-3 mr-5 mb-5 text-light col-md-6 col-12 col-lg-3 d-flex align-items-start justify-content-center flex-column rounded rounded-2" style="background-image: radial-gradient( circle 610px at 5.2% 51.6%,  rgba(5,8,114,1) 2%, rgba(7,3,53,1) 97.5% ); height: 130px; box-shadow: 10px 10px 6px rgba(5,8,114,.4)">
            <span class="font-weight-bold" style="font-size: 36px">{{ $teacher_count }}</span>
            <span style="font-size: 16px">Jumlah Guru</span>
        </div>
    </div>
</div>
@endsection
