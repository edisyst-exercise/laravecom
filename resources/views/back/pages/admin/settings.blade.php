@extends('back.layout.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Admin Settings')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="title">
                    <h4>Profile</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Settings
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="pd-20 card-box mb-4">
        <livewire:admin-settings></livewire:admin-settings>
    </div>

@endsection

@push('scripts')
    <script>
        // script di anteprima site_logo: forse lgi alter sono superflui
        $('input[type="file"][name=site_logo][id=site_logo]').ijaboViewer({
            preview: '#site_logo_image_preview',
            imageShape: 'rectangular', //set square if favicon
            allowedExtensions: ['png', 'jpg'],
            onErrorShape: function (message, element) {
                alert(message);
            },
            onInvalidType: function (message, element) {
                alert(message);
            },
            onSuccess: function (message, element) {
                // alert(message); // lo uso solo se devo debuggare
            },
        });

        // script di update site_logo
        $('#change_site_logo_form').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            var formdata = new FormData(form);
            var inputFileVar = $(form).find('input[type="file"][name=site_logo]').val();

            if (inputFileVar.length > 0) {
                $.ajax({
                    url: $(form).attr('action',),
                    method: $(form).attr('method'),
                    data: formdata,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function () {
                        toastr.remove();
                        $(form).find('span.error-text').text('Logo modificato'); //text lo posso lasciar vuoto
                    },
                    success: function (response) {
                        if(response.status == 1){
                            toastr.success(response.msg);
                            $(form)[0].reset();
                        } else {
                            toastr.error(response.msg);
                        }
                    }
                });
            } else {
                $(form).find('span.error-text').text('Devi inserire un logo PNG o JPG');
            }
        });

        // script di anteprima site_favicon: forse lgi alter sono superflui
        $('input[type="file"][name=site_favicon][id=site_favicon]').ijaboViewer({
            preview: '#site_favicon_image_preview',
            imageShape: 'square', //set square if favicon
            allowedExtensions: ['png', 'jpg'],
            onErrorShape: function (message, element) {
                alert(message);
            },
            onInvalidType: function (message, element) {
                alert(message);
            },
            onSuccess: function (message, element) {
                // alert(message); // lo uso solo se devo debuggare
            },
        });


        // script di update site_favicon
        $('#change_site_favicon_form').on('submit', function (e) {
            e.preventDefault();
            var form = this;
            var formdata = new FormData(form);
            var inputFileVar = $(form).find('input[type="file"][name=site_favicon]').val();

            if (inputFileVar.length > 0) {
                $.ajax({
                    url: $(form).attr('action',),
                    method: $(form).attr('method'),
                    data: formdata,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function () {
                        // toastr.remove(); //lui questa volta non lo mette
                        $(form).find('span.error-text').text('Favicon modificata'); //text lo posso lasciar vuoto
                    },
                    success: function (response) {
                        if(response.status == 1){
                            toastr.success(response.msg);
                            $(form)[0].reset();
                        } else {
                            toastr.error(response.msg);
                        }
                    }
                });
            } else {
                $(form).find('span.error-text').text('Devi inserire una favicon PNG o JPG');
            }
        });
    </script>
@endpush
