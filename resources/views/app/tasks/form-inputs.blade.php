@php $editing = isset($task) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Nama"
            :value="old('name', ($editing ? $task->name : ''))"
            maxlength="255"
            placeholder="Nama"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="class"
            label="Kelas"
            :value="old('class', ($editing ? $task->class : ''))"
            maxlength="255"
            placeholder="Kelas"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea
            name="description"
            label="Deskripsi"
            maxlength="255"
            required
            >{{ old('description', ($editing ? $task->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
