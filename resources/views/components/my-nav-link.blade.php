
{{-- <a href="#" aria-current="page" class="rounded-md bg-gray-950 px-3 py-2 text-sm font-medium text-white">Dashboard</a>
<a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">Team</a> --}}

{{-- dengan menggunakan data properties dan attributes->merge kita bisa memodifikasi element div sehingga element bisa dinamis --}}

{{-- @props(['href', 'current'=>false, 'ariaCurrent'=>false])

@php
    if($current){
        $clases='bg-gray-950 text-white';
        $ariaCurrent='page';
    } else {
        $clases='text-gray-300 hover:bg-white/5 hover:text-white';
    }
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class'=>'rounded-md px-3 py-2 text-sm font-medium '.$clases, 'aria-current'=>$ariaCurrent]) }}>{{ $slot }}</a> --}}

@props(['href', 'current'=>false, 'ariaCurrent'=>false])
@php
    if($current){
        $clases = 'bg-gray-950 text-white';
        $ariaCurrent = 'page';
    } else {
        $clases = 'text-gray-300 hover:bg-white/5 hover:text-white';
    }
@endphp

<a href="{{ $href }}"{{ $attributes->merge(['class'=>'rounded-md px-3 py-2 text-sm font-medium '.$clases, 'aria-current'=>$ariaCurrent]) }}>{{ $slot }}</a>
