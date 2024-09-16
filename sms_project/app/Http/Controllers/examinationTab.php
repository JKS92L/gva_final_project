<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class examinationTab extends Controller
{
    public function publishResult(){
        return view('admin.examination.publish-results');
    }

    public function viewResult(){
        return view('admin.examination.view-results');
    }
    public function viewQueries()
    {
        return view('admin.examination.view-results-queries');
    }


    public function enterResults()
    {
        return view('admin.examination.enter-results');
    }

    


}
