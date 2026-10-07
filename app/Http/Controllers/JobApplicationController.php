<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Http\Requests\JobApplicationUpdateRequest;
use Illuminate\Support\Facades\Auth;
class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // تحميل العلاقات لتسريع الاستعلام
        $query = JobApplication::with(['user', 'jobVacancy', 'resume'])->latest();

         if(Auth::user()->role == 'company-owner'){
            $query->whereHas('jobVacancy', function($query) {
                $query->where('company_id', Auth::user()->company->id);
            });
        }

        if ($request->input('archived') === 'true') {
            $query->onlyTrashed();
        }

        $jobApplications = $query->paginate(10)->onEachSide(1);

        return view('job_applications.index', compact('jobApplications'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);

        return view('job_applications.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return view('job_applications.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationUpdateRequest $request, string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->update([
            'status' => $request->input('status'),
        ]);

        if($request->query('redirectToList') == 'false'){
            return redirect()->route('job_applications.show', $id)->with('success', 'Applicant status updated successfully!');
        }

        return redirect()->route('job_applications.index')->with('success', 'Applicant status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->delete();
        return redirect()->route('job_applications.index')->with('success', 'Applicant archived successfully');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $jobApplication = JobApplication::withTrashed()->findOrFail($id);
        $jobApplication->restore();
        return redirect()->route('job_applications.index', ['archived' => 'true'])->with('success', 'Applicant restored successfully');
    }
}
