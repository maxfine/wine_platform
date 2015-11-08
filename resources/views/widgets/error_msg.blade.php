@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>错误提示!</strong>
        <hr>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif