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
                                <td>12</td>
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
                                <td colspan="4">
                                    <span class="text-danger">No categories found</span>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="h4 text-blue">Sub Categories</h4>
                    </div>
                    <div class="pull-right">
                        <a href="" class="btn btn-primary btn-sm" type="button">
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
                            <th>Nr. of childs Sub Category</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <tr>
                            <td>Mobile & Computer</td>
                            <td>Electronics</td>
                            <td>12</td>
                            <td>
                                <div class="table-actions">
                                    <a href="" class="text-primary">
                                        <i class="dw dw-edit-1"></i>
                                    </a>
                                    <a href="" class="text-danger">
                                        <i class="dw dw-delete-3"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
