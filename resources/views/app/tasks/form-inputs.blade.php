@php $editing = isset($task) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Nama Tugas"
            :value="old('name', ($editing ? $task->name : ''))"
            maxlength="255"
            placeholder="Nama Tugas"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
