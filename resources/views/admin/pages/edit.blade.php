@extends('layout._back')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">编辑 Page</div>

                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ URL('admin/pages/'.$data->id) }}" method="POST">
                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="text" name="title" class="form-control" required="required" value="{{ Input::old('title', isset($data) ? $data->title : null) }}">
                        <br>
                        <div class="form-group">
                            <label>正文 <small class="text-red">*</small></label>
                            <textarea class="form-control" id="ckeditor" name="body">{{ Input::old('body', isset($data) ? $data->body : null) }}</textarea>
                            @include('scripts.endCKEditor'){{-- 引入CKEditor编辑器相关JS依赖 --}}
                        </div>
                        <br>
                        <button class="btn btn-lg btn-info">确认提交</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
