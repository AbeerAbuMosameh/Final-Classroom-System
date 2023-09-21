@props([
    'placeholder' => '' ,
    'name' ,
])
<div class="form-floating mb-3">
    {{$slot}}
    {{$label}}
    <x-form.error-feedback name="{{$name}}"/>
</div>
