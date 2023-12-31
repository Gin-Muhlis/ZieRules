@php $editing = isset($teacher) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="name" label="Nama" :value="old('name', $editing ? $teacher->name : '')" maxlength="255" placeholder="Nama"
            required></x-inputs.text>
    </x-inputs.group>


    <x-inputs.group class="col-sm-12">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" id="email" maxlength="255" placeholder="Email"
            required value="{{ old('email', $editing ? $teacher->email : '') }}">
        @error('email')
            <p class="text-danger" role="alert">{{ $message }}</p>
        @enderror
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <label for="password">Password</label>
        <input type="text" name="password" id="password" class="form-control" maxlength="255" placeholder="Password"
            style="pointer-events: none" value="{{ $editing ? $teacher->password_show : '' }}" required>
        @error('password')
            <p class="text-danger" role="alert">{{ $message }}</p>
        @enderror
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div x-data="imageViewer('{{ $editing && $teacher->image ? \Storage::url($teacher->image) : '' }}')">
            <x-inputs.partials.label name="image" label="Gambar Profil"></x-inputs.partials.label><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img :src="imageUrl" class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;" />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div class="border rounded border-gray-200 bg-gray-100" style="width: 100px; height: 100px;"></div>
            </template>

            <div class="mt-2">
                <input type="file" name="image" id="image" @change="fileChosen" />
            </div>

            @error('image')
                @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="gender" label="Gender">
            @php $selected = old('gender', ($editing ? $teacher->gender : '')) @endphp
            <option value="laki-laki" {{ $selected == 'laki-laki' ? 'selected' : '' }}>Laki laki</option>
            <option value="perempuan" {{ $selected == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="role" label="Role" id="role">
            @php $selected = old('role', ($editing ? $teacher->getRoleNames()->first() : '')) @endphp
            <option value="guru-mapel" {{ $selected == 'guru-mapel' ? 'selected' : '' }}>Guru Mapel</option>
            <option value="wali-kelas" {{ $selected == 'wali-kelas' ? 'selected' : '' }}>Wali Kelas</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 class-homerooms d-none">
        <x-inputs.select name="class_id" label="Kelas" class="select-class" disabled>
            <option disabled>Silahkan Pilih Kelas</option>
            @foreach ($classes as $value => $label)
                <option value="{{ $value }}">{{ $label }}
                </option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>


@push('scripts')
    <script>
        $(document).ready(function() {
            // show and hidden when role teacher
            $("#role").on("input", function() {
                let value = $(this).val()
                console.log(value)
                if (value === 'wali-kelas') {
                    $(".class-homerooms").removeClass("d-none");
                    $(".select-class").removeAttr('disabled')
                } else {
                    $(".class-homerooms").addClass("d-none");
                }
            })
        })
    </script>
@endpush
