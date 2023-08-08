@php $editing = isset($historyViolation) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="student_id" label="Siswa" required>
            @php $selected = old('student_id', ($editing ? $historyViolation->student_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Silahkan Pilih Siswa</option>
            @foreach($students as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="teacher_id" label="Guru" required>
            @php $selected = old('teacher_id', ($editing ? $historyViolation->teacher_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Silahakn Pilih Guru</option>
            @foreach($teachers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="violation_id" label="Pelanggaran " required>
            @php $selected = old('violation_id', ($editing ? $historyViolation->violation_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Silahkan Pilih Pelanggaran</option>
            @foreach($violations as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($historyViolation->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>
</div>
