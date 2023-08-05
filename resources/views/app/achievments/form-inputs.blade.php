@php $editing = isset($achievment) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Nama Prestasi"
            :value="old('name', ($editing ? $achievment->name : ''))"
            maxlength="255"
            placeholder="Nama Prestasi"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="point"
            label="Poin"
            :value="old('point', ($editing ? $achievment->point : ''))"
            max="255"
            placeholder="Poin"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
