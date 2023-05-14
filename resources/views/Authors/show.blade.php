@extends('layout.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header">

                        <a href="/authors/" class="btn btn-primary btn-sm pull-right">
                            <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                            Back
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <strong>Author : </strong>
                                @if(isset($author['first_name']) && isset($author['last_name']))
                                    <span>{{ $author['first_name'] }} {{ $author['last_name'] }}</span>
                                @endif
                            </div>
                            <div class="col-6">
                                <strong>Id : </strong> <span>
                                    @if(isset($author['id']))
                                        <span>{{ $author['id'] }}</span>
                                    @endif
                            </div>
                            <div class="col-6 float-right">
                                <strong>Biography : </strong>
                                 @if(isset($author['biography']))
                                    <span>{{ $author['biography'] }}</span>
                                @endif
                            </div>
                            <div class="col-6">
                                <strong>Gender : </strong>
                                @if(isset($author['gender']))
                                    <span> {{ $author['gender'] }} </span>
                                @endif
                            </div>
                        </div>

                        @if(count($author['books']) > 0)
                            <h4 class="text-center margin-bottom-2">
                                <i class="fa fa-users fa-fw" aria-hidden="true"></i> Author Books
                            </h4>

                            <div class="table-responsive themes-table">
                                <table class="table table-striped table-sm data-table">
                                    <thead class="thead-dark">
                                    <tr>
                                        {{-- <th>ID</th> --}}
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Release date</th>
                                        <th>Description</th>
                                        <th>Isbn</th>
                                        <th>Format</th>
                                        <th>No. of Pages</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($author['books'] as $book)
                                        <tr>
                                            <td>{{$book['id']}}</td>
                                            <td>{{$book['title']}}</td>
                                            <td>{{$book['release_date']}}</td>
                                            <td>{{$book['description']}}</td>
                                            <td>{{$book['isbn']}}</td>
                                            <td>{{$book['format']}}</td>
                                            <td>{{$book['number_of_pages']}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
{{--                    <div class="card-footer">--}}
{{--                        <div class="row pt-2">--}}
{{--                            <div class="col-sm-6 mb-2">--}}
{{--                                <a href="/themes/{{$author['id']}}/edit" class="btn btn-small btn-info btn-block">--}}
{{--                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Edit<span class="hidden-sm"> this</span><span class="hidden-sm"> Theme</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            {!! Form::open(array('url' => 'themes/' . $author['id'], 'class' => 'col-sm-6 mb-2')) !!}--}}
{{--                            {!! Form::hidden('_method', 'DELETE') !!}--}}
{{--                            {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> Delete<span class="hidden-sm"> this</span><span class="hidden-sm"> Theme</span>', array('class' => 'btn btn-danger btn-block btn-flat','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => trans('themes.confirmDeleteHdr'), 'data-message' => trans('themes.confirmDelete'))) !!}--}}
{{--                            {!! Form::close() !!}--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>

{{--    @include('modals.modal-delete')--}}

@endsection

@section('footer_scripts')

    @include('scripts.delete-modal-script')
{{--    @include('scripts.tooltips')--}}

@endsection