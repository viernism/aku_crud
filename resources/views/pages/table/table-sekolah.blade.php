@extends('layouts.app', ['title' => 'Table Sekolah'])

@section('content')
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-6">
                            <h2>Table <b> Sekolah</b></h2>
                        </div>
                        <div class="col-6">
                            <a href="#addSekolahModal" class="btn btn-success" data-bs-toggle="modal">Add New Data</a>
                            <a href="#deleteSelectedSekolahModal" class="btn btn-danger" data-bs-toggle="modal">Delete</a>
                            <a href="/tabel/sekolah/exportexcel" class="btn btn-info">Export</a>
                            <!-- Button trigger modal -->
                            <a href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                class="btn btn-warning">Import</a>

                            <a href="#addLevelModal" class="btn btn-secondary" data-bs-toggle="modal">Add Level</a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <div class="row">
                        <div class="col-md-3">
                            <span>Rows per page:</span>
                            <select class="custom-select form-select" onchange="changePaginationLength(this.value)">
                                <option value="10" {{ $sekolahs->perPage() == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $sekolahs->perPage() == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $sekolahs->perPage() == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $sekolahs->perPage() == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <span>Filter by AM:</span>
                            <select id="filter-am" name="filter-am" class="form-select">
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
                        <div class="col-md-3">
                        </div>
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
                            <th>Level</th>
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
                        @foreach ($sekolahs as $sekolah)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll"
                                            onchange="updateCheckboxes()" value="{{ $sekolah->id }}">
                                        <label class="form-check-label" for="checkbox1"></label>
                                    </div>
                                </td>
                                <td>{{ $sekolah->NAMA }}</td>
                                <td>{{ $sekolah->LEVEL }}</td>
                                <td>{{ $sekolah->ALAMAT }}</td>
                                <td>{{ $sekolah->KOORDINAT }}</td>
                                <td>{{ $sekolah->PIC_CUST }}</td>
                                <td>{{ $sekolah->TEL_CUST }}</td>
                                <td>{{ $sekolah->AM }}</td>
                                <td>{{ $sekolah->TEL_AM }}</td>
                                <td>{{ $sekolah->STO }} </td>
                                <td>{{ $sekolah->HERO }}</td>
                                <td>{{ $sekolah->TEL_HERO }}</td>
                                <td>
                                    <a href="#" class="edit" data-bs-toggle="modal"data-bs-target="#editSekolahModal-{{ $sekolah->id }}" onclick="editSekolah(event, '{{ $sekolah->id }}')">
                                        <i class="ri-pencil-line" data-bs-toggle="tooltip" title="Edit"></i>
                                    </a>
                                    <a href="#" class="delete" data-bs-toggle="modal"
                                        data-bs-target="#deleteSekolahModal" data-sekolah-id="{{ $sekolah->id }}">
                                        <i class="ri-delete-bin-line" data-bs-toggle="tooltip" title="Delete"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text">Showing <b>{{ $sekolahs->firstItem() }}</b> to
                        <b>{{ $sekolahs->lastItem() }}</b> of
                        <b>{{ $sekolahs->total() }}</b> entries
                    </div>
                    <ul class="pagination">
                        @if ($sekolahs->currentPage() > 1)
                            <li class="page-item">
                                <a href="{{ $sekolahs->previousPageUrl() }}" class="page-link">Previous</a>
                            </li>
                        @endif
                        @for ($i = 1; $i <= $sekolahs->lastPage(); $i++)
                            <li class="page-item{{ $sekolahs->currentPage() == $i ? ' active' : '' }}">
                                <a href="{{ $sekolahs->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor
                        @if ($sekolahs->currentPage() < $sekolahs->lastPage())
                            <li class="page-item">
                                <a href="{{ $sekolahs->nextPageUrl() }}" class="page-link">Next</a>
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
                <form action="{{ route('sekolah.importexcel') }}" method="post"
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

    {{-- modal add level --}}
    <div class="modal fade" id="addLevelModal" tabindex="-1" role="dialog" aria-labelledby="addLevelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form method="POST" action="{{ route('sekolah.addlevel') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLevelModalLabel">Add Level</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="LEVEL" class="form-label">Nama Level</label>
                            <input type="text" class="form-control" id="LEVEL" name="LEVEL" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add sekolah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Modal HTML -->
    <div class="modal fade" id="addSekolahModal" tabindex="-1" role="dialog" aria-labelledby="addSekolahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form method="POST" action="{{ route('sekolah.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSekolahModalLabel">Add sekolah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3 ">
                            <label for="level" class="form-label select-label">Level</label>
                            <select name="level" class="form-select">
                                @foreach ($levels as $level)
                                    <option value="{{ $level->LEVEL }}">{{ $level->LEVEL }}</option>
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
                        <button type="submit" class="btn btn-success">Add sekolah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    @foreach ($sekolahs as $sekolah)
    <div class="modal fade modal-dialog-scrollable" id="editSekolahModal-{{ $sekolah->id }}" id="staticBackdrop" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editSekolahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form method="POST" action="{{ url('/tabel/sekolah/edit/'.$sekolah->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSekolahModalLabel">Edit Sekolah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Nama Sekolah</label>
                            <input type="text" class="form-control" id="edit-name" name="NAMA" value="{{ $sekolah->NAMA }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-level" class="form-label select-label">Level</label><br>
                            <select name="KATEGORI" class="form-select" id="edit-level">
                                @foreach ($levels as $level)
                                    <option @selected($level->LEVEL == $sekolah->LEVEL) value="{{ $level->LEVEL }}">{{ $level->LEVEL }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="edit-address" name="ALAMAT" required>{{ $sekolah->ALAMAT }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-coor" class="form-label">Koordinat</label>
                            <input type="text" class="form-control" id="edit-coor" name="KOORDINAT" value="{{ $sekolah->KOORDINAT }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-piccust" class="form-label">PIC Cust</label>
                            <input type="text" class="form-control" id="edit-piccust" name="PIC_CUST" value="{{ $sekolah->PIC_CUST }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-telcust" class="form-label">Tel. Cust</label>
                            <input type="number" class="form-control" id="edit-telcust" name="TEL_CUST" value="{{ $sekolah->TEL_CUST }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-am" class="form-label">AM</label>
                            <input type="text" class="form-control" id="edit-am" name="AM" value="{{ $sekolah->AM }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-telam" class="form-label">Tel. AM</label>
                            <input type="number" class="form-control" id="edit-telam" name="TEL_AM" value="{{ $sekolah->TEL_AM }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-sto" class="form-label">STO</label>
                            <input type="text" class="form-control" id="edit-sto" name="STO" value="{{ $sekolah->STO }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-hero" class="form-label">Hero</label>
                            <input type="text" class="form-control" id="edit-hero" name="HERO" value="{{ $sekolah->HERO }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-telhero" class="form-label">Tel. Hero</label>
                            <input type="number" class="form-control" id="edit-telhero" name="TEL_HERO" value="{{ $sekolah->TEL_HERO }}" required>
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
    <div class="modal fade" id="deleteSekolahModal" tabindex="-1" aria-labelledby="deleteSekolahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteSekolahModalLabel">Delete Sekolah</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <form action="{{ route('sekolah.destroy', ':sekolahId') }}" method="POST">
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
    <div class="modal fade" id="deleteSelectedSekolahModal" tabindex="-1"
        aria-labelledby="deleteSelectedSekolahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteSelectedSekolahModalLabel">Delete Sekolah</h4>
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
