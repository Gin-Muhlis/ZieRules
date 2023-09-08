@php $editing = isset($studentAbsence) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="date"
            label="Tanggal"
            value="{{ old('date', ($editing ? optional($studentAbsence->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="student_id" label="Siswa" required>
            @php $selected = old('student_id', ($editing ? $studentAbsence->student_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Silahkan Pilih Siswa</option>
            @foreach($students as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="presence_id" label="Kehadiran" required>
            @php $selected = old('presence_id', ($editing ? $studentAbsence->presence_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Silahkan Pilih Kehadiran</option>
            @foreach($presences as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <label>Jam</label>
        <input type="time" class="form-control" name="time" step="1" value="{{ old('time', ($editing ? $studentAbsence->time : '')) }}" required>

    </x-inputs.group>
</div>
