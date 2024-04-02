@extends('back.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Home')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-dark">Add Category</h4>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('admin.manage-categories.cat-subcat-list') }}" class="btn btn-primary btn-sm" type="button">
                            <i class="ion-arrow-left-a"></i>
                            Back to Category List
                        </a>
                    </div>
                </div>
                <hr>
                <form action="{{ route('admin.manage-categories.store-category') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if (\Illuminate\Support\Facades\Session::get('success'))
                        <div class="alert alert-success">
                            <strong><i class="dw dw-checked"></i></strong>
                            {!! \Illuminate\Support\Facades\Session::get('success') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (\Illuminate\Support\Facades\Session::get('fail'))
                        <div class="alert alert-danger">
                            <strong><i class="dw dw-checked"></i></strong>
                            {!! \Illuminate\Support\Facades\Session::get('fail') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="name">Category name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter category name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger ml-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="image">Category image</label>
                                <input type="file" class="form-control" name="image" >
                                @error('image')
                                    <span class="text-danger ml-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create category</button>
                </form>
            </div>
        </div>
    </div>
@endsection
