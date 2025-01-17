@component('mail::layout')
{{-- Header --}}

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} @lang('All rights reserved.'). @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
