<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCategoryCreateRequest;
use App\Http\Requests\JobCategoryUpdateRequest;
use App\Models\JobCategories;
use Illuminate\Http\Request;
class JobCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobCategories::latest();

        if ($request->input('archived') === 'true') {
            $query->onlyTrashed();
        } 
        $categories = $query->paginate(10)->onEachSide(1);

        return view('job_categories.index', compact('categories', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request)
    {
        $validatedData = $request->validated();
        JobCategories::create($validatedData);

        return redirect()->route('job_categories.index')->with('success', 'Job category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = JobCategories::findOrFail($id);

        return view('job_categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryUpdateRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $category = JobCategories::findOrFail($id);
        $category->update($validatedData);

        return redirect()->route('job_categories.index')->with('success', 'Job category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = JobCategories::findOrFail($id);
        $category->delete();

        return redirect()->route('job_categories.index')->with('success', 'Job category archived successfully.');
    }
    
    public function restore(string $id)
    {
        $category = JobCategories::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('job_categories.index' , ['archived' => 'true'])->with('success', 'Job category restored successfully.');
    }


}
