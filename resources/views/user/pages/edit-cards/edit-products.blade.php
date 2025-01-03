@extends('user.layouts.index', ['header' => true, 'nav' => true, 'demo' => true, 'settings' => $settings])

{{-- Custom CSS --}}
@section('css')
    <link href="{{ asset('css/dropzone.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/clipboard.min.js') }}"></script>
    <style>
        .btn-group-sm>.btn,
        .btn-sm {
            --tblr-btn-line-height: 1.5;
            --tblr-btn-icon-size: .75rem;
            margin-right: 5px;
            font-size: 12px !important;
            margin: 13px 0 10px 5px !important;
        }

        .li-link {
            padding: 10px;
            margin: 4px;
        }

        .btn.disabled,
        .btn:disabled,
        fieldset:disabled .btn {
            border-color: #0000 !important;
        }

        .custom-nav {
            position: absolute;
            right: 5px;
            top: -2px;
        }

        .media-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">
                {{-- Failed --}}
                @if (Session::has('failed'))
                    <div class="alert alert-important alert-danger alert-dismissible mb-2" role="alert">
                        <div class="d-flex">
                            <div>
                                {{ Session::get('failed') }}
                            </div>
                        </div>
                        <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif

                {{-- Success --}}
                @if (Session::has('success'))
                    <div class="alert alert-important alert-success alert-dismissible mb-2" role="alert">
                        <div class="d-flex">
                            <div>
                                {{ Session::get('success') }}
                            </div>
                        </div>
                        <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif

                {{-- Success of modal --}}
                <div id="successMessage" style="display:none;"
                    class="alert alert-important alert-success alert-dismissible mb-2">
                </div>

                {{-- Failed of modal --}}
                <div id="errorMessage" style="display:none;"
                    class="alert alert-important alert-danger alert-dismissible mb-2">
                </div>

                <div class="card">
                    <div class="row g-0">
                        <div class="col-12 col-md-3 border-end">
                            <div class="card-body">
                                <h4 class="subheader">{{ __('Update Business Card') }}</h4>
                                <div class="list-group list-group-transparent">
                                    {{-- Nav links --}}
                                    @include('user.pages.edit-cards.includes.nav-link', [
                                        'link' => 'products',
                                    ])
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-9 d-flex flex-column">
                            <div class="card-body m-0 py-0 px-2">
                                <div class="row align-items-center pt-3 px-2">
                                    <div class="col">
                                        <h2 class="card-title">
                                            {{ __('Products') }}
                                        </h2>
                                    </div>
                                    <div class="col-auto ms-auto d-print-none">
                                        <button type="button" class="btn btn-icon btn-primary" onclick="addProduct()"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="{{ __('Create new') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon d-lg-none d-inline"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <line x1="12" y1="5" x2="12" y2="19" />
                                                <line x1="5" y1="12" x2="19" y2="12" />
                                            </svg>
                                            <span class="d-lg-inline d-none">{{ __('Create new') }}</span>
                                        </button>
                                    </div>
                                </div>

                                {{-- Products --}}
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="productsTable" class="table table-vcenter card-table">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('#') }}</th>
                                                    <th>{{ __('Image') }}</th>
                                                    <th>{{ __('Name') }}</th>
                                                    <th>{{ __('Description') }}</th>
                                                    <th>{{ __('Stock') }}</th>
                                                    <th>{{ __('Actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent mt-auto">
                                    <div class="btn-list justify-content-end">
                                        <a href="{{ route('user.cards') }}" class="btn">
                                            {{ __('Cancel') }}
                                        </a>
                                        <a href="{{ route('user.edit.galleries', Request::segment(3)) }}"
                                            class="btn btn-primary">
                                            {{ __('Skip') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('user.includes.footer')
        </div>

        {{-- Add product --}}
        <div class="modal modal-blur fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">{{ __('Add Product') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addProductForm">
                            <div class="row">
                                <input type="hidden" id="cardId" value="{{ $business_card->card_id }}">
                                {{-- Product badge --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class='mb-3'>
                                        <label class='form-label required'>{{ __('Product Badge') }}</label>
                                        <input type='text' class='form-control' id='productBadge' name="product_badge"
                                            placeholder='{{ __(' Product Badge') }}' required>
                                    </div>
                                </div>
                                {{-- Currency --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label required" for="currency">{{ __('Currency') }}</label>
                                        <select id="productCurrency" name="product_currency"
                                            class="form-control currency" required>
                                            <option value="" selected disabled>{{ __('Choose currency') }}</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->iso_code }}">{{ $currency->name }}
                                                    ({{ $currency->symbol }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Product Image --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('Product Image') }} <span
                                                class='text-muted'>({{ __('Recommended : 200 x 200 pixels') }})</span></label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="image form-control" id="productImage"
                                                name="product_image" placeholder="{{ __('Product Image') }}" required>
                                            <button class="btn btn-primary btn-icon" type="button"
                                                onclick="openMedia()">{{ __('Choose image') }}</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- Product name --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class="mb-3">
                                        <label for="productName"
                                            class="form-label required">{{ __('Product Name') }}</label>
                                        <input type="text" class="form-control" id="productName" name="product_name"
                                            required>
                                    </div>
                                </div>
                                {{-- Product Description --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class="mb-3">
                                        <label for="productDescription"
                                            class="form-label required">{{ __('Product Description') }}</label>
                                        <input type="text" class="form-control" id="productDescription"
                                            name="product_description" required>
                                    </div>
                                </div>
                                {{-- Regular Price --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class='mb-3'>
                                        <label class='form-label required'>{{ __('Regular Price') }}</label>
                                        <input type='number' class='form-control' id="productRegularPrice"
                                            name='product_regular_price' min='1'
                                            placeholder='{{ __('Regular Price') }}' min='1' step='.001'
                                            required>
                                    </div>
                                </div>
                                {{-- Sales Price --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class='mb-3'>
                                        <label class='form-label required'>{{ __('Sales Price') }}</label>
                                        <input type='number' class='form-control' id="productSalesPrice"
                                            name='product_sales_price[]' min='1' step='.001'
                                            placeholder='{{ __('Sales Price') }}' required>
                                    </div>
                                </div>
                                {{-- Status --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class="mb-3">
                                        <label class='form-label required'
                                            for='product_status'>{{ __('Status') }}</label>
                                        <select id="productStatus" name='product_status'
                                            class='form-control product_status'
                                            {{ $whatsAppNumberExists != true ? 'disabled' : '' }} required>
                                            <option value="instock" selected>{{ __('In Stock') }}</option>
                                            <option value="outstock">{{ __('Out of Stock') }}</option>
                                        </select>

                                        {{-- Check whatsapp number exists --}}
                                        @if ($whatsAppNumberExists != true)
                                            <p class="h6">
                                                {{ __("'Inquiry button' is disabled as you have not entered whatsapp number. Go to the 'Social Links' page and enter the WhatsApp number.") }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="button" class="btn btn-primary"
                            onclick="saveProduct()">{{ __('Save changes') }}</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Update product --}}
        <div class="modal modal-blur fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">{{ __('Edit Product') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editProductForm">
                            <div class="row">
                                {{-- Product badge --}}
                                <div class="col-md-6 col-xl-6">
                                    <input type="hidden" id="productId">
                                    <div class='mb-3'>
                                        <label class='form-label required'>{{ __('Product Badge') }}</label>
                                        <input type='text' class='form-control' id='editProductBadge'
                                            name="product_badge" placeholder='{{ __(' Product Badge') }}' required>
                                    </div>
                                </div>
                                {{-- Currency --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label required" for="currency">{{ __('Currency') }}</label>
                                        <select id="editProductCurrency" name="product_currency"
                                            class="form-control currency" required>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->iso_code }}">{{ $currency->name }}
                                                    ({{ $currency->symbol }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Product Image --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('Product Image') }} <span
                                                class='text-muted'>({{ __('Recommended : 200 x 200 pixels') }})</span></label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="image form-control" id="editProductImage"
                                                name="product_image" placeholder="{{ __('Product Image') }}" required>
                                            <button class="btn btn-primary btn-icon" type="button"
                                                onclick="openMedia()">{{ __('Choose image') }}</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- Product name --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class="mb-3">
                                        <label for="productName"
                                            class="form-label required">{{ __('Product Name') }}</label>
                                        <input type="text" class="form-control" id="editProductName"
                                            name="product_name" required>
                                    </div>
                                </div>
                                {{-- Product Description --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class="mb-3">
                                        <label for="productDescription"
                                            class="form-label required">{{ __('Product Description') }}</label>
                                        <input type="text" class="form-control" id="editProductDescription"
                                            name="product_description" required>
                                    </div>
                                </div>
                                {{-- Regular Price --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class='mb-3'>
                                        <label class='form-label required'>{{ __('Regular Price') }}</label>
                                        <input type='number' class='form-control' id="editProductRegularPrice"
                                            name='product_regular_price' min='1'
                                            placeholder='{{ __('Regular Price') }}' min='1' step='.001'
                                            required>
                                    </div>
                                </div>
                                {{-- Sales Price --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class='mb-3'>
                                        <label class='form-label required'>{{ __('Sales Price') }}</label>
                                        <input type='number' class='form-control' id="editProductSalesPrice"
                                            name='product_sales_price[]' min='1' step='.001'
                                            placeholder='{{ __('Sales Price') }}' required>
                                    </div>
                                </div>
                                {{-- Status --}}
                                <div class="col-md-6 col-xl-6">
                                    <div class="mb-3">
                                        <label class='form-label required'
                                            for='product_status'>{{ __('Status') }}</label>
                                        <select id="editProductStatus" name='product_status'
                                            class='form-control product_status'
                                            {{ $whatsAppNumberExists != true ? 'disabled' : '' }} required>
                                            <option value="instock">{{ __('In Stock') }}</option>
                                            <option value="outstock">{{ __('Out of Stock') }}</option>
                                        </select>

                                        {{-- Check whatsapp number exists --}}
                                        @if ($whatsAppNumberExists != true)
                                            <p class="h6">
                                                {{ __("'Inquiry button' is disabled as you have not entered whatsapp number. Go to the 'Social Links' page and enter the WhatsApp number.") }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="button" class="btn btn-primary"
                            onclick="updateProduct()">{{ __('Save changes') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete product modal -->
        <div class="modal modal-blur fade" id="deleteProductModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteProductModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteProductModalLabel">{{ __('Delete Product') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('Are you sure you want to delete this product?') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="button" class="btn btn-danger"
                            id="confirmDeleteButton">{{ __('Delete') }}</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Media Library --}}
        <div class="modal modal-blur fade" id="openMediaModel" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Media Library') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row row-cards" id="captions">
                            {{-- Upload multiple images --}}
                            @include('user.pages.edit-cards.media.upload')

                            {{-- Upload multiple images --}}
                            @include('user.pages.edit-cards.media.list')

                            {{-- Pagination --}}
                            <div id="pagination"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Custom JS --}}
    @push('custom-js')
        <script type="text/javascript" src="{{ asset('js/tom-select.base.min.js') }}"></script>
        <!-- Initialize DataTables -->
        <script>
            // Get products
            $(document).ready(function() {
                "use strict";
                $('#productsTable').DataTable({
                    processing: false,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('user.edit.vproducts', $business_card->card_id) }}", // Replace with your actual API endpoint
                        dataSrc: 'data' // If your data is nested under a key 'data' in the response
                    },
                    pageLength: 5,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'product_image',
                            name: 'product_image',
                            render: function(data, type, full, meta) {
                                return '<img src="' + data +
                                    '" alt="Product Image" style="width: 50px; height: 50px;"/>';
                            }
                        },
                        {
                            data: 'product_name',
                            name: 'product_name'
                        },
                        {
                            data: 'product_subtitle',
                            name: 'product_subtitle'
                        },
                        {
                            data: 'product_status',
                            name: 'product_status'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            });

            // Open Media modal
            function openMedia() {
                "use strict";
                $('#openMediaModel').modal('show');
            }

            // Open add product modal
            function addProduct() {
                "use strict";
                $('#addProductModal').modal('show');
            }

            // Save Product
            function saveProduct() {
                "use strict";
                var cardId = $('#cardId').val();
                var productBadge = $('#productBadge').val();
                var productCurrency = $('#productCurrency').val();
                var productImage = $('#productImage').val();
                var productName = $('#productName').val();
                var productDescription = $('#productDescription').val();
                var productRegularPrice = $('#productRegularPrice').val();
                var productSalesPrice = $('#productSalesPrice').val();
                var productStatus = $('#productStatus').val();

                $.ajax({
                    url: '{{ route('user.save.vproduct') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        card_id: cardId,
                        product_badge: productBadge,
                        product_currency: productCurrency,
                        product_image: productImage,
                        product_name: productName,
                        product_description: productDescription,
                        product_regular_price: productRegularPrice,
                        product_sales_price: productSalesPrice,
                        product_status: productStatus,
                    },
                    success: function(response) {
                        if (response.success) {
                            // Display success message
                            $('#successMessage').text("{{ __('New Product added successfully!') }}").show();
                            $('#successMessage').delay(1000).fadeOut(200);
                            $('#addProductModal').modal('hide');
                            $('#addProductForm').trigger("reset");

                            // Reload product table
                            $('#productsTable').DataTable().ajax.reload();
                        } else {
                            // Display error message
                            $('#addProductModal').modal('hide');
                            $('#errorMessage').text("{{ __('Failed to add product.') }}").show();
                            $('#errorMessage').delay(1500).fadeOut(200);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Display error message
                        $('#addProductModal').modal('hide');
                        $('#errorMessage').text("{{ __('Something went wrong!') }}").show();
                        $('#errorMessage').delay(1500).fadeOut(200);
                    }
                });
            }

            // Edit product modal
            function editProduct(productId) {
                "use strict";
                $.ajax({
                    url: '/user/get-vproducts/' + productId,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#productId').val(response.data.id);
                            $('#editProductBadge').val(response.data.badge);
                            $('#editProductCurrency').val(response.data.currency);
                            $('#editProductImage').val(response.data.product_image);
                            $('#editProductName').val(response.data.product_name);
                            $('#editProductDescription').val(response.data.product_subtitle);
                            $('#editProductRegularPrice').val(response.data.regular_price);
                            $('#editProductSalesPrice').val(response.data.sales_price);
                            $('#editProductStatus').val(response.data.product_status);
                            $('#editProductModal').modal('show');
                        } else {
                            // Display error message
                            $('#errorMessage').text("{{ __('Failed to fetch product data.') }}").show();
                            $('#errorMessage').delay(1500).fadeOut(200);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Display error message
                        $('#errorMessage').text("{{ __('Something went wrong!') }}").show();
                        $('#errorMessage').delay(1500).fadeOut(200);
                    }
                });
            }

            // Update product
            function updateProduct() {
                "use strict";
                var productId = $('#productId').val();
                var productBadge = $('#editProductBadge').val();
                var productCurrency = $('#editProductCurrency').val();
                var productImage = $('#editProductImage').val();
                var productName = $('#editProductName').val();
                var productDescription = $('#editProductDescription').val();
                var productRegularPrice = $('#editProductRegularPrice').val();
                var productSalesPrice = $('#editProductSalesPrice').val();
                var productStatus = $('#editProductStatus').val();

                $.ajax({
                    url: '{{ route('user.update.vproduct') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        product_badge: productBadge,
                        product_currency: productCurrency,
                        product_image: productImage,
                        product_name: productName,
                        product_description: productDescription,
                        product_regular_price: productRegularPrice,
                        product_sales_price: productSalesPrice,
                        product_status: productStatus,
                    },
                    success: function(response) {
                        if (response.success) {
                            // Display success message
                            $('#successMessage').text("{{ __('Product updated successfully!') }}").show();
                            $('#successMessage').delay(1000).fadeOut(200);
                            $('#editProductModal').modal('hide');

                            // Reload products table
                            $('#productsTable').DataTable().ajax.reload();
                        } else {
                            // Display error message
                            $('#editProductModal').modal('hide');
                            $('#errorMessage').text("{{ __('Failed to update product.') }}").show();
                            $('#errorMessage').delay(1500).fadeOut(200);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Display error message
                        $('#editProductModal').modal('hide');
                        $('#errorMessage').text("{{ __('Something went wrong!') }}").show();
                        $('#errorMessage').delay(1500).fadeOut(200);
                    }
                });
            }

            // Function to delete the product
            function deleteProduct(productId) {
                $('#deleteProductModal').data('product-id', productId).modal('show');
            }

            // jQuery to handle the modal "Okay" button click
            $(document).ready(function() {
                $('#confirmDeleteButton').click(function() {
                    deleteConfirmProduct();
                });
            });

            // Confirm delete product
            function deleteConfirmProduct() {
                var productId = $('#deleteProductModal').data('product-id');
                $.ajax({
                    url: '/user/delete-vproduct/' + productId,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                    },
                    success: function(response) {
                        // Display success message
                        $('#successMessage').text("{{ __('Product deleted successfully!') }}").show();
                        $('#successMessage').delay(1000).fadeOut(100);
                        $('#deleteProductModal').modal('hide');

                        // Reload product table
                        $('#productsTable').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        // Display error message
                        $('#addProductModal').modal('hide');
                        $('#errorMessage').text("{{ __('Error deleting product') }}").show();
                        $('#errorMessage').delay(1500).fadeOut(200);
                    }
                });
            }
        </script>
        {{-- Upload image in dropzone --}}
        <script type="text/javascript">
            Dropzone.options.dropzone = {
                maxFilesize: {{ env('SIZE_LIMIT') / 1024 }},
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                init: function() {
                    this.on("success", function(file, response) {
                        loadMedia();
                    });
                }
            };
        </script>

        {{-- Media with pagination --}}
        <script>
            // Default values
            var currentPage = 1;
            var totalPages = 1;

            // Previous image
            function loadPreviousPage() {
                "use strict";

                if (currentPage > 1) {
                    currentPage--;
                    loadMedia(currentPage);
                }
            }

            // Next page
            function loadNextPage() {
                "use strict";

                if (currentPage < totalPages) {
                    currentPage++;
                    loadMedia(currentPage);
                }
            }

            // Load media images
            function loadMedia(page = 1) {
                $.ajax({
                    url: '{{ route('user.media') }}',
                    method: 'GET',
                    data: {
                        page: page
                    },
                    dataType: 'json',
                    success: handleMediaResponse,
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Media response
            function handleMediaResponse(response) {
                "use strict";

                var mediaData = response.media.data;
                if (mediaData.length > 0) {
                    $('#noImagesFound').hide();
                    $('#showPagination').removeClass('d-none').addClass('card pagination-card');
                    displayMediaCards(mediaData);
                    updatePaginationInfo(response.media);
                } else {
                    $('#noImagesFound').show();
                    $('#showPagination').addClass('d-none');
                    $('#mediaCardsContainer').html('');
                    updatePaginationInfo(response.media);
                }
            }

            // Display media images in card type
            function displayMediaCards(mediaData) {
                "use strict";

                // Generate media image
                var mediaCardsHtml = '';
                mediaData.forEach(function(media) {
                    mediaCardsHtml += `
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="${media.base_url}${media.media_url}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="${media.media_name}">
                        <div class="card-body">
                            <h5 class="card-title media-name">${media.media_name}</h5>
                            <a class="btn btn-icon btn-primary btn-md copyBoard" data-clipboard-text="${media.media_url}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('Copy') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <rect x="8" y="8" width="12" height="12" rx="2"></rect>
                                    <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            `;
                });
                $('#mediaCardsContainer').html(mediaCardsHtml);
            }

            // Update pagination
            function updatePaginationInfo(media) {
                "use strict";

                $('#paginationStartIndex').text(media.from);
                $('#paginationEndIndex').text(media.to);
                $('#paginationTotalCount').text(media.total);
                currentPage = media.current_page;
                totalPages = media.last_page;

                $('#prevPageBtn').prop('disabled', currentPage <= 1);
                $('#nextPageBtn').prop('disabled', currentPage >= totalPages);
            }

            // Load more image in pagination
            $(document).ready(function() {
                "use strict";

                loadMedia(); // Initial load
            });
        </script>

        {{-- Clipboard --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                "use strict";

                var clipboard = new ClipboardJS('.copyBoard');

                // Success
                clipboard.on('success', function(e) {
                    "use strict";

                    // Place value in the field
                    $('.image').val(e.text);

                    // Hide media modal
                    $('#openMediaModel').modal('hide');
                });

                // Error
                clipboard.on('error', function(e) {
                    "use strict";

                    showErrorAlert('{{ __('Failed to copy text to clipboard. Please try again.') }}');
                });

                // Show success message
                function showSuccessAlert(message) {
                    "use strict";

                    showAlert(message, 'success');
                }

                // Show error message
                function showErrorAlert(message) {
                    "use strict";

                    showAlert(message, 'danger');
                }

                // Show alert
                function showAlert(message, type) {
                    "use strict";

                    var alertDiv = document.createElement('div');
                    alertDiv.classList.add('alert', 'alert-important', 'alert-' + type, 'alert-dismissible');
                    alertDiv.setAttribute('role', 'alert');

                    var innerContent = '<div class="d-flex">' +
                        '<div>' +
                        message +
                        '</div>' +
                        '</div>' +
                        '<a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>';

                    alertDiv.innerHTML = innerContent;
                    document.querySelector('#showAlert').appendChild(alertDiv);

                    setTimeout(function() {
                        "use strict";

                        alertDiv.remove();
                    }, 3000);
                }
            });
        </script>
    @endpush
@endsection