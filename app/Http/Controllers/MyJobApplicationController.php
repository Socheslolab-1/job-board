<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class MyJobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view(
            'my_job_application.index',
            [
                'applications' => $request->user()
                ->jobApplications()
                ->with([
                    'job' => fn($query) => $query->withCount('jobApplications')
                        ->withAvg('jobApplications', 'expected_salary')
                        ->withTrashed(),
                    'job.employer'
                    ])
                ->latest()
                ->get()
            ]
        );
    }


    public function destroy(JobApplication $MyJobApplication)
    {
        $MyJobApplication->delete();

        return redirect()->back()->with(
            'success',
            'Job application removed.'
        );
    }
}
