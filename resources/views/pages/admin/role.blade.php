@extends('layouts.app', ['title' => 'Role List'])

@section('content')
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-6">
                            <h2>Table <b> Role</b></h2>
                        </div>
                        <div class="col-6">
                            <a href="#addRoleModal" class="btn btn-success" data-bs-toggle="modal"><i
                                    class="bi bi-plus-circle"></i><span>Add New Role</span></a>
                            <a href="#deleteRoleModal" class="btn btn-danger" data-bs-toggle="modal"><i
                                    class="bi bi-trash"></i><span>Delete</span></a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <div class="row">
                        <div class="col-md-3">
                            <span>Rows per page:</span>
                            <select class="custom-select" onchange="changePaginationLength(this.value)">
                                <option value="10" {{ $roles->perPage() == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $roles->perPage() == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $roles->perPage() == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $roles->perPage() == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <span>Filter by AM:</span>
                            <select id="filter-am" name="filter-am">
                                <option value="" {{ request()->input('filter-am') == '' ? 'selected' : '' }}>All AMs
                                </option>
                                @foreach ($guard_names as $guard_name)
                                    <option value="{{ $guard_name }}"
                                        {{ request()->input('filter-am') == $guard_name ? 'selected' : '' }}>
                                        {{ $guard_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 pb-2 pt-2"></div>
                        <div class="col-md-3">
                            <input type="text" class="form-controller" id="search" name="search" oninput="search()"
                                placeholder="Search...">
                        </div>
                    </div>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($roles as $role)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll"
                                            onchange="updateCheckboxes()">
                                        <label class="form-check-label" for="checkbox1"></label>
                                    </div>
                                </td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->guard_name }}</td>
                                <td>
                                    <a href="#" class="edit" data-bs-toggle="modal" data-bs-target="#editRoleModal"
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
    <!-- Add Modal HTML -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                {{-- <form method="POST" action="{{ route('role.store') }}"> --}}
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3 ">
                            <input class="form-control" type="text" placeholder="Readonly input here…" readonly>
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
    <!-- Edit Modal HTML -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="editRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                {{-- <form method="POST" action="{{ route('role.update', ':roleId') }}"> --}}
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Nama Role</label>
                            <input type="text" class="form-control" id="edit-name" name="NAMA" required>
                        </div>
                        <div class="mb-3">

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
    <!-- Delete Modal HTML -->
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
                {{-- <form action="{{ route('role.destroy', ':roleId') }}" method="POST"> --}}
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
@endsection
