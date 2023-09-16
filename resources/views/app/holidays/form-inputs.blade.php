@php $editing = isset($holiday) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="date"
            label="Tanggal"
            value="{{ old('date', ($editing ? optional($holiday->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>
</div>
