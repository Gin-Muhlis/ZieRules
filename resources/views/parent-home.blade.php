@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row bg-primary position-relative" style="height: 250px">

        </div>
        <div class="px-2 row row-cols-md-2 border border-primary row-cols-1 align-items-start  justify-content-center"
            style="transform: translateY(-80px)">
            <div class="bg-danger rounded rounded-2 mr-4 mb-5 col-md-3 col py-2">
                <div class="d-flex flex-column w-100 align-items-center justify-content-center px-2 py-3 mb-5">
                    <div class="rounded rounded-circle bg-primary mb-2" style="width: 100px; height: 100px"></div>
                    <span class="font-weight-bold" style="font-size: 18px">Gin Gin Nurilham M</span>
                    <span class="font-italic" style="opacity: 70%; font-size: 15px;">212210007</span>
                </div>
                <div class="px-2 mb-3">
                    <div class="d-flex flex-column align-items-start justify-content-start w-100 pb-3 mb-3"
                        style="border-bottom: 1px solid black">
                        <span class="mb-1" style="font-size: 14px">Gender :</span>
                        <span class="font-weight-bold" style="font-size: 16px">Laki-laki</span>
                    </div>
                </div>
                <div class="px-2 mb-3">
                    <div class="d-flex flex-column align-items-start justify-content-start w-100 pb-3 mb-3"
                        style="border-bottom: 1px solid black">
                        <span class="mb-1" style="font-size: 14px">Kelas :</span>
                        <span class="font-weight-bold" style="font-size: 16px">12 RPL 1</span>
                    </div>
                </div>
                <div class="px-2 mb-3">
                    <div class="d-flex flex-column align-items-start justify-content-start w-100 pb-3 mb-3"
                        style="border-bottom: 1px solid black">
                        <span class="mb-1" style="font-size: 14px">Wali Kelas :</span>
                        <span class="font-weight-bold" style="font-size: 16px">Yayat Ruhiyat</span>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col">
                <div class="w-100 bg-danger p-4 rounded rounded-2 mr-4 mb-5">
                    <h4 class="mb-4">Data Keseharian Siswa</h4>
                    <div style="height: 450px; overflow-y: scroll">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        No
                                    </th>
                                    <th class="text-left">
                                        Pelanggaran (7)
                                    </th>
                                    <th class="text-left">
                                        Prestasi (7)
                                    </th>
                                    <th class="text-left">
                                        Tugas (7)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Membuang sampah sembarangan</td>
                                    <td>Juara 1 Hackathon Internasional</td>
                                    <td>Membuat website portfolio</td>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Membuang sampah sembarangan</td>
                                    <td>Juara 1 Hackathon Internasional</td>
                                    <td>Membuat website portfolio</td>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Membuang sampah sembarangan</td>
                                    <td>Juara 1 Hackathon Internasional</td>
                                    <td>Membuat website portfolio</td>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Membuang sampah sembarangan</td>
                                    <td>Juara 1 Hackathon Internasional</td>
                                    <td>Membuat website portfolio</td>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Membuang sampah sembarangan</td>
                                    <td>Juara 1 Hackathon Internasional</td>
                                    <td>Membuat website portfolio</td>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Membuang sampah sembarangan</td>
                                    <td>Juara 1 Hackathon Internasional</td>
                                    <td>Membuat website portfolio</td>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Membuang sampah sembarangan</td>
                                    <td>Juara 1 Hackathon Internasional</td>
                                    <td>Membuat website portfolio</td>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Membuang sampah sembarangan</td>
                                    <td>Juara 1 Hackathon Internasional</td>
                                    <td>Membuat website portfolio</td>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Membuang sampah sembarangan</td>
                                    <td>Juara 1 Hackathon Internasional</td>
                                    <td>Membuat website portfolio</td>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Membuang sampah sembarangan</td>
                                    <td>Juara 1 Hackathon Internasional</td>
                                    <td>Membuat website portfolio</td>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Membuang sampah sembarangan</td>
                                    <td>Juara 1 Hackathon Internasional</td>
                                    <td>Membuat website portfolio</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="w-100 bg-danger p-4 rounded rounded-2 mr-4 mr-5">
                    <h4 class="mb-4">Data Kehadiran Siswa</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        No
                                    </th>
                                    <th class="text-center">
                                        Hadir
                                    </th>
                                    <th class="text-center">
                                        Izin
                                    </th>
                                    <th class="text-center">
                                        Sakit
                                    </th>
                                    <th class="text-center">
                                        Tanpa Keterangan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">6</td>
                                    <td class="text-center">7</td>
                                    <td class="text-center">3</td>
                                    <td class="text-center">2</td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>


        </div>
    </div>
@endsection
