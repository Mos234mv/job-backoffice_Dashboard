<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\Company;
use App\Models\JobCategories;
use App\Models\JobVacancy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobVacancy::latest();
        if(Auth::user()->role == 'company-owner'){
    $query->where('company_id', Auth::user()->company->id);
}

        if ($request->input('archived') === 'true') {
            $query->onlyTrashed();
        }
        $jobVacancies = $query->paginate(10)->onEachSide(1);

        return view('job_vacancies.index', compact('jobVacancies', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $jobCategories = JobCategories::all();

        return view('job_vacancies.create', compact('companies', 'jobCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyCreateRequest $request)
    {
        $validated = $request->validated();
        $jobVacancy = JobVacancy::create($validated);

        return redirect()->route('job_vacancies.index')->with('success', 'Job Vacancy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findorfail($id);

        return view('job_vacancies.show', compact('jobVacancy'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $companies = Company::all();
        $jobCategories = JobCategories::all();

        return view('job_vacancies.edit', compact('jobVacancy', 'companies', 'jobCategories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->update($validated);

        if ($request->query('redirectToList') == 'false') {
            return redirect()->route('job_vacancies.show', $id);
        }

        return redirect()->route('job_vacancies.index', $id)->with('success', 'Job vacancy updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();

        return redirect()->route('job_vacancies.index')->with('success', 'Job vacancy deleted successfully');
    }

    /**
     * Restore the specified soft-deleted resource.
     */
    public function restore(string $id): RedirectResponse
    {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $jobVacancy->restore();

        return redirect()->route('job_vacancies.index', ['archived' => 'true'])->with('success', 'Job vacancy restored successfully');
    }
}
