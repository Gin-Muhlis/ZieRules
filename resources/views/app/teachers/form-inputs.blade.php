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
            style="pointer-events: none" required>
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
            <option value="guru-mapel">Guru Mapel</option>
            <option value="wali-kelas">Wali Kelas</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12 class-homerooms d-none">
        <x-inputs.select name="class_id" label="Kelas" required>
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

                if (value === 'wali-kelas') {
                    $(".class-homerooms").removeClass("d-none");
                } else {
                    $(".class-homerooms").addClass("d-none");
                }
            })

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
            $("#email").on("change", function() {

                generatePassword()

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


            }
        })
    </script>
@endpush
