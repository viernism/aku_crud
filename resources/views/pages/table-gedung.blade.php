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
                            <a href="#l" class="btn btn-success" data-bs-toggle="modal"><i
                                    class="bi bi-plus-circle"></i><span>Add New Data</span></a>
                            <a href="#l" class="btn btn-danger" data-bs-toggle="modal"><i
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
                            <td>{{$gedung->KATEGORI}}</td>
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
    <div class="modal fade" id="addGedungModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('gedung.store')}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDataModalLabel">Add Gedung</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" required>
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
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="editGedungModalLabel">Edit Gedung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Nama Gedung</label>
                        <input type="text" class="form-control" id="edit-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-kategori" class="form-label">Kategori</label>
                        <input type="text" class="form-control" id="edit-kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="edit-address" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-coor" class="form-label">Koordinat</label>
                        <input type="text" class="form-control" id="edit-coor" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-telcust" class="form-label">Tel.  Cust</label>
                        <input type="text" class="form-control" id="edit-telcust" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-piccust" class="form-label">PIC Cust</label>
                        <input type="text" class="form-control" id="edit-piccust" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-am" class="form-label">Koordinat</label>
                        <input type="text" class="form-control" id="edit-am" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-telam" class="form-label">Tel. AM</label>
                        <input type="text" class="form-control" id="edit-telam" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-sto" class="form-label">STO</label>
                        <input type="text" class="form-control" id="edit-sto" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-hero" class="form-label">Hero</label>
                        <input type="text" class="form-control" id="edit-hero" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-telhero" class="form-label">Tel. Hero</label>
                        <input type="text" class="form-control" id="edit-telhero" required>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteGedungModalLabel">Delete Gedung</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete these records?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
