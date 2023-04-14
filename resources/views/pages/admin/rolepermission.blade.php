@extends('layouts.app', ['title' => 'Role List'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
              <div class="table-responsive">
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-6">
                                    <h2>Table <b> Role</b></h2>
                                </div>
                                <div class="col-6">
                                    <a href="#addRoleModal" class="btn btn-success" data-bs-toggle="modal">Add</a>
                                    <a href="#deleteSelectedRoleModal" class="btn btn-danger" data-bs-toggle="modal">Delete</a>
                                    <a href="#addPermissionModal" class="btn btn-secondary" data-bs-toggle="modal">Add Permission</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-hover role-permission">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                            <label class="form-check-label" for="selectAll"></label>
                                        </div>
                                    </th>
                                    <th>Nama</th>
                                    <th>Tipe</th>
                                    <th>Permissions</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach ($roles as $role)

                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll"
                                                onchange="updateCheckboxes()" value="{{ $role->id }}">
                                            <label class="form-check-label" for="checkbox1"></label>
                                        </div>
                                    </td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->guard_name }}</td>
                                    <td>
                                        @foreach ($role->permissions as $rope)
                                        "{{ $rope->name}}"
                                        @if (!$loop->last)
                                        ,
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="#" class="edit" data-bs-toggle="modal" data-bs-target="#editRoleModal-{{ $role->id }}"
                                            data-role-id="{{ $role->id }}">
                                            <i class="ri-pencil-line" data-bs-toggle="tooltip" title="Edit"></i>
                                        </a>
                                        <a href="#" class="delete" data-bs-toggle="modal"
                                            data-bs-target="#deleteRoleModal" data-role-id="{{ $role->id }}">
                                            <i class="ri-delete-bin-line" data-bs-toggle="tooltip" title="Delete"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix">
                            <div class="hint-text">Showing <b>{{ $roles->firstItem() }}</b> to <b>{{ $roles->lastItem() }}</b> of
                                <b>{{ $roles->total() }}</b> entries
                            </div>
                            <ul class="pagination">
                                @if ($roles->currentPage() > 1)
                                    <li class="page-item">
                                        <a href="{{ $roles->previousPageUrl() }}" class="page-link">Previous</a>
                                    </li>
                                @endif
                                @for ($i = 1; $i <= $roles->lastPage(); $i++)
                                    <li class="page-item{{ $roles->currentPage() == $i ? ' active' : '' }}">
                                        <a href="{{ $roles->url($i) }}" class="page-link">{{ $i }}</a>
                                    </li>
                                @endfor
                                @if ($roles->currentPage() < $roles->lastPage())
                                    <li class="page-item">
                                        <a href="{{ $roles->nextPageUrl() }}" class="page-link">Next</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            {{-- modal add permission --}}
    <div class="modal fade" id="addPermissionModal" tabindex="-1" role="dialog" aria-labelledby="addPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form method="POST" action="{{ route('permission.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPermissionModalLabel">Add Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Permission</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="guard_name" class="form-label"></label>
                            <input class="form-control" type="text" id="guard_name" name="guard_name" value="web" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Role Modal HTML -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form method="POST" action="{{ route('role.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3 ">
                            <label for="guard_name" class="form-label">Tipe</label>
                            <input class="form-control " type="text" id="guard_name" name="guard_name" value="web" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="permission" class="form-label">Permission</label>
                            <select name="permission" id="permission" class="form-select">
                                @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Role Modal HTML -->
    @foreach ($roles as $role)
    <div class="modal fade" id="editRoleModal-{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="editRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form method="POST" action="{{ url('/admin/rolepermission/edit/'.$role->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Nama Role</label>
                            <input type="text" class="form-control" id="edit-name" name="name" value="{{ $role->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="permission" class="form-label">Permission</label>
                            <select name="permission" id="permission" class="form-select">
                                @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}"
                                    @if ($role->hasPermissionTo($permission->name))
                                    selected
                                    @endif
                                >
                                {{ $permission->name }}
                                @if ($role->hasPermissionTo($permission->name))
                                (Assigned)
                                @endif
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Delete Role Modal HTML -->
    <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteRoleModalLabel">Delete Role</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <form action="{{ route('role.destroy', ':roleId') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Selected Role Modal HTML -->
    <div class="modal fade" id="deleteSelectedRoleModal" tabindex="-1"
        aria-labelledby="deleteSelectedRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteSelectedRoleModalLabel">Delete Role</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="deleteSelected" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Delete selected
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
