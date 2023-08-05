@php $editing = isset($student) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text name="name" label="Nama Siswa" :value="old('name', $editing ? $student->name : '')" maxlength="255" placeholder="Nama Siswa"
            required></x-inputs.text>
    </x-inputs.group>

    <div class="form-group col-sm-12">
        <label>NIS</label>
        <input type="text" class="form-control" id="nis" name="nis" label="Nis" maxlength="9"
            value="{{ old('nis', $editing ? $student->user->nis : '') }}" placeholder="NIS">
        @error('nis')
            <p class="text-danger" role="alert">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group col-sm-12">
        <label>Password</label>
        <input type="text" class="form-control" id="password" name="password" label="Password" maxlength="255"
            placeholder="Password" value="{{ $editing ? $student->password_show : '' }}">
        @error('password')
            <p class="text-danger" role="alert">{{ $message }}</p>
        @enderror
    </div>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="gender" label="Gender">
            @php $selected = old('gender', ($editing ? $student->gender : '')) @endphp
            <option value="laki-laki" {{ $selected == 'laki-laki' ? 'selected' : '' }}>Laki laki</option>
            <option value="perempuan" {{ $selected == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="class_id" label="Kelas" required>
            @php $selected = old('class_id', ($editing ? $student->class_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Silahkan Pilih Kelas</option>
            @foreach ($classes as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}
                </option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div x-data="imageViewer('{{ $editing && $student->image ? \Storage::url($student->image) : '' }}')">
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

</div>
