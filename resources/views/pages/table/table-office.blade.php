@extends('layouts.app', ['title' => 'Table Office'])

@section('content')
    <div >
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
                            <h2>Table <b> Office</b></h2>
                        </div>
                        <div class="col-6">
                            <a href="#addOfficeModal" class="btn btn-success" data-bs-toggle="modal">Add New Data</a>
                            <a href="#deleteSelectedOfficeModal" class="btn btn-danger" data-bs-toggle="modal">Delete</a>
                            <a href="{{route('office.exportexcel')}}" class="btn btn-info">Export</a>
                            <!-- Button trigger modal -->
                            <a href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-warning">Import</a>

                            <a href="#addKategoriModal" class="btn btn-secondary" data-bs-toggle="modal">Add Kategori</a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <div class="row">
                        <div class="col-md-3">
                            <span>Rows per page:</span>
                            <select class="custom-select form-select" onchange="changePaginationLength(this.value)">
                                <option value="10" {{ $offices->perPage() == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $offices->perPage() == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $offices->perPage() == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $offices->perPage() == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <span>Filter by AM:</span>
                            <select class="form-select" id="filter-am" name="filter-am">
                                <option value="" {{ request()->input('filter-am') == '' ? 'selected' : '' }}>All AMs
                                </option>
                                @foreach ($ams as $am)
                                    <option value="{{ $am }}"
                                        {{ request()->input('filter-am') == $am ? 'selected' : '' }}>
                                        {{ $am }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 pb-2 pt-2"></div>
                        <div class="col-md-3 form-inline">
                            <span>Search</span>
                            <input type="text" class="form-control mr-sm-2" id="search" name="search"
                                oninput="search()" placeholder="Search by Name or AMs">
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
                            <th>Kategori</th>
                            <th>Alamat</th>
                            <th>Koordinat</th>
                            <th>PIC Cust</th>
                            <th>Tel. Cust</th>
                            <th>AM</th>
                            <th>Tel. AM</th>
                            <th>STO</th>
                            <th>Hero</th>
                            <th>Tel. Hero</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($offices as $office)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll"
                                            onchange="updateCheckboxes()" value="{{ $office->id }}">
                                        <label class="form-check-label" for="checkbox1"></label>
                                    </div>
                                </td>
                                <td>{{ $office->NAMA }}</td>
                                <td>{{ $office->KATEGORI }}</td>
                                <td>{{ $office->ALAMAT }}</td>
                                <td>{{ $office->KOORDINAT }}</td>
                                <td>{{ $office->PIC_CUST }}</td>
                                <td>{{ $office->TEL_CUST }}</td>
                                <td>{{ $office->AM }}</td>
                                <td>{{ $office->TEL_AM }}</td>
                                <td>{{ $office->STO }} </td>
                                <td>{{ $office->HERO }}</td>
                                <td>{{ $office->TEL_HERO }}</td>
                                <td>
                                    <a href="#" class="edit" data-bs-toggle="modal"
                                        data-bs-target="#editOfficeModal-{{$office->id}}" data-office-id="{{ $office->id }}">
                                        <i class="ri-pencil-line" data-bs-toggle="tooltip" title="Edit"></i>
                                    </a>
                                    <a href="#" class="delete" data-bs-toggle="modal"
                                        data-bs-target="#deleteOfficeModal" data-office-id="{{ $office->id }}">
                                        <i class="ri-delete-bin-line" data-bs-toggle="tooltip" title="Delete"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text">Showing <b>{{ $offices->firstItem() }}</b> to
                        <b>{{ $offices->lastItem() }}</b> of
                        <b>{{ $offices->total() }}</b> entries
                    </div>
                    <ul class="pagination">
                        @if ($offices->currentPage() > 1)
                            <li class="page-item">
                                <a href="{{ $offices->previousPageUrl() }}" class="page-link">Previous</a>
                            </li>
                        @endif
                        @for ($i = 1; $i <= $offices->lastPage(); $i++)
                            <li class="page-item{{ $offices->currentPage() == $i ? ' active' : '' }}">
                                <a href="{{ $offices->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor
                        @if ($offices->currentPage() < $offices->lastPage())
                            <li class="page-item">
                                <a href="{{ $offices->nextPageUrl() }}" class="page-link">Next</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
        <!-- Modal import -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('office.importexcel') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Insert File</label>
                            <input class="form-control" type="file" id="formFile"
                                name="upexcel"><br>
                            <p>Caution: only .XLSX files allowed</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning"
                            data-bs-dismiss="modal">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal add kategori --}}
    <div class="modal fade" id="addKategoriModal" tabindex="-1" role="dialog" aria-labelledby="addKategoriModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form method="POST" action="{{ route('office.addkategori') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addKategoriModalLabel">Add Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="Kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="Kategori" name="Kategori" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add office</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Modal HTML -->
    <div class="modal fade" id="addOfficeModal" tabindex="-1" role="dialog" aria-labelledby="addOfficeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form method="POST" action="{{ route('office.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addOfficeModalLabel">Add office</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3 ">
                            <label for="kategori" class="form-label select-label">Kategori</label>
                            <select name="kategori" class="form-select">
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->Kategori }}">{{ $kategori->Kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="koordinat" class="form-label">Koordinat</label>
                            <input type="text" class="form-control" id="koordinat" name="koordinat" required>
                        </div>
                        <div class="mb-3">
                            <label for="pic_cust" class="form-label">PIC Cust</label>
                            <input type="text" class="form-control" id="pic_cust" name="pic_cust" required>
                        </div>
                        <div class="mb-3">
                            <label for="tel_cust" class="form-label">Tel. Cust</label>
                            <input type="number" class="form-control" id="tel_cust" name="tel_cust" required>
                        </div>
                        <div class="mb-3">
                            <label for="am" class="form-label">AM</label>
                            <input type="text" class="form-control" id="am" name="am" required>
                        </div>
                        <div class="mb-3">
                            <label for="tel_am" class="form-label">Tel. AM</label>
                            <input type="number" class="form-control" id="tel_am" name="tel_am" required>
                        </div>
                        <div class="mb-3">
                            <label for="sto" class="form-label">STO</label>
                            <input type="text" class="form-control" id="sto" name="sto" required>
                        </div>
                        <div class="mb-3">
                            <label for="hero" class="form-label">Hero</label>
                            <input type="text" class="form-control" id="hero" name="hero" required>
                        </div>
                        <div class="mb-3">
                            <label for="tel_hero" class="form-label">Tel. Hero</label>
                            <input type="number" class="form-control" id="tel_hero" name="tel_hero" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add office</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    @foreach ($offices as $office)
    <div class="modal fade modal-dialog-scrollable" id="editOfficeModal-{{ $office->id }}" id="staticBackdrop" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editOfficeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form method="POST" action="{{ url('/tabel/office/edit/'.$office->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editOfficeModalLabel">Edit Office</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Nama Office</label>
                            <input type="text" class="form-control" id="edit-name" name="NAMA" value="{{ $office->NAMA }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-kategori" class="form-label select-label">Kategori</label><br>
                            <select name="KATEGORI" class="form-select" id="edit-kategori">
                                @foreach ($kategoris as $kategori)
                                    <option @selected($kategori->Kategori == $office->KATEGORI) value="{{ $kategori->Kategori }}">{{ $kategori->Kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="edit-address" name="ALAMAT" required>{{ $office->ALAMAT }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-coor" class="form-label">Koordinat</label>
                            <input type="text" class="form-control" id="edit-coor" name="KOORDINAT" value="{{ $office->KOORDINAT }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-piccust" class="form-label">PIC Cust</label>
                            <input type="text" class="form-control" id="edit-piccust" name="PIC_CUST" value="{{ $office->PIC_CUST }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-telcust" class="form-label">Tel. Cust</label>
                            <input type="number" class="form-control" id="edit-telcust" name="TEL_CUST" value="{{ $office->TEL_CUST }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-am" class="form-label">AM</label>
                            <input type="text" class="form-control" id="edit-am" name="AM" value="{{ $office->AM }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-telam" class="form-label">Tel. AM</label>
                            <input type="number" class="form-control" id="edit-telam" name="TEL_AM" value="{{ $office->TEL_AM }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-sto" class="form-label">STO</label>
                            <input type="text" class="form-control" id="edit-sto" name="STO" value="{{ $office->STO }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-hero" class="form-label">Hero</label>
                            <input type="text" class="form-control" id="edit-hero" name="HERO" value="{{ $office->HERO }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-telhero" class="form-label">Tel. Hero</label>
                            <input type="number" class="form-control" id="edit-telhero" name="TEL_HERO" value="{{ $office->TEL_HERO }}" required>
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
    <div class="modal fade" id="deleteOfficeModal" tabindex="-1" aria-labelledby="deleteOfficeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteOfficeModalLabel">Delete Office</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <form action="{{ route('office.destroy', ':officeId') }}" method="POST">
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
    <div class="modal fade" id="deleteSelectedOfficeModal" tabindex="-1"
        aria-labelledby="deleteSelectedOfficeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteSelectedOfficeModalLabel">Delete Office</h4>
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
