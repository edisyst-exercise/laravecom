@extends('back.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Home')

@section('content')
    @livewire('admin-categories-list')
@endsection

@push('scripts')
    <script>
        $('table tbody#sortable_categories').sortable({
            cursor:"move",
            update: function (event, ui) {
                $(this).children().each(function (index) {
                    if( $(this).attr("data-ordering") != (index + 1)) {
                        $(this).attr("data-ordering", (index + 1)).addClass("updated");
                    }
                });
                var positions = [];
                $(".updated").each(function (){
                    positions.push([$(this).attr("data-index"), $(this).attr("data-ordering")]);
                    $(this).removeClass("updated");
                })
                // alert(positions);
                Livewire.dispatch('updateCategoriesOrdering', positions);
            }
        });

        $(document).on('click', ".delete-category-btn", function (e) {
            e.preventDefault();
            var category_id = $(this).data('id'); // legge il campo data-id
            swal.fire({
                title: "Ne sei sicuro?",
                html: "Stai per eliminare questa categoria",
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: "Certo, eliminala",
                confirmButtonColor: "#3085d6",
                cancelButtonText: "Annulla operazione",
                cancelButtonColor: "#d33",
                width: 300,
                allowOutsideClick:false
            }).then(function (result) {
                if (result.value) {
                    console.log(result)
                    // alert(category_id)
                    Livewire.dispatch('deleteCategory', [category_id]);
                }
            });
        });
    </script>
@endpush
