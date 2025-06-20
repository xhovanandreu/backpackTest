
@push('crud_fields_styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

{{-- Select Multiple --}}
@php
    if (!isset($field['options'])) {
        $options = $field['model']::all();
    } else {
        $options = call_user_func($field['options'], $field['model']::query());
    }
    $field['allows_null'] = $field['allows_null'] ?? true;
    $field['value'] = old_empty_or_null($field['name'], collect()) ?? $field['value'] ?? $field['default'] ?? collect();
    if (is_a($field['value'], \Illuminate\Support\Collection::class)) {
        $field['value'] = $field['value']->pluck(app($field['model'])->getKeyName())->toArray();
    }
@endphp

@include('crud::fields.inc.wrapper_start')

    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')
    <input type="hidden" name="{{ $field['name'] }}" value="" @if(in_array('disabled', $field['attributes'] ?? [])) disabled @endif />
    <select 
        name="{{ $field['name'] }}[]" 
        @include('crud::fields.inc.attributes', ['default_class' => 'form-control form-select'])
        bp-field-main-input
        multiple>
        @if (count($options))
            @foreach ($options as $option)
                @if(in_array($option->getKey(), $field['value']))
                    <option value="{{ $option->getKey() }}" selected>{{ $option->{$field['attribute']} }}</option>
                @else
                    <option value="{{ $option->getKey() }}">{{ $option->{$field['attribute']} }}</option>
                @endif
            @endforeach
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif

@include('crud::fields.inc.wrapper_end')

{{-- Include Select2 JavaScript --}}
@push('crud_fields_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('select[name="{{ $field['name'] }}[]"]').select2({
                width: '100%',
                placeholder: 'Select options...',
                allowClear: true,
            });
        });
    </script>
@endpush