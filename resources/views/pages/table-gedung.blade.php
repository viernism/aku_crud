@extends('layouts.app', ['title' => 'Table Gedung'])

@section('content')
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-6">
                            <h2>Table <b> Gedung</b></h2>
                        </div>
                        <div class="col-6">
                            <a href="#addGedungModal" class="btn btn-success" data-bs-toggle="modal"><i
                                    class="bi bi-plus-circle"></i><span>Add New Data</span></a>
                            <a href="#deleteGedungModal" class="btn btn-danger" data-bs-toggle="modal"><i
                                    class="bi bi-trash"></i><span>Delete</span></a>
                            <a href="/tabel/gedung/exportexcel" class="btn btn-info">Export</a>
                            <!-- Button trigger modal -->
                            <a href="" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-warning">Import</a>
                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('gedung.importexcel') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="formFile" class="form-label">Insert File</label>
                                                    <input class="form-control" type="file" id="formFile" name="upexcel"><br>
                                                    <p>Caution: only .XLSX files allowed</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning" data-bs-dismiss="modal">Import</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
                        @foreach ($gedungs as $gedung)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll"
                                        onchange="updateCheckboxes()">
                                    <label class="form-check-label" for="checkbox1"></label>
                                </div>
                            </td>
                            <td>{{$gedung->NAMA}}</td>
                            <td>{{$gedung->kategorigedung->Kategori}}</td>
                            <td>{{$gedung->ALAMAT}}</td>
                            <td>{{$gedung->KOORDINAT}}</td>
                            <td>{{ $gedung->TEL_CUST}}</td>
                            <td>{{$gedung->PIC_CUST}}</td>
                            <td>{{$gedung->AM}}</td>
                            <td>{{$gedung->TEL_AM}}</td>
                            <td>{{$gedung->STO}} </td>
                            <td>{{$gedung->HERO}}</td>
                            <td>{{$gedung->TEL_HERO}}</td>
                            <td>
                                <a href="#" class="edit" data-bs-toggle="modal" data-bs-target="#editGedungModal" data-gedung-id="{{ $gedung->id }}">
                                    <i class="ri-pencil-line" data-bs-toggle="tooltip" title="Edit"></i>
                                </a>
                                <a href="#" class="delete" data-bs-toggle="modal" data-bs-target="#deleteGedungModal" data-gedung-id="{{ $gedung->id }}">
                                    <i class="ri-delete-bin-line" data-bs-toggle="tooltip" title="Delete"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text">Showing <b>{{ $gedungs->firstItem() }}</b> to <b>{{ $gedungs->lastItem() }}</b> of
                        <b>{{ $gedungs->total() }}</b> entries</div>
                    <ul class="pagination">
                        @if ($gedungs->currentPage() > 1)
                            <li class="page-item">
                                <a href="{{ $gedungs->previousPageUrl() }}" class="page-link">Previous</a>
                            </li>
                        @endif
                        @for ($i = 1; $i <= $gedungs->lastPage(); $i++)
                            <li class="page-item{{ $gedungs->currentPage() == $i ? ' active' : '' }}">
                                <a href="{{ $gedungs->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor
                        @if ($gedungs->currentPage() < $gedungs->lastPage())
                            <li class="page-item">
                                <a href="{{ $gedungs->nextPageUrl() }}" class="page-link">Next</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal HTML -->
    <div class="modal fade modal-dialog-scrollable" id="addGedungModal" id="staticBackdrop" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addSekolahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('gedung.store')}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSekolahModalLabel">Add Gedung</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
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
                        <button type="submit" class="btn btn-success">Add Gedung</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
     <div class="modal fade" id="editGedungModal" tabindex="-1" role="dialog"
    aria-labelledby="editGedungModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('gedung.update', ':gedungId') }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editGedungModalLabel">Edit Gedung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nama Gedung</label>
                        <input type="text" class="form-control" id="edit-name" name="NAMA" value="{{ old('NAMA', $gedung->NAMA) }}"  required>
                    </div>
                  <div class="mb-3">
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
    <div class="modal fade" id="deleteGedungModal" tabindex="-1" aria-labelledby="deleteGedungModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteGedungModalLabel">Delete Gedung</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <form action="{{ route('gedung.destroy', ':gedungId') }}" method="POST">
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
