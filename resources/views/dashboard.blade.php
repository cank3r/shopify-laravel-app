@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="alert-div" class="text-center alert d-none" role="alert">
                <h4 class="text-center"></h4>
            </div>
            <div class="card">
                <div class="card-header bolder-text text-white bg-primary">Product List</div>

                <div class="card-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 pl-0">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#product-modal"><i class="fas fa-plus"></i> Add Product</button>
                            </div>
                            <div class="col-md-3 offset-md-3 pr-0">
                                <div class="form-group">
                                    <!-- Product Filter -->
                                    <select id="product-filter" class="form-control float-right" onchange="filterProducts();">
                                        <option value="" onclick="resetFilter();">Select Product Type</option>
                                        @foreach($prod_type as $key => $val)
                                            <option value="{{ $val }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 pl-0 pr-0" id="product-table-container">
                        <input type="hidden" name="access-token" id="access-token" value="{{ $accessToken }}">
                        <table id="products" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Product Type</th>
                                    <th>Product Price</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            @if(!empty($prods))
                                <tbody>
                                    @foreach($prods as $key => $val)
                                        <tr>
                                            <td>{{ $val['id'] }}</td>
                                            <td>{{ $val['title'] }}</td>
                                            <td>{{ $val['prod_type'] }}</td>
                                            <td>{{ $val['price'] }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success" onclick='showModal("{{ $val['id'] }}", "{{ $val['title'] }}", "{{ $val['prod_type'] }}", "{{ $val['price'] }}");' data-toggle="modal" data-target="#update-modal"><i class="fas fa-edit"></i> Update</button>
                                                <button class="btn btn-sm btn-danger" onclick='showWarning("{{ $val['id'] }}");' data-toggle="modal" data-target="#notif-modal"><i class="fas fa-trash"></i> Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @else
                                <tbody></tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="product-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add Product</h5>
            </div>
            <div class="modal-body">
                <!-- Product ID -->
                <input type="hidden" name="product-id" id="product-id" value="">

                <!-- Product Title -->
                <div class="form-group">
                    <label>Product</label>
                    <input type="text" class="form-control" id="product-name" placeholder="Short Leeves Polo">
                </div>

                <!-- Product Type -->
                <div class="form-group">
                    <label>Product Type</label>
                    <input type="text" class="form-control" id="product-type" placeholder="Footware, Apparell, Accessories, etc...">
                </div>

                <!-- Product Price -->
                <div class="form-group">
                    <label>Product Price (Peso)</label>
                    <input type="text" class="form-control" id="product-price" placeholder="1234.56">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addProduct();" data-dismiss="modal">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Product Modal -->
<div class="modal fade" id="update-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Update Product</h5>
            </div>
            <div class="modal-body">
                <!-- Product ID -->
                <input type="hidden" name="product-id" id="product-id" value="">

                <!-- Product Title -->
                <div class="form-group">
                    <label>Product</label>
                    <input type="text" class="form-control" id="product-name" placeholder="Short Leeves Polo">
                </div>

                <!-- Product Type -->
                <div class="form-group">
                    <label>Product Type</label>
                    <input type="text" class="form-control" id="product-type" placeholder="Footware, Apparell, Accessories, etc...">
                </div>

                <!-- Product Price -->
                <div class="form-group">
                    <label>Product Price (Peso)</label>
                    <input type="text" class="form-control" id="product-price" placeholder="1234.56">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="updateProduct();" data-dismiss="modal">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Warning Modal -->
<div class="modal fade" id="notif-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Notification Message</h5>
            </div>
            <div class="modal-body">
                <h4></h4>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#products').DataTable();
    });

    function resetFields() {
        $('#product-modal #product-id').val('');
        $('#product-modal #product-name').val('');
        $('#product-modal #product-type').val('');
        $('#product-modal #product-price').val('');

        $('#update-modal #product-id').val('');
        $('#update-modal #product-name').val('');
        $('#update-modal #product-type').val('');
        $('#update-modal #product-price').val('');
    }

    function refreshTable() {
        var access_token = $('#access-token').val();
        $.ajax({
            url : "{{ url('reload-table') }}",
            data : {
                'access_token' : access_token
            }
        })
        .done(function(response) {
            $('#products tbody').empty();
            $.each(response['products'], function(el, val) {
                var params = "'"+val.id+"','"+val.title+"','"+val.prod_type+"','"+val.price+"'";
                var actions = '<td class="text-center">\
                                    <button class="btn btn-sm btn-success" onclick="updateProduct('+params+');"><i class="fas fa-edit"></i> Update</button>\
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduct('+val.id+');"><i class="fas fa-trash"></i> Delete</button>\
                                </td>';
                var data = '<tr>\
                                <td>'+val.id+'</td>\
                                <td>'+val.title+'</td>\
                                <td>'+val.prod_type+'</td>\
                                <td>'+val.price+'</td>\
                                '+actions+'\
                            </tr>';
                $('#products tbody').append(data);
                $('#products').DataTable();
            });

            $('#product-filter').empty().append('<option value="">Select Product Type</option>');
            $.each(response['type'], function(el, val) {
                $('#product-filter').append('<option value="'+val+'">'+val+'</option>');
            });
        });
    }

    function resetFilter() {
        $('#product-filter').val('');
        refreshTable();
    }

    function addProduct() {
        var access_token = $('#access-token').val();
        var data = {
            'product' : {
                'title' : $('#product-modal #product-name').val(),
                'product_type' : $('#product-modal #product-type').val(),
                'variants' : [
                    {
                        "price": $('#product-modal #product-price').val()
                    }
                ]
            }
        }

        $.ajax({
            url: "{{ url('/add-product') }}",
            data: {
                'access_token' : access_token,
                'data' : data
            },
        })
        .done(function(response) {
            resetFields();
            resetFilter();
            if(response == 'success') {
                $('#alert-div h4').empty();
                $('#alert-div').addClass('alert-success').removeClass('d-none');
                $('#alert-div h4').text('Product successfully added.');
                $('.alert').fadeOut(10000);
                refreshTable();
            } else {
                $('#alert-div h4').empty();
                $('#alert-div').addClass('alert-danger').removeClass('d-none');
                $('#alert-div h4').text('Something wend wrong. Please try again.');
                $('.alert').fadeOut(10000);
            }
        });
    }

    function showModal(id, title, prod_type, price) {
        $('#update-modal #product-id').val(id);
        $('#update-modal #product-name').val(title);
        $('#update-modal #product-type').val(prod_type);
        $('#update-modal #product-price').val(price);
        $('#update-modal .modal-content .modal-footer .btn-primary').attr('onclick',"updateProduct('"+id+"')");
    }
    
    function updateProduct(id) {
        var access_token = $('#access-token').val();
        var data = {
            'product' : {
                'title' : $('#update-modal #product-name').val(),
                'product_type' : $('#update-modal #product-type').val(),
                'variants' : [
                    {
                        "price": $('#update-modal #product-price').val()
                    }
                ]
            }
        }
        $.ajax({
            url: "{{ url('update-product') }}",
            data: {
                'access_token' : access_token,
                'id' : id,
                'data' : data
            },
        })
        .done(function(response) {
            if(response != 'fail') {
                $('#alert-div h4').empty();
                $('#alert-div').addClass('alert-success').removeClass('d-none');
                $('#alert-div h4').text('Product successfully updated.');
                $('.alert').fadeOut(10000);
                resetFields();
                refreshTable();
            } else {
                $('#alert-div h4').empty();
                $('#alert-div').addClass('alert-danger').removeClass('d-none');
                $('#alert-div h4').text('Something wend wrong. Please try again.');
                $('.alert').fadeOut(10000);
            }
        });
    }

    function showWarning(id) {
        $('#notif-modal .modal-content .modal-body h4').empty().append('Are you sure you want to delete this product?');
        var delete_btn = '<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="deleteProduct('+id+')">Delete</button>';
        var close_btn = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
        $('#notif-modal .modal-content .modal-footer').empty().append(delete_btn,close_btn);
    }

    function deleteProduct(id) {
        var access_token = $('#access-token').val();
        $.ajax({
            url: "{{ url('/delete-product') }}",
            data: {
                'access_token' : access_token,
                'id' : id
            },
        })
        .done(function(response) {
            if(response != 'fail') {
                $('#alert-div h4').empty();
                $('#alert-div').addClass('alert-success').removeClass('d-none');
                $('#alert-div h4').text('Product successfully deleted.');
                $('.alert').fadeOut(10000);
                refreshTable();
            } else {
                $('#alert-div h4').empty();
                $('#alert-div').addClass('alert-danger').removeClass('d-none');
                $('#alert-div h4').text('Something wend wrong. Please try again.');
                $('.alert').fadeOut(10000);
            }
        });
    }

    function filterProducts() {
        var prod_type = $('#product-filter').val();
        var access_token = $('#access-token').val();

        $.ajax({
            url: "{{ url('/filter-products') }}",
            data: {
                'access_token' : access_token,
                'prod_type' : prod_type
            },
        })
        .done(function(response) {
            if(response != 'fail') {
                $('#products tbody').empty();
                $.each(response, function(el, val) {
                    var params = "'"+val.id+"','"+val.title+"','"+val.prod_type+"','"+val.price+"'";
                    var actions = '<td class="text-center">\
                                        <button class="btn btn-sm btn-success" onclick="updateProduct('+params+');"><i class="fas fa-edit"></i> Update</button>\
                                        <button class="btn btn-sm btn-danger" onclick="deleteProduct('+val.id+');"><i class="fas fa-trash"></i> Delete</button>\
                                    </td>';
                    var data = '<tr>\
                                    <td>'+val.id+'</td>\
                                    <td>'+val.title+'</td>\
                                    <td>'+val.prod_type+'</td>\
                                    <td>'+val.price+'</td>\
                                    '+actions+'\
                                </tr>';
                    $('#products tbody').append(data);
                    $('#products').DataTable();
                });
            } else {
                $('#alert-div h4').empty();
                $('#alert-div').addClass('alert-danger').removeClass('d-none');
                $('#alert-div h4').text('No data matches your filter.');
                $('.alert').fadeOut(10000);
            }
        });
    }
</script>
@endsection
