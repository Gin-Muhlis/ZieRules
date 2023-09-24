<table class="table table-borderless table-hover">
    <thead>
        <tr>
            <th class="text-center">
                No
            </th>
            <th class="text-left">
                Nama Siswa
            </th>
            <th class="text-center">
                Jumlah Tugas Selesai
            </th>
        </tr>
    </thead>
    <tbody class="body-table">
        @forelse($reports as $data)
            <tr>
                <td>
                    {{ $loop->index + 1 }}
                </td>
                <td>
                    {{ $data['name'] ?? '-' }}
                </td>
                <td class="text-center">
                    {{ $data['tasksCount'] ?? '-' }}
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
