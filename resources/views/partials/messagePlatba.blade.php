<div class="text-center">
    @if(Session::has('successPlatba'))
        <div class="alert alert-success"><strong>HOTOVO:</strong>{{ Session::get('successPlatba') }}</div>
    @endif
    @if($errors->has('error'))

        <div class="alert alert-danger">
            <strong>CHYBA:</strong>
            <ul style="list-style: none;padding: 0;">
                <li>{{ $errors->first('error') }}</li>
            </ul>
        </div>
    @endif
</div>
