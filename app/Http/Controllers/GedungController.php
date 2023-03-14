<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gedung;

class GedungController extends Controller
{
    public function index()
    {
        $gedungs = Gedung::paginate(5);

        // Call the firstItem() method on the $gedungs variable
        $firstItem = $gedungs->firstItem();

        return view('pages.table-gedung', compact('gedungs', 'firstItem'));
    }

}
