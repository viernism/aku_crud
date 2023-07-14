@extends('layouts.app', ['title' => 'Panel Atmin'])

@section('content')
    <div>
        {{-- get message --}}
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span><strong>Success!</strong> {{Session::get('success')}} </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span><strong>Fail!</strong> {{Session::get('error')}} </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-6">
                            <h2>Admin <b> Panel</b></h2>
                        </div>
                        <div class="col-6">
                            <a href="#" class="btn btn-success" data-bs-toggle="modal"data-bs-target="#addUserModal" id="addUserBtn">Add New Users</a>
                            <a href="#deleteSelectedUserModal" class="btn btn-danger" data-bs-toggle="modal">Delete</a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                    <label class="form-check-label" for="selectAll"></label>
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Roles</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll"
                                            onchange="updateCheckboxes()" value="{{ $user->id }}">
                                        <label class="form-check-label" for="checkbox1"></label>
                                    </div>
                                </td>
                                <td>{{$user->id}}</td>
                                <td>
                                    @if ($user->photo)
                                    <img src="{{$user->photo}}" alt="" width="75" height="75" style="border-radius: 5px">
                                    @else
                                    <img src="{{ asset('img/defpfp/OIP.jpeg') }}" alt="" width="75" height="75" style="border-radius: 5px">
                                    @endif
                                </td>
                                <td>{{ $user->name }} </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    @foreach ($user->roles as $usro)
                                    {{ $usro->name}}
                                    @if (!$loop->last)
                                    ,
                                    @endif
                                    @endforeach
                                </td>
                                <td>
                                    <a href="#" class="edit" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}" data-user-id="{{ $user->id }}">
                                        <i class="ri-pencil-line" data-bs-toggle="tooltip" title="Edit"></i>
                                    </a>
                                    <a href="#" class="delete" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-user-id="{{ $user->id }}">
                                        <i class="ri-delete-bin-line" data-bs-toggle="tooltip" title="Delete"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text">Showing <b>{{ $users->firstItem() }}</b> to <b>{{ $users->lastItem() }}</b> of
                        <b>{{ $users->total() }}</b> entries</div>
                    <ul class="pagination">
                        @if ($users->currentPage() > 1)
                            <li class="page-item">
                                <a href="{{ $users->previousPageUrl() }}" class="page-link">Previous</a>
                            </li>
                        @endif
                        @for ($i = 1; $i <= $users->lastPage(); $i++)
                            <li class="page-item{{ $users->currentPage() == $i ? ' active' : '' }}">
                                <a href="{{ $users->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor
                        @if ($users->currentPage() < $users->lastPage())
                            <li class="page-item">
                                <a href="{{ $users->nextPageUrl() }}" class="page-link">Next</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal HTML -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="modal-header">
                      <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                      </div>
                      <div class="mb-3">
                        <label for="usn" class="form-label">Username</label>
                        <input type="text" class="form-control" id="usn" name="username" required>
                      </div>
                      <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                      </div>
                      <div class="mb-3">
                        <label for="pwd" class="form-label">Password</label>
                        <input type="password" class="form-control" id="pwd" name="password" required>
                      </div>
                      <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select">
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-success">Add</button>
                    </div>
                  </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    @foreach ($users as $user)
    <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form id="editUserForm" method="POST" action="{{ url('/admin/users-list/update/'.$user->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name"  id="edit-name" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username"  id="edit-username" value="{{ $user->username }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-address" class="form-label">Email</label>
                            <input type="email" class="form-control"name="email"  id="edit-address" value="{{ $user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        @if ($user->hasRole($role->name))
                                            selected
                                        @endif
                                    >
                                        {{ $role->name }}
                                        @if ($user->hasRole($role->name))
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
    <!-- Delete Modal HTML -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteUserModalLabel">Delete User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <form action="{{ route('admin.users.destroy', ':userId') }}" method="POST">
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

    <!-- Delete Selected Modal HTML -->
    <div class="modal fade" id="deleteSelectedUserModal" tabindex="-1"
        aria-labelledby="deleteSelectedUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteSelectedUserModalLabel">Delete Gedung</h4>
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
