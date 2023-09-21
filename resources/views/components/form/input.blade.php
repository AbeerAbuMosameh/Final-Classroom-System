@props([
    'value' => '' ,
    'name' ,
])

    <input
        name="{{$name}}"
        id="{{$id ?? $name}}"
        value="{{old($name , $value)}}"
        {{$attributes->merge([
            'type'=>'text'
       ])->class(['form-control' , 'is-invalid' => $errors->has($name)])}}
    >


