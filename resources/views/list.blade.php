@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Add Items') }}</div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session()->has('success'))

                        <h3 class=" alert alert-success">{{ session('success') }}</h3>
                    @endif
                        <form method="POST" class="item-form" onsubmit="return validateForm(this)" action="{{ route('savItems') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 item-container">
                                    <div class="row mb-3">
                                        <input type='hidden' name='paid[]' value=''>
                                        <div class='col-md-2'>
                                            <div class='form-group'>
                                                <label>Image</label>
                                                <input type='file'name='img[]' validation-rules="required|file"
                                                    accept="jpg, png, jpeg, svg" class='form-control' id='img' />
                                            </div>
                                        </div>
                                        <div class='col-md-2'>
                                            <div class='form-group'>
                                                <label>title</label>
                                                <input type='text'name='title[]' validation-rules="required"
                                                    class='form-control' id='title' placeholder="title" />
                                            </div>
                                        </div>
                                        <div class='col-md-2'>
                                            <div class='form-group'>
                                                <label>description</label>
                                                <textarea name='description[]' validation-rules="required|max" class='form-control' id='description'
                                                    placeholder="description" /></textarea>
                                            </div>
                                        </div>
                                        <div class='col-md-1'>
                                            <div class='form-group'>
                                                <label>qty</label>
                                                <input type='text'name='qty[]'validation-rules='required|number'
                                                    class='form-control' id='qty' placeholder="qty" />
                                            </div>
                                        </div>
                                        <div class='col-md-2'>
                                            <div class='form-group'>
                                                <label>price</label>
                                                <input type='text'name='price[]' validation-rules="required|number"
                                                    class='form-control' id='price' placeholder="price" />
                                            </div>
                                        </div>
                                        <div class='col-md-2'>
                                            <div class='form-group'>
                                                <label>Date</label>
                                                <input type='date'name='date[]' validation-rules="required"
                                                    class='form-control' id='date' placeholder="date" />
                                            </div>
                                        </div>
                                        <div class='col-md-1'>
                                            <div class='form-group'>
                                                <label>&nbsp;&nbsp;</label>
                                                <button type="button" class="form-control btn btn-primary add">+</button>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <input type="submit" class="btn btn-info" value="Save">
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Item List') }}</div>
                    <div class="card-body">
                        <form action="{{ route('index') }}" method="POST" class="filter-result-form">
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label for="">Search</label>
                                    <input type="text" name="search" class="form-control" placeholder="Search title..">
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">From</label>
                                            <input type="date" name="from" class="from form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">to</label>
                                            <input type="date" name="to" class="to form-control">
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-4">
                                    <label for="">&nbsp;&nbsp;</label>
                                    <div>
                                        <input type="submit" class="btn btn-primary form-control" value="Apply Filter">
                                    </div>

                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-md-12 result-items">
                                <table class="table">
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>QTy</th>
                                        <th>Date</th>

                                    </tr>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>
                                                @if ($item->file != '' && file_exists('storage/media/items/' . $item->file))
                                                    <img src="{{ asset('storage/media/items/' . $item->file) }}"
                                                        class="mt-1" width="200px" height="100px" alt="brand Image">
                                                @endif

                                            </td>
                                            <td>
                                                <b>{{ $item->title }}</b>
                                            </td>
                                            <td>
                                                <p>{{ $item->description }}</p>
                                            </td>
                                            <td>
                                                {{ $item->price }}
                                            </td>
                                            <td>
                                                {{ $item->qty }}
                                            </td>
                                            <td>
                                                {{ $item->date }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                <div class="row mt-2 justify-content-end">
                                    <div class="col-md-12 result-pagination d-flex justify-content-end text-lg-end">
                                        {{ $items->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(function() {
            let item_count = 1;
            $(document).on('click', '.add', function() {
                item_count++;
                let html_text = `
                             <div class="row mb-3 item-row" attr-id='` + item_count + `'>
                                <input type='hidden' name='aid[]' value=''>
                                <div class='col-md-2'>
                                    <div class='form-group'>
                                        <label>Image</label>
                                        <input type='file'name='img[]' validation-rules="required|file"
                                                    accept="jpg,png,jpeg,svg" class='form-control' id='img' />
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class='form-group'>
                                        <label>title</label>
                                        <input type='text'name='title[]' class='form-control' id='title' validation-rules="required" placeholder="title" />
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class='form-group'>
                                        <label>description</label>
                                        <textarea name='description[]' class='form-control' validation-rules="required|max" id='description' placeholder="description" /></textarea>
                                    </div>
                                </div>
                                <div class='col-md-1'>
                                    <div class='form-group'>
                                        <label>qty</label>
                                        <input type='text'name='qty[]' class='form-control' id='qty' validation-rules="required|number" placeholder="qty" />
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class='form-group'>
                                        <label>price</label>
                                        <input type='text'name='price[]' class='form-control' id='price' validation-rules="required|number" placeholder="price" />
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class='form-group'>
                                        <label>Date</label>
                                        <input type='date'name='date[]' class='form-control' id='date' validation-rules="required" placeholder="date" />
                                    </div>
                                </div>
                                <div class='col-md-1'>
                                    <div class='form-group'>
                                        <label>&nbsp;&nbsp;</label>
                                       <button type="button" class="form-control btn btn-danger remove-item-btn">-</button>
                                    </div>
                                </div>


                            </div>
           `
                $('.item-container').append(html_text);
            })
            $(document).on('click', '.remove-item-btn', function() {
                $(this).closest('.item-row').remove();
            })


            $(document).on('submit', '.filter-result-form', function(e) {
                e.preventDefault();
                url = $(this).attr('action');

                var formData = new FormData(this);

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(res) {


                        $('.result-items').html(res.result);

                    },
                    error: function(res) {
                        console.log(res);
                    }
                })


            })
            $(document).on('change', '.from', function() {
                let from_date = $(this).val();
                console.log('from_date', from_date);
                $('.to').attr('min', from_date);
            })
            $(document).on('change', '.to', function() {
                let to_date = $(this).val();
                console.log('to_date', to_date);
                $('.from').attr('max', to_date);
            })

            $(document).on('click', '.result-pagination .pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                $('.filter-result-form').append('<input type="hidden" name="page" value="' + page + '">')
                $('.filter-result-form').submit();

            })
        })

        function validateForm(form_el) {
            // form_el.preventDefault();
            var status = true;
            var formInput = $(form_el).find('input,select,textarea');

            try {

                formInput.each(function(index, inp) {
                    var rules = $(inp).attr('validation-rules');
                    $(inp).removeClass('is-invalid');
                    $(inp).next('.invalid-feedback').remove();
                    if (rules) {
                        var rulesArr = rules.split('|');

                        rulesArr.forEach(element => {
                            console.log(element);
                            switch (element.trim()) {
                                case 'required': {
                                    console.log($(inp).val());
                                    console.log($(inp));
                                    var length = typeof($(inp).val()) == 'string' ? $(inp).val().trim()
                                        .length : $(inp).val().length;


                                    if (length == 0) {

                                        $(inp).addClass('is-invalid')

                                        $(inp).after(
                                            '<p class="invalid-feedback text-start">This field is required</p>'
                                            );
                                        status = false

                                    }
                                }
                                break;
                            case 'file': {
                                var fileName = $(inp).val().trim();
                                var allowed_extensions = $(inp).attr('accept');

                                if (fileName.length > 0) {


                                    var status1 = false;
                                    if (allowed_extensions == null) {
                                        allowed_extensions = new Array("jpg", "png", "gif", "pdf", "tiff",
                                            "tif", 'csv', 'docx');
                                    } else {
                                        allowed_extensions = allowed_extensions.split(',');
                                    }

                                    var file_extension = fileName.split('.').pop()
                                .toLowerCase();

                                    for (var i = 0; i <= allowed_extensions.length; i++) {
                                        if (allowed_extensions[i] == file_extension) {
                                            status1 = true; // valid file extension
                                        }
                                    }

                                    if (status1 == false) {
                                        $(inp).addClass('is-invalid')
                                        $(inp).after(
                                            '<p class="invalid-feedback text-start">Invalid file formate only accept ' +
                                            allowed_extensions.toString() + ' file formate. </p>');
                                        status = false;

                                    }
                                }
                            }
                            break;
                            case 'number': {
                                var value = $(inp).val().trim();

                                if (value.length > 0) {
                                    if (!(/^\d*$/.test(value))) {

                                        $(inp).addClass('is-invalid')
                                        $(inp).after(
                                            '<p class="invalid-feedback text-start">This field rquired only numeric value</p>'
                                            );
                                        status = false
                                    }
                                }

                            }
                            break;
                            case 'max':{
                                var value = $(inp).val().trim();
                                if(value.length>250){
                                    $(inp).addClass('is-invalid')
                                        $(inp).after(
                                            '<p class="invalid-feedback text-start">This field value should not more than 250 characters.</p>'
                                            );
                                        status = false
                                }
                            }
                            break;

                            default:
                                break;
                            }
                        });
                    }

                })
                $(form_el).find('.is-invalid').eq(0).focus();
            } catch (error) {
                console.log(error);
                status = false;
            }

            return status;
        }
    </script>
@endsection
