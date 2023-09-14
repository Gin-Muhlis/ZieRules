@php $editing = isset($quote) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.textarea name="quote" label="Quote" maxlength="255" required
            >{{ old('quote', ($editing ? $quote->quote : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="teacher_id" label="Guru" required>
            @php $selected = old('teacher_id', ($editing ? $quote->teacher_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Silahkan Pilih Guru</option>
            @foreach($teachers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
