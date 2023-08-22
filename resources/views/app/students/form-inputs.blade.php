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
        <input type="text" class="form-control" id="password" name="password" required label="Password"
            maxlength="255" placeholder="Password" style="pointer-events: none"
            value="{{ $editing ? $student->password_show : '' }}">
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
            @foreach ($classStudents as $value => $label)
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

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="code"
            label="Kode"
            :value="old('code', ($editing ? $student->code : ''))"
            maxlength="11"
            placeholder="Kode"
            required
            style="pointer-events: none;"
            id="code"
        ></x-inputs.text>
    </x-inputs.group>


</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // add pointer event none to password input when focus
            $("#password").on("focus", function() {
                $("#password").css({
                    'pointer-events': 'none'
                })
            })

            // add pointer event none to password input when input
            $("#password").on("input", function() {
                $("#password").css({
                    'pointer-events': 'none'
                })

                generatePassword()
            })


            // generate password
            $("#nis").on("change", function() {

                generatePassword()
                generateCode($(this).val())

            })

            // fuunction to generate password and set to input password
            function generatePassword() {
                let now = new Date();
                let time = new String(now.getTime())
                let year = now.getFullYear()

                let str = `${year}${time}`;
                let arrayStr = str.split('');
                for (let i = arrayStr.length - 1; i > 0; i--) {
                    let n = Math.floor(Math.random() * (i + 1));
                    [arrayStr[i], arrayStr[n]] = [arrayStr[n], arrayStr[i]]
                }

                let password = arrayStr.splice(0, 9).join('');

                $("#password").val(password);

                return true;
            }

            function generateCode(nis) {
                let splitNis = nis.split('');
                for (let i = splitNis.length - 1; i > 0; i--) {
                    let n = Math.floor(Math.random() * (i + 1));
                    [splitNis[i], splitNis[n]] = [splitNis[n], splitNis[i]]
                }
                let randomNum = Math.floor(Math.random() * 99);

                let code = splitNis.join('') + randomNum.toString();

                $("#code").val(code);
            }
        })
    </script>
@endpush
