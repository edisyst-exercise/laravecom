<div>
    <div class="row">
        <div class="col-md-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="h4 text-blue">Categories</h4>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('admin.manage-categories.add-category') }}" class="btn btn-primary btn-sm" type="button">
                            <i class="fa fa-plus"></i>
                            Add Category
                        </a>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-striped">
                        <thead class="bg-secondary text-white">
                        <tr>
                            <th>Category image</th>
                            <th>Category name</th>
                            <th>Nr. of subcategories</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="sortable_categories">
                        @forelse($categories as $category)
                            <tr data-index="{{ $category->id }}" data-ordering="{{ $category->ordering }}">
                                <td>
                                    <div class="avatar mr-2">
                                        <img src="/images/categories/{{ $category->image }}" width="50" height="50" alt="">
                                    </div>
                                </td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->subcategories->count() }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.manage-categories.edit-category', ['id' => $category->id]) }}" class="text-primary">
                                            <i class="dw dw-edit-1"></i>
                                        </a>
                                        <a href="javascript:;" class="text-danger delete-category-btn" data-id="{{ $category->id }}">
                                            <i class="dw dw-delete-3"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"><span class="text-danger">No categories found</span></td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-block mt-2">{{ $categories->links('livewire::simple-bootstrap') }}</div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="h4 text-blue">Sub Categories</h4>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('admin.manage-categories.add-subcategory') }}" class="btn btn-primary btn-sm" type="button">
                            <i class="fa fa-plus"></i>
                            Add Sub Category
                        </a>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-striped">
                        <thead class="bg-secondary text-white">
                        <tr>
                            <th>Sub Category name</th>
                            <th>Category name</th>
                            <th>Childs Sub Category</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="sortable_subcategories">
                        @forelse($subcategories as $subcategory)
                            <tr data-index="{{ $subcategory->id }}" data-ordering="{{ $subcategory->ordering }}">
                                <td>{{ $subcategory->name }}</td>
                                <td>{{ $subcategory->category->name }}</td>
                                <td>
                                    @if( $subcategory->children->count() > 0)
                                        <ul class="list-group" id="sortable_child_subcategories">
                                            @foreach($subcategory->children as $child)
                                                <li data-index="{{ $child->id }}" data-ordering="{{ $child->ordering }}" class="d-flex justify-content-between align-items-center">
                                                    - {{ $child->name }}
                                                    <div>
                                                        <a href="{{ route('admin.manage-categories.edit-subcategory', ['id' => $child->id]) }}" class="text-primary" data-toggle="tooltip" title="Edit child">Edit</a>
                                                        <a href="javascript:;" class="text-danger delete-child-subcategory-btn" data-toggle="tooltip" data-title="Delete child" data-id="{{ $child->id }}">Delete</a>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        None
                                    @endif
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.manage-categories.edit-subcategory', ['id' => $subcategory->id]) }}" class="text-primary" title="Edit Subcategory">
                                            <i class="dw dw-edit-1"></i>
                                        </a>
                                        <a href="javascript:;" class="text-danger delete-subcategory-btn" data-id="{{ $subcategory->id }}" data-title="Delete Subcategory">
                                            <i class="dw dw-delete-3"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"><span class="text-danger">No subcategories found</span></td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-block mt-2">{{ $subcategories->links('livewire::simple-bootstrap') }}</div>
            </div>
        </div>
    </div>
</div>
