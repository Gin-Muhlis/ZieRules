@props([
    'name',
    'label',
    'value',
])

<x-inputs.basic type="datetime-local" :name="$name" step="1" label="{{ $label ?? ''}}" :value="$value ?? ''" :attributes="$attributes"></x-inputs.basic>