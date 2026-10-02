<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Company::latest();

        if ($request->input('archived') === 'true') {
            $query->onlyTrashed();
        } 
        $companies = $query->paginate(10)->onEachSide(1);

        return view('companies.index', compact('companies', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $validatedData = $request->validated();
        Company::create($validatedData);

        return redirect()->route('companies.index')->with('success', 'Company  created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);

        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);

        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $company = Company::findOrFail($id);
        $company->update($validatedData);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company archived successfully.');
    }
    
    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();

        return redirect()->route('companies.index' , ['archived' => 'true'])->with('success', 'Company restored successfully.');
    }
}
