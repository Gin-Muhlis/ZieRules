@php $editing = isset($violation) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Nama Pelanggaran"
            :value="old('name', ($editing ? $violation->name : ''))"
            maxlength="255"
            placeholder="Nama Pelanggaran"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="point"
            label="Poin"
            :value="old('point', ($editing ? $violation->point : ''))"
            max="255"
            placeholder="Poin"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
