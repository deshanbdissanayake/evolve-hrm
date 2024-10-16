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
                <div class="card-header align-items-center d-flex">
                    <button type="button" class="btn btn-primary waves-effect waves-light material-shadow-none mr-1">Country</button>
                    <button type="button" class="btn btn-outline-primary waves-effect waves-light material-shadow-none mr-1">Province</button>
                    <button type="button" class="btn btn-outline-primary waves-effect waves-light material-shadow-none">City</button>
                </div>
                <div class="card-body">

                    

                </div>
            </div>
        </div>
    </div>

</x-app-layout>