@extends('layouts.app', ['title' => 'Table Health'])

@section('content')
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-6">
                            <h2>Table <b> Health</b></h2>
                        </div>
                        <div class="col-6">
                            <a href="#addHealthModal" class="btn btn-success" data-bs-toggle="modal"><i
                                    class="bi bi-plus-circle"></i><span>Add New Data</span></a>
                            <a href="#deleteHealthModal" class="btn btn-danger" data-bs-toggle="modal"><i
                                    class="bi bi-trash"></i><span>Delete</span></a>
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
                        @foreach ($healths as $health)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll"
                                        onchange="updateCheckboxes()">
                                    <label class="form-check-label" for="checkbox1"></label>
                                </div>
                            </td>
                            <td>{{$health->NAMA}}</td>
                            <td>{{$health->kategorihealth->Kategori}}</td>
                            <td>{{$health->ALAMAT}}</td>
                            <td>{{$health->KOORDINAT}}</td>
                            <td>{{$health->TEL_CUST}}</td>
                            <td>{{$health->PIC_CUST}}</td>
                            <td>{{$health->AM}}</td>
                            <td>{{$health->TEL_AM}}</td>
                            <td>{{$health->STO}} </td>
                            <td>{{$health->HERO}}</td>
                            <td>{{$health->TEL_HERO}}</td>
                            <td>
                                <a href="#" class="edit" data-bs-toggle="modal" data-bs-target="#editHealthModal" data-health-id="{{ $health->id }}">
                                    <i class="ri-pencil-line" data-bs-toggle="tooltip" title="Edit"></i>
                                </a>
                                <a href="#" class="delete" data-bs-toggle="modal" data-bs-target="#deleteHealthModal" data-health-id="{{ $health->id }}">
                                    <i class="ri-delete-bin-line" data-bs-toggle="tooltip" title="Delete"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text">Showing <b>{{ $healths->firstItem() }}</b> to <b>{{ $healths->lastItem() }}</b> of
                        <b>{{ $healths->total() }}</b> entries</div>
                    <ul class="pagination">
                        @if ($healths->currentPage() > 1)
                            <li class="page-item">
                                <a href="{{ $healths->previousPageUrl() }}" class="page-link">Previous</a>
                            </li>
                        @endif
                        @for ($i = 1; $i <= $healths->lastPage(); $i++)
                            <li class="page-item{{ $healths->currentPage() == $i ? ' active' : '' }}">
                                <a href="{{ $healths->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor
                        @if ($healths->currentPage() < $healths->lastPage())
                            <li class="page-item">
                                <a href="{{ $healths->nextPageUrl() }}" class="page-link">Next</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal HTML -->
    <div class="modal fade" id="addHealthModal" tabindex="-1" role="dialog" aria-labelledby="addSekolahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('health.store')}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSekolahModalLabel">Add health</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3 form-floating">
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
                        <button type="submit" class="btn btn-success">Add health</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
     <div class="modal fade" id="editHealthModal" tabindex="-1" role="dialog"
    aria-labelledby="editHealthModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('health.update', ':healthId') }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editHealthModalLabel">Edit Health</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nama Health</label>
                        <input type="text" class="form-control" id="edit-name" name="NAMA" required>
                    </div>
                  <div class="mb-3 form-floating">
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
    <div class="modal fade" id="deleteHealthModal" tabindex="-1" aria-labelledby="deleteHealthModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteHealthModalLabel">Delete Health</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <form action="{{ route('health.destroy', ':healthId') }}" method="POST">
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
