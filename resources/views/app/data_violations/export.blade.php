<table class="table table-borderless table-hover">
    <thead>
        <tr>
            <th class="text-left">
                Nama Siswa
            </th>
            <th class="text-center">
                Jumlah pelanggaran
            </th>
            <th class="text-center">
                Total Poin Pelanggaran
            </th>
        </tr>
    </thead>
    <tbody class="body-table">
        @forelse($reports as $data)
            <tr>
                <td>
                    {{ $data['name'] ?? '-' }}
                </td>
                <td class="text-center">
                    {{ $data['violationsCount'] ?? '-' }}
                </td>
                <td class="text-center">
                    {{ $data['totalPoint'] ?? '-' }}
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
