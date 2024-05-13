@extends('back.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Home')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-dark">Edit Subcategory</h4>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('admin.manage-categories.cat-subcat-list') }}" class="btn btn-primary btn-sm" type="button">
                            <i class="ion-arrow-left-a"></i>
                            Back to Category List
                        </a>
                    </div>
                </div>
                <hr>
                <form action="{{ route('admin.manage-categories.update-subcategory') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ request()->id }}">
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
                                <label for="parent_category">Parent Category</label>
                                <select name="parent_category" id="" class="form-control">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $subcategory->id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_category') <span class="text-danger ml-2">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="name">Subcategory name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter SUBcategory name" value="{{ $subcategory->name }}">
                                @error('name') <span class="text-danger ml-2">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="">Is child of</label>
                                <select name="is_child_of" id="" class="form-control">
                                    <option value="0">-- Indipendente --</option>
                                    @foreach($subcategories as $item)
                                        @if($item->id != $subcategory->id)
                                            <option value="{{ $item->id }}" {{ ($subcategory->is_child_of != 0) && ($subcategory->is_child_of == $item->id) ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('is_child_of') <span class="text-danger ml-2">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Subcategory</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
