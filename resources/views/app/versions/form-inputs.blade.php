@php $editing = isset($version) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="version"
            label="Versi App"
            :value="old('version', ($editing ? $version->version : ''))"
            placeholder="Versi App"
            required
        ></x-inputs.text>
       
    </x-inputs.group>
    <x-inputs.group class="col-sm-12">
        <x-inputs.datetime
        name="release_time"
        label="Waktu Rilis"
        :value="old('release_time', ($editing ? $version->release_time : ''))"
        placeholder="Waktu Rilis"
        required
    ></x-inputs.datetime>
       
    </x-inputs.group>
   
</div>
