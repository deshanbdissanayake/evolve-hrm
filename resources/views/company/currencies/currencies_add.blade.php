<x-app-layout :title="'Input Example'">
    <x-slot name="header">
        <h4 class="mb-sm-0">{{ __('Add Currency') }}</h4>

        <!--
        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                <li class="breadcrumb-item active">Basic Elements</li>
            </ol>
        </div>
        -->
    </x-slot>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Currencies </h4>
                </div>
                <div class="card-body">

                    <form method="POST" id="currency_form">
                        <div class="row">

                            <div class="col-xxl-3 col-md-6 mb-3">
                                <label for="currency_name" class="form-label mb-1">Currency Name</label>
                                <input type="text" class="form-control" id="currency_name" placeholder="Enter Currency Name" required>
                            </div>


                            <div class="col-xxl-3 col-md-6 mb-3">
                                <label for="iso_code" class="form-label mb-1">ISO Code</label>
                                <input type="text" class="form-control" id="iso_code" placeholder="Enter ISO Code" required>
                            </div>


                            <div class="col-xxl-3 col-md-6 mb-3">
                                <label for="conversion_rate" class="form-label mb-1">Currency Conversion Rate</label>
                                <input type="text" class="form-control" id="conversion_rate" placeholder="Enter Conversion Rate" required>
                            </div>

                            <div class="col-xxl-3 col-md-6 mb-3">
                                <label for="previous_rate" class="form-label mb-1">Previous Rate</label>
                                <input type="text" class="form-control" id="previous_rate" placeholder="Enter Previous Rate" required>
                            </div>

                            <div class="col-xxl-3 col-md-6 mb-3">
                                <label class="form-check-label me-2" for="is_default">Is Default</label>
                                <input class="form-check-input" type="checkbox" name="isDefault" id="is_default" checked="">

                            </div>



                        </div>



                        <div class="row">

                            <div class="d-flex justify-content-end">
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>



{{-- Currency List --}}



    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Currencies Lists</h4>
                </div>

                <div class="card-body">


                    <div class="listjs-table" id="customerList">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-auto">
                                <div>
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add</button>

                                </div>
                            </div>


                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <div class="search-box ms-2">
                                        <input type="text" class="form-control search" placeholder="Search...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive table-card mt-3 mb-1">
                            <table class="table align-middle table-nowrap" id="customerTable">
                                <thead class="table-light">
                                    <tr>

                                        <th class="sort" data-sort="no">NO</th>
                                        <th class="sort" data-sort="currency_name">Currency Name</th>
                                        <th class="sort" data-sort="iso_code">ISO Code</th>
                                        <th class="sort" data-sort="conversion_rate">Conversion Rate</th>
                                        <th class="sort" data-sort="previous_rate">Previous Rate</th>
                                        <th class="sort" data-sort="is_default">Is Default</th>
                                        <th class="sort" data-sort="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
f

                                        <td class="customer_name">01</td>
                                        <td class="email">marycousar@velzon.com</td>
                                        <td class="phone">580-464-4694</td>
                                        <td class="date">06 Apr, 2021</td>
                                        <td class="date">06 Apr, 2021</td>
                                        <td class="status"><span class="badge bg-success-subtle text-success text-uppercase">Active</span></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <div class="edit">
                                                    <button class="btn btn-sm btn-success edit-item-btn" data-bs-toggle="modal" data-bs-target="#showModal">Edit</button>
                                                </div>
                                                <div class="remove">
                                                    <button class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal" data-bs-target="#deleteRecordModal">Remove</button>

                                                </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any orders for you search.</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="javascript:void(0);">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="javascript:void(0);">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end col -->

    </div>









</x-app-layout>
