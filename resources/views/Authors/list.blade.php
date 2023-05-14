@extends('layout.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                            <div class="float-left">
                                {{ __('Authors') }}
                            </div>
                            <div class="float-right">
                                <a href="{{ url('/themes/') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('themes.backToThemesTt') }}">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    Add Author
                                </a>
                            </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive themes-table">
                            <table class="table table-striped table-sm data-table">
                                <thead class="thead-dark">
                                <tr>
                                    {{-- <th>ID</th> --}}
                                    <th>Id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th class="hidden-xs hidden-sm hidden-md">Birthday</th>
                                    <th>Gender</th>
                                    <th>Place of Birth</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($collectAuthors['data']['items'] as $author)
                                    <tr>
                                         <td>{{$author['id']}}</td>
                                         <td>{{$author['first_name']}}</td>
                                         <td>{{$author['last_name']}}</td>
                                         <td>{{$author['birthday']}}</td>
                                         <td>{{$author['gender']}}</td>
                                         <td>{{$author['place_of_birth']}}</td>
                                        <td>
                                            <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('authors/' . $author['id']) }}" data-toggle="tooltip" title="View">
                                                <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                                <span class="sr-only">Show</span>
                                            </a>
                                        </td>
                                        <td>
                                            {!! Form::open(array('url' => 'authors/' . $author['id'], 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete Author')) !!}
                                            {!! Form::hidden('_method', 'DELETE') !!}
                                            {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="sr-only">Delete Theme</span>', array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#123', 'data-title' => "Are you sure you want to delete author?", 'data-message' => "Yes, Delete")) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')

    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')

@endsection