<table class="table table-borderless table-hover">
    <thead>
        <tr>
            <th class="text-left">
                Nama Siswa
            </th>
            <th class="text-left">
                Kelas
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
        @forelse($reports as $data)
            <tr>
                <td>
                    {{ $data['name'] ?? '-' }}
                </td>
                <td>
                    {{ $data['className'] ?? '-' }}
                </td>
                <td class="text-center">
                    {{ $data['presences'] ?? '-' }}
                </td>
                <td class="text-center">
                    {{ $data['permissions'] ?? '-' }}
                </td>
                <td class="text-center">
                    {{ $data['sicks'] ?? '-' }}
                </td>
                <td class="text-center">
                    {{ $data['withoutExplanations'] ?? '-' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    @lang('crud.common.no_items_found')
                </td>
            </tr>
        @endforelse
    </tbody>
</table>