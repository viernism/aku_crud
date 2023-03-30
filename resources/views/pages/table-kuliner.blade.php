@extends('layouts.app', ['title' => 'Table Kuliner'])

@section('content')
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-6">
                            <h2>Table <b> Kuliner</b></h2>
                        </div>
                        <div class="col-6">
                            <a href="#addKulinerModal" class="btn btn-success" data-bs-toggle="modal"><i
                                    class="bi bi-plus-circle"></i><span>Add New Data</span></a>
                            <a href="#deleteKulinerModal" class="btn btn-danger" data-bs-toggle="modal"><i
                                    class="bi bi-trash"></i><span>Delete</span></a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <div class="row">
                        <div class="col-md-3">
                            <span>Rows per page:</span>
                            <select class="custom-select" onchange="changePaginationLength(this.value)">
                                <option value="10" {{ $kuliners->perPage() == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $kuliners->perPage() == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $kuliners->perPage() == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $kuliners->perPage() == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <span>Filter by AM:</span>
                            <select id="filter-am" name="filter-am">
                                <option value="" {{ request()->input('filter-am') == '' ? 'selected' : '' }}>All AMs</option>
                                @foreach ($ams as $am)
                                    <option value="{{ $am }}" {{ request()->input('filter-am') == $am ? 'selected' : '' }}>
                                        {{ $am }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 pb-2 pt-2"></div>
                        <div class="col-md-3">
                            <input type="text" class="form-controller" id="search" name="search" oninput="search()" placeholder="Search...">
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
                            <th>Tel. Cust</th>
                            <th>PIC Cust</th>
                            <th>AM</th>
                            <th>Tel. AM</th>
                            <th>STO</th>
                            <th>Hero</th>
                            <th>Tel. Hero</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($kuliners as $kuliner)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll"
                                        onchange="updateCheckboxes()">
                                    <label class="form-check-label" for="checkbox1"></label>
                                </div>
                            </td>
                            <td>{{$kuliner->NAMA}}</td>
                            <td>{{$kuliner->kategorikuliner->Kategori}}</td>
                            <td>{{$kuliner->ALAMAT}}</td>
                            <td>{{$kuliner->KOORDINAT}}</td>
                            <td>{{$kuliner->TEL_CUST}}</td>
                            <td>{{$kuliner->PIC_CUST}}</td>
                            <td>{{$kuliner->AM}}</td>
                            <td>{{$kuliner->TEL_AM}}</td>
                            <td>{{$kuliner->STO}} </td>
                            <td>{{$kuliner->HERO}}</td>
                            <td>{{$kuliner->TEL_HERO}}</td>
                            <td>
                                <a href="#" class="edit" data-bs-toggle="modal" data-bs-target="#editKulinerModal" data-kuliner-id="{{ $kuliner->id }}">
                                    <i class="ri-pencil-line" data-bs-toggle="tooltip" title="Edit"></i>
                                </a>
                                <a href="#" class="delete" data-bs-toggle="modal" data-bs-target="#deleteKulinerModal" data-kuliner-id="{{ $kuliner->id }}">
                                    <i class="ri-delete-bin-line" data-bs-toggle="tooltip" title="Delete"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text">Showing <b>{{ $kuliners->firstItem() }}</b> to <b>{{ $kuliners->lastItem() }}</b> of
                        <b>{{ $kuliners->total() }}</b> entries</div>
                    <ul class="pagination">
                        @if ($kuliners->currentPage() > 1)
                            <li class="page-item">
                                <a href="{{ $kuliners->previousPageUrl() }}" class="page-link">Previous</a>
                            </li>
                        @endif
                        @for ($i = 1; $i <= $kuliners->lastPage(); $i++)
                            <li class="page-item{{ $kuliners->currentPage() == $i ? ' active' : '' }}">
                                <a href="{{ $kuliners->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor
                        @if ($kuliners->currentPage() < $kuliners->lastPage())
                            <li class="page-item">
                                <a href="{{ $kuliners->nextPageUrl() }}" class="page-link">Next</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal HTML -->
    <div class="modal fade" id="addKulinerModal" tabindex="-1" role="dialog" aria-labelledby="addSekolahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-white">
                <form method="POST" action="{{ route('kuliner.store')}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSekolahModalLabel">Add kuliner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3 ">
                            <label for="kategori" class="form-label">Kategori</label><br>
                            <select name="kategori" class="form-select">
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->Kategori }}</option>
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
                            <label for="tel_cust" class="form-label">Tel. Cust</label>
                            <input type="text" class="form-control" id="tel_cust" name="tel_cust" required>
                        </div>
                        <div class="mb-3">
                            <label for="pic_cust" class="form-label">PIC Cust</label>
                            <input type="text" class="form-control" id="pic_cust" name="pic_cust" required>
                        </div>
                        <div class="mb-3">
                            <label for="am" class="form-label">AM</label>
                            <input type="text" class="form-control" id="am" name="am" required>
                        </div>
                        <div class="mb-3">
                            <label for="tel_am" class="form-label">Tel. AM</label>
                            <input type="text" class="form-control" id="tel_am" name="tel_am" required>
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
                            <input type="text" class="form-control" id="tel_hero" name="tel_hero" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add kuliner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
     <div class="modal fade" id="editKulinerModal" tabindex="-1" role="dialog"
    aria-labelledby="editKulinerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-white">
            <form method="POST" action="{{ route('kuliner.update', ':kulinerId') }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editKulinerModalLabel">Edit Kuliner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nama Kuliner</label>
                        <input type="text" class="form-control" id="edit-name" name="NAMA" required>
                    </div>
                  <div class="mb-3 ">
                            <label for="edit-kategori" class="form-label">Kategori</label><br>
                           <select name="KATEGORI" class="form-select" id="edit-kategori">
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->Kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    <div class="mb-3">
                        <label for="edit-address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="edit-address" name="ALAMAT" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-coor" class="form-label">Koordinat</label>
                        <input type="text" class="form-control" id="edit-coor" name="KOORDINAT" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-telcust" class="form-label">Tel.  Cust</label>
                        <input type="text" class="form-control" id="edit-telcust" name="TEL_CUST" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-piccust" class="form-label">PIC Cust</label>
                        <input type="text" class="form-control" id="edit-piccust" name="PIC_CUST" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-am" class="form-label">AM</label>
                        <input type="text" class="form-control" id="edit-am" name="AM" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-telam" class="form-label">Tel. AM</label>
                        <input type="text" class="form-control" id="edit-telam" name="TEL_AM" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-sto" class="form-label">STO</label>
                        <input type="text" class="form-control" id="edit-sto" name="STO" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-hero" class="form-label">Hero</label>
                        <input type="text" class="form-control" id="edit-hero" name="HERO" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-telhero" class="form-label">Tel. Hero</label>
                        <input type="text" class="form-control" id="edit-telhero" name="TEL_HERO" required>
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
    <div class="modal fade" id="deleteKulinerModal" tabindex="-1" aria-labelledby="deleteKulinerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteKulinerModalLabel">Delete Kuliner</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <form action="{{ route('kuliner.destroy', ':kulinerId') }}" method="POST">
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

