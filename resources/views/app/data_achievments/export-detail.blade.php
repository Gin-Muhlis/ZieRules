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
                      Prestasi
                  </th>
                  <th class="text-center">
                      Poin
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
                          {{ $data['achievment'] ?? '-' }}
                      </td>
                      <td class="text-center">
                          {{ $data['point'] ?? '-' }}
                      </td>
                  </tr>
              @empty
                  <tr>
                      <td colspan="5">
                          @lang('crud.common.no_items_found')
                      </td>
                  </tr>
              @endforelse
              <tr>
                <td colspan="4">
                    Total                
                </td>
                <td>
                    {{ $total_point }}
                </td>
    
            </tr>
          </tbody>
      </table>
