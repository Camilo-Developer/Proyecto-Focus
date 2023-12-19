@if(session('success'))
    @component('components.alert')
        @slot('class', 'success')
        @slot('message', session('success'))
    @endcomponent
@endif
@if(session('edit'))
    @component('components.alert')
        @slot('class', 'warning')
        @slot('message', session('edit'))
    @endcomponent
@endif
@if(session('delete'))
    @component('components.alert')
        @slot('class', 'error')
        @slot('message', session('delete'))
    @endcomponent
@endif
@if(session('info'))
    @component('components.alert')
        @slot('class', 'info')
        @slot('message', session('info'))
    @endcomponent
@endif
