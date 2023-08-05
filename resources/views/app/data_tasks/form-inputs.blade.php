@php $editing = isset($dataTask) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="task_id" label="Tugas" required>
            @php $selected = old('task_id', ($editing ? $dataTask->task_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Silahkan Pilih Tugas</option>
            @foreach($tasks as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="student_id" label="Siswa" required>
            @php $selected = old('student_id', ($editing ? $dataTask->student_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Silahkan Pilih SIswa</option>
            @foreach($students as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="teacher_id" label="Guru" required>
            @php $selected = old('teacher_id', ($editing ? $dataTask->teacher_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Silahkan Pilih Guru</option>
            @foreach($teachers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="date"
            label="Tanggal"
            value="{{ old('date', ($editing ? optional($dataTask->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="description" label="Keterangan" required
            >{{ old('description', ($editing ? $dataTask->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
