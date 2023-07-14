@extends('layouts.app', ['title' => 'Table Tourism'])

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
                            <h2>Table <b> Tourism</b></h2>
                        </div>
                        <div class="col-6">
                            <a href="#addTourismModal" class="btn btn-success" data-bs-toggle="modal">Add New Data</a>
                            <a href="#deleteSelectedTourismModal" class="btn btn-danger" data-bs-toggle="modal">Delete</a>
                            <a href="{{route('tourism.exportexcel')}}" class="btn btn-info">Export</a>
                            <!-- Button trigger modal -->
                            <a href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                class="btn btn-warning">Import</a>

                            <a href="#addKategoriModal" class="btn btn-secondary" data-bs-toggle="modal">Add Kategori</a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <div class="row">
                        <div class="col-md-3">
                            <span>Rows per page:</span>
                            <select class="custom-select form-select" onchange="changePaginationLength(this.value)">
                                <option value="10" {{ $tourisms->perPage() == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $tourisms->perPage() == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $tourisms->perPage() == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $tourisms->perPage() == 100 ? 'selected' : '' }}>100</option>
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
                        @foreach ($tourisms as $tourism)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll"
                                            onchange="updateCheckboxes()" value="{{ $tourism->id }}">
                                        <label class="form-check-label" for="checkbox1"></label>
                                    </div>
                                </td>
                                <td>{{ $tourism->NAMA }}</td>
                                <td>{{ $tourism->KATEGORI }}</td>
                                <td>{{ $tourism->ALAMAT }}</td>
                                <td>{{ $tourism->KOORDINAT }}</td>
                                <td>{{ $tourism->PIC_CUST }}</td>
                                <td>{{ $tourism->TEL_CUST }}</td>
                                <td>{{ $tourism->AM }}</td>
                                <td>{{ $tourism->TEL_AM }}</td>
                                <td>{{ $tourism->STO }} </td>
                                <td>{{ $tourism->HERO }}</td>
                                <td>{{ $tourism->TEL_HERO }}</td>
                                <td>
                                    <a href="#" class="edit" data-bs-toggle="modal"
                                        data-bs-target="#editTourismModal-{{$tourism->id}}" data-tourism-id="{{ $tourism->id }}">
                                        <i class="ri-pencil-line" data-bs-toggle="tooltip" title="Edit"></i>
                                    </a>
                                    <a href="#" class="delete" data-bs-toggle="modal"
                                        data-bs-target="#deleteTourismModal" data-tourism-id="{{ $tourism->id }}">
                                        <i class="ri-delete-bin-line" data-bs-toggle="tooltip" title="Delete"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text">Showing <b>{{ $tourisms->firstItem() }}</b> to
                        <b>{{ $tourisms->lastItem() }}</b> of
                        <b>{{ $tourisms->total() }}</b> entries
                    </div>
                    <ul class="pagination">
                        @if ($tourisms->currentPage() > 1)
                            <li class="page-item">
                                <a href="{{ $tourisms->previousPageUrl() }}" class="page-link">Previous</a>
                            </li>
                        @endif
                        @for ($i = 1; $i <= $tourisms->lastPage(); $i++)
                            <li class="page-item{{ $tourisms->currentPage() == $i ? ' active' : '' }}">
                                <a href="{{ $tourisms->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor
                        @if ($tourisms->currentPage() < $tourisms->lastPage())
                            <li class="page-item">
                                <a href="{{ $tourisms->nextPageUrl() }}" class="page-link">Next</a>
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
                <form action="{{ route('tourism.importexcel') }}" method="post"
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
                <form method="POST" action="{{ route('tourism.addkategori') }}">
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
                        <button type="submit" class="btn btn-success">Add tourism</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Modal HTML -->
    <div class="modal fade" id="addTourismModal" tabindex="-1" role="dialog" aria-labelledby="addTourismModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form method="POST" action="{{ route('tourism.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTourismModalLabel">Add tourism</h5>
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
                        <button type="submit" class="btn btn-success">Add tourism</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    @foreach ($tourisms as $tourism)
    <div class="modal fade modal-dialog-scrollable" id="editTourismModal-{{ $tourism->id }}" id="staticBackdrop" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editTourismModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form method="POST" action="{{ url('/tabel/tourism/edit/'.$tourism->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTourismModalLabel">Edit Tourism</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Nama Tourism</label>
                            <input type="text" class="form-control" id="edit-name" name="NAMA" value="{{ $tourism->NAMA }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-kategori" class="form-label select-label">Kategori</label><br>
                            <select name="KATEGORI" class="form-select" id="edit-kategori">
                                @foreach ($kategoris as $kategori)
                                    <option @selected($kategori->Kategori == $tourism->KATEGORI) value="{{ $kategori->Kategori }}">{{ $kategori->Kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="edit-address" name="ALAMAT" required>{{ $tourism->ALAMAT }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-coor" class="form-label">Koordinat</label>
                            <input type="text" class="form-control" id="edit-coor" name="KOORDINAT" value="{{ $tourism->KOORDINAT }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-piccust" class="form-label">PIC Cust</label>
                            <input type="text" class="form-control" id="edit-piccust" name="PIC_CUST" value="{{ $tourism->PIC_CUST }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-telcust" class="form-label">Tel. Cust</label>
                            <input type="number" class="form-control" id="edit-telcust" name="TEL_CUST" value="{{ $tourism->TEL_CUST }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-am" class="form-label">AM</label>
                            <input type="text" class="form-control" id="edit-am" name="AM" value="{{ $tourism->AM }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-telam" class="form-label">Tel. AM</label>
                            <input type="number" class="form-control" id="edit-telam" name="TEL_AM" value="{{ $tourism->TEL_AM }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-sto" class="form-label">STO</label>
                            <input type="text" class="form-control" id="edit-sto" name="STO" value="{{ $tourism->STO }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-hero" class="form-label">Hero</label>
                            <input type="text" class="form-control" id="edit-hero" name="HERO" value="{{ $tourism->HERO }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-telhero" class="form-label">Tel. Hero</label>
                            <input type="number" class="form-control" id="edit-telhero" name="TEL_HERO" value="{{ $tourism->TEL_HERO }}" required>
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
    <div class="modal fade" id="deleteTourismModal" tabindex="-1" aria-labelledby="deleteTourismModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteTourismModalLabel">Delete Tourism</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <form action="{{ route('tourism.destroy', ':tourismId') }}" method="POST">
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
    <div class="modal fade" id="deleteSelectedTourismModal" tabindex="-1"
        aria-labelledby="deleteSelectedTourismModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteSelectedTourismModalLabel">Delete Tourism</h4>
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
