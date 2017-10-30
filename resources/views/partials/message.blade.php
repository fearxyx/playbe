<div class="text-center">
    @if(Session::has('success'))
        <div class="alert alert-success"><strong>HOTOVO: </strong>{{ Session::get('success') }}</div>
    @endif
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <strong>CHYBA:</strong>
            <ul style="list-style: none;padding: 0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
