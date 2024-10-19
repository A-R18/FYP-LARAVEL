<?php

namespace App\Http\Controllers;

use App\Models\TestF;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestForm extends Controller
{
    public function show()
    {
        return view("testForm");
    }

    public function store(Request $req)
    {

        $dta = new TestF;
        $dta->name = $req['name'];
        $dta->age = $req['age'];
        $dta->address = $req['address'];
        $dta->save();
        return redirect('')->with('success','Submission Successfull');
    }
}
