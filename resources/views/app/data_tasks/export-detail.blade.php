@php
    require_once app_path() . '/helpers/helpers.php';
@endphp

<table class="table table-borderless table-hover">
    <thead>
        <tr>
            <th class="text-center">
                No
            </th>
            <th class="text-left">
                Nama Siswa
            </th>
            <th class="text-left">
                Tanggal
            </th>

            <th class="text-left">
                Tugas Selesai
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse($reports as $data)
            <tr>
                <td class="text-center">
                    {{ $loop->index + 1 }}
                </td>
                <td>
                    {{ $data['student'] ?? '-' }}
                </td>
                <td>
                    {{ $data['date'] ? generateDate($data['date']) : '-' }}
                </td>
                <td>
                    {{ $data['task'] ?? '-' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">
                    @lang('crud.common.no_items_found')
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
