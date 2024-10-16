<x-app-layout :title="'Input Example'">
    <x-slot name="header">
        <h4 class="mb-sm-0">{{ __('Locations') }}</h4>

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
                <div class="card-header align-items-center d-flex justify-content-between">
                    <div>
                        <button type="button" class="btn btn-primary waves-effect waves-light material-shadow-none me-1 type-btn" data-type="country">Countries</button>
                        <button type="button" class="btn btn-outline-primary waves-effect waves-light material-shadow-none me-1 type-btn" data-type="province">Provinces</button>
                        <button type="button" class="btn btn-outline-primary waves-effect waves-light material-shadow-none type-btn" data-type="city">Cities</button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary waves-effect waves-light material-shadow-none me-1" id="add_new_btn">Add New <i class="ri-add-line"></i></button>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-nowrap">
                        <thead id="table_head">
                            
                        </thead>
                        <tbody id="table_body">
                            
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- form modal -->
    <div id="location-form-modal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="location-form-title">Add</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="location-form-body" class="row">


                    </div>
                    <div class="d-flex gap-2 justify-content-end mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger" id="location-submit-confirm">Submit</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        
        //======================================================================================================
        // render tables
        //======================================================================================================
        let type = 'country';

        $(document).ready(function() {
            renderTable(type);
        });
        
        // Handle button clicks for countries, provinces, and cities
        $(document).on('click', '.type-btn', function() {
            $('.type-btn').removeClass('btn-primary').addClass('btn-outline-primary');
            $(this).removeClass('btn-outline-primary').addClass('btn-primary');
            type = $(this).data('type');
            renderTable(type);
        });

        // Render table based on the type
        async function renderTable(type) {
            // Define table headings based on the type
            const tableHeadings = {
                country: ['Country', 'Country Code'],
                province: ['Country', 'Province'],
                city: ['Province', 'City']
            };

            // Dynamically set the table headers based on the type
            const head = `
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">${tableHeadings[type][0]}</th>
                    <th scope="col">${tableHeadings[type][1]}</th>
                    <th scope="col">Action</th>
                </tr>
            `;
            $('#table_head').html(head);
            $('#table_body').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');

            // Set the URL based on the type
            const url = `url/${type}`;  // Assuming you have a different URL for each type

            try {
                const response = await fetch(url);
                const data = await response.json();

                // Early exit if no data
                if (!data || data.length === 0) {
                    $('#table_body').html('<tr><td colspan="4" class="text-center">No data available</td></tr>');
                    return;
                }

                // Generate the table rows dynamically based on the type
                const list = data.map((item, i) => {
                    if (type === 'country') {
                        return `
                            <tr type="${type}" id="${item.id}">
                                <th scope="row">${i + 1}</th>
                                <td>${item.country_name}</td>
                                <td>${item.iso_code}</td>
                                <td>
                                    <button type="button" class="btn btn-info waves-effect waves-light btn-sm click_edit">
                                        <i class="ri-pencil-fill"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light btn-sm click_delete">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    } else if (type === 'province') {
                        return `
                            <tr type="${type}" id="${item.id}">
                                <th scope="row">${i + 1}</th>
                                <td>${item.country_name}</td>
                                <td>${item.province_name}</td>
                                <td>
                                    <button type="button" class="btn btn-info waves-effect waves-light btn-sm click_edit">
                                        <i class="ri-pencil-fill"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light btn-sm click_delete">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    } else if (type === 'city') {
                        return `
                            <tr type="${type}" id="${item.id}">
                                <th scope="row">${i + 1}</th>
                                <td>${item.province_name}</td>
                                <td>${item.city_name}</td>
                                <td>
                                    <button type="button" class="btn btn-info waves-effect waves-light btn-sm click_edit">
                                        <i class="ri-pencil-fill"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light btn-sm click_delete">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    }
                }).join('');  // Use `join` to concatenate all rows into a single string

                // Update the table body with the generated list
                $('#table_body').html(list);
            } catch (error) {
                $('#table_body').html('<tr><td colspan="4" class="text-center text-danger">Error loading data</td></tr>');
                console.error('Error fetching data:', error);
            }
        }

        //======================================================================================================
        // delete items
        //======================================================================================================
        $(document).on('click', '.click_delete', function() {
            const $row = $(this).closest('tr'); 
            const type = $row.attr('type');
            const id = $row.attr('id');
            
            deleteItem(type, id, $row); 
        });

        async function deleteItem(type, id, $row) {
            const urls = {
                country: '/country.delete',
                province: '/province.delete',
                city: '/city.delete'
            };
            
            const titles = {
                country: 'Country',
                province: 'Province',
                city: 'City'
            };

            const url = urls[type] || urls['country'];
            const title = titles[type] || titles['country'];

            try {
                const res = await commonDeleteFunction(id, url, title);
                if (res.response) {
                    $row.remove();
                }
            } catch (error) {
                console.error('Error deleting item:', error);
            }
        }

        //======================================================================================================
        // add items
        //======================================================================================================

        $(document).on('click', '#add_new_btn', function(){
            let title = 'Add';
            let list = `<input type="hidden" id="location_type" value="${type}">`;

            if(type === 'country'){
                title = 'Add Country';
                list += `
                    <div class="col-xxl-6 col-md-6 mb-3">
                        <label for="country_name" class="form-label mb-1 req">Country Name</label>
                        <input type="text" class="form-control" id="country_name" placeholder="Enter Country Name" required>
                    </div>
                    <div class="col-xxl-6 col-md-6 mb-3">
                        <label for="country_code" class="form-label mb-1 req">Country Code</label>
                        <input type="text" class="form-control" id="country_code" placeholder="Enter Country Code" required>
                    </div>  
                `;
            }else if(type === 'province'){
                title = 'Add Province';
                list += `
                    <div class="col-xxl-6 col-md-6 mb-3">
                        <label for="province_name" class="form-label mb-1 req">Province Name</label>
                        <input type="text" class="form-control" id="province_name" placeholder="Enter Province Name" required>
                    </div>
                    <div class="col-xxl-6 col-md-6 mb-3">
                        <label for="country_id" class="form-label mb-1">Country</label>
                        <select class="form-select" id="country_id">
                            <option value="">Select Country</option>
                            <option value="1">Country 1</option>
                            <option value="2">Country 2</option>
                        </select>
                    </div>
                `;
            }else{
                title = 'Add City';
                list += `
                    <div class="col-xxl-6 col-md-6 mb-3">
                        <label for="city_name" class="form-label mb-1 req">City Name</label>
                        <input type="text" class="form-control" id="city_name" placeholder="Enter City Name" required>
                    </div>
                    <div class="col-xxl-6 col-md-6 mb-3">
                        <label for="province_id" class="form-label mb-1">Province/State</label>
                        <select class="form-select" id="province_id">
                            <option selected>Select Province</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div> 
                `;
            }

            $('#location-form-title').html(title);
            $('#location-form-body').html(list);
            $('#location-form-modal').modal('show');

        })

        //======================================================================================================
        // edit items
        //======================================================================================================



    </script>

</x-app-layout>