@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4">Permission Management</h2>
    
    <div class="row">
        <div class="col-md-12">
            <form id="permissionsForm">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Permission</th>
                            <th>Sub-Permission</th>
                            <th>Permission Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($per_struct as $permission)
                            <tr>
                                <td>
                                    <input type="checkbox" name="permissions[]" 
                                        value="{{ $permission->pm_id }}" 
                                        {{ $permission->permission ? 'checked' : '' }}>
                                    {{ $permission->pm_name }}
                                </td>
                                <td>
                                    <table class="table table-sm">
                                        @foreach($permission->sub as $sub)
                                            <tr>
                                                <td>
                                                    {{ $sub->ps_name }}
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="sub_permissions[{{ $permission->pm_id }}][]" 
                                                        value="{{ $sub->ps_id }}" 
                                                        {{ $sub->permission ? 'checked' : '' }}>
                                                </td>
                                                <td>
                                                    <select name="allow[{{ $permission->pm_id }}][{{ $sub->ps_id }}]" class="form-control">
                                                        <option value="1" {{ $sub->allow == 1 ? 'selected' : '' }}>Allow</option>
                                                        <option value="2" {{ $sub->allow == 2 ? 'selected' : '' }}>Edit Only</option>
                                                        <option value="3" {{ $sub->allow == 3 ? 'selected' : '' }}>Delete Only</option>
                                                        <option value="4" {{ $sub->allow == 4 ? 'selected' : '' }}>No Access</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm edit-permission"
                                        data-pm-id="{{ $permission->pm_id }}">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Save Permissions</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#permissionsForm').on('submit', function(e){
            e.preventDefault();

            $.ajax({
                url: "{{ route('permissions.add') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.stt === 'ok') {
                        alert('Permissions updated successfully.');
                    } else {
                        alert('Failed to update permissions.');
                    }
                },
                error: function(xhr) {
                    alert('Something went wrong.');
                }
            });
        });
    });
</script>
@endsection
