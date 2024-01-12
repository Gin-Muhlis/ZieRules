@extends('layouts.app')

@push('styles')
    <style>
        .area-data::-webkit-scrollbar {
            width: 3px;
        }

        .area-data::-webkit-scrollbar-track {
            background-color: #ffc34e;
        }

        .area-data::-webkit-scrollbar-thumb {
            background-color: #e9ae3a;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row position-relative" style="background-image: linear-gradient(114deg, #1a0e7e, #2c37f5); height: 250px;">

        </div>
        <div class="px-2 row row-cols-md-2 row-cols-1 align-items-start  justify-content-center"
            style="transform: translateY(-80px)">
            <div class="bg-white shadow shadow-sm rounded rounded-3 mr-md-4 mb-5 col-md-3 col py-2">
                <div class="d-flex flex-column w-100 align-items-center justify-content-center px-2 py-3 mb-5">
                    <img src="{{ Storage::url($student->image) ?? 'public/default.jpg' }}" class="rounded rounded-circle bg-primary mb-2" alt="Gambar siswa" style="width: 100px; height: 100px; object-fit: cover;">
                    <span class="font-weight-bold" style="font-size: 18px">{{ $student->name ?? '-' }}</span>
                    <span class="font-italic" style="opacity: 70%; font-size: 15px;">{{ $student->nis ?? '-' }}</span>
                </div>
                <div class="px-2 mb-3">
                    <div class="d-flex flex-column align-items-start justify-content-start w-100 pb-3 mb-3"
                        style="border-bottom: 1px solid #e9ae3a">
                        <span class="mb-1" style="font-size: 14px">Gender :</span>
                        <span class="font-weight-bold" style="font-size: 16px">{{ $student->gender ?? '-' }}</span>
                    </div>
                </div>
                <div class="px-2 mb-3">
                    <div class="d-flex flex-column align-items-start justify-content-start w-100 pb-3 mb-3"
                        style="border-bottom: 1px solid #e9ae3a">
                        <span class="mb-1" style="font-size: 14px">Kelas :</span>
                        <span class="font-weight-bold" style="font-size: 16px">{{ $student->class?->code ?? '-' }}</span>
                    </div>
                </div>
                <div class="px-2 mb-3">
                    <div class="d-flex flex-column align-items-start justify-content-start w-100 pb-3 mb-3"
                        style="border-bottom: 1px solid #e9ae3a">
                        <span class="mb-1" style="font-size: 14px">Wali Kelas :</span>
                        <span class="font-weight-bold" style="font-size: 16px">{{ $homeroom->teacher?->name ?? '-' }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col">
                {{-- Data pelanggaran Siswa --}}
                <div class="w-100 bg-white py-4 px-3 shadow shadow-sm rounded rounded-3 mb-5 area-data" style="height: 500px; overflow-y: scroll;">
                    <h4 class="">Data Pelanggaran Siswa</h4>
                    <span class="d-block mb-4">Jumlah: {{ $violations['violation_count'] }}</span>
                    <div class="w-100 d-flex flex-column align-items-start justify-content-start">
                        
                        @foreach ($violations['data'] as $violation)
                        <div class="w-100 p-2 text-white rounded rounded-3 mb-3" style="background: #ffc34e">
                            <span>{{ $violation->violation->name }}</span>
                        </div>    
                        @endforeach
                    </div>
                </div>
                {{-- Data Prestasi Siswa --}}
                <div class="w-100 bg-white py-4 px-3 shadow shadow-sm rounded rounded-3 mb-5 area-data" style="height: 500px; overflow-y: scroll;">
                    <h4 class="">Data Prestasi Siswa</h4>
                    <span class="d-block mb-4">Jumlah: {{ $achievements['achievement_count'] }}</span>
                    <div class="w-100 d-flex flex-column align-items-start justify-content-start">
                        @foreach ($achievements['data'] as $achievement)
                        <div class="w-100 p-2 text-white rounded rounded-3 mb-3" style="background: #ffc34e">
                            <span>{{ $achievement->achievment->name }}</span>
                        </div>    
                        @endforeach
                    </div>
                </div>
                {{-- Data Tugas Siswa --}}
                <div class="w-100 bg-white py-4 px-3 shadow shadow-sm rounded rounded-3 mb-5 area-data" style="height: 500px; overflow-y: scroll;">
                    <h4 class="">Data Tugas Siswa</h4>
                    <span class="d-block mb-4">Jumlah: {{ $tasks['task_count'] }}</span>
                    <div class="w-100 d-flex flex-column align-items-start justify-content-start">
                        @foreach ($tasks['data'] as $task)
                        <div class="w-100 p-2 text-white rounded rounded-3 mb-3" style="background: #ffc34e">
                            <span>{{ $task->task->name }}</span>
                        </div>
                        @endforeach
                    </div>

                </div>
                {{-- Data Kehadiran Siswa --}}
                <div class="w-100 bg-white py-4 px-3 shadow shadow-sm rounded rounded-3 mb-5 area-data">
                    <h4 class="mb-4">Data Kehadiran Siswa</h4>
                    <div class="w-100 d-flex flex-column align-items-start justify-content-start">
                        <div class="w-100 px-2 pb-3  text-black rounded rounded-3 mb-3" style="border-bottom: 1px solid #ffc34e;">
                            <span class="d-block mb-1 font-weight-bold" style="font-size: 16px">Hadir :</span>
                            <span class="d-block" style="font-size: 15px;">{{ $presence['presences'] }}</span>
                        </div>
                        <div class="w-100 px-2 pb-3  text-black rounded rounded-3 mb-3" style="border-bottom: 1px solid #ffc34e;">
                            <span class="d-block mb-1 font-weight-bold" style="font-size: 16px">Izin :</span>
                            <span class="d-block" style="font-size: 15px;">{{ $presence['permissions'] }}</span>
                        </div>
                        <div class="w-100 px-2 pb-3  text-black rounded rounded-3 mb-3" style="border-bottom: 1px solid #ffc34e;">
                            <span class="d-block mb-1 font-weight-bold" style="font-size: 16px">Sakit :</span>
                            <span class="d-block" style="font-size: 15px;">{{ $presence['sicks'] }}</span>
                        </div>
                        <div class="w-100 px-2 pb-3  text-black rounded rounded-3 mb-3" style="border-bottom: 1px solid #ffc34e;">
                            <span class="d-block mb-1 font-weight-bold" style="font-size: 16px">Tanpa keterangan :</span>
                            <span class="d-block" style="font-size: 15px;">{{ $presence['without_explanations'] }}</span>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
@endsection
