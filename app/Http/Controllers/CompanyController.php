<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // 1. إنشاء المالك بالأسماء الموجودة في الفورم (email و password)
        $owner = User::create([
            'name' => $validatedData['owner_name'],
            'email' => $validatedData['email'],      // بدلاً من owner_email
            'password' => Hash::make($validatedData['password']), // بدلاً من owner_password
        ]);

        // 2. إنشاء الشركة وربطها بالمالك
        Company::create([
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'industry' => $validatedData['industry'],
            'website' => $validatedData['website'] ?? null,
            'owner_id' => $owner->id,
        ]);

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(?string $id = null)
    {
        if ($id) {
            $company = Company::findOrFail($id);
        } else {
            // تأكد من تسجيل الدخول أولاً إذا لم يكن المسار محمياً بـ middleware
            if (! Auth::check()) {
                abort(403, 'Unauthorized.');
            }

            // استخدام Auth::id() و firstOrFail لتجنب تمرير null للـ view
            $company = Company::where('owner_id', Auth::id())->firstOrFail();
        }

        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(?string $id = null)
    {
        if ($id) {
            $company = Company::findOrFail($id);
        } else {
            if (! Auth::check()) {
                abort(403, 'Unauthorized.');
            }
            $company = Company::where('owner_id', Auth::id())->firstOrFail();
        }

        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */public function update(CompanyUpdateRequest $request, ?string $id = null)
{
    if ($id) {
        $company = Company::findOrFail($id);
    } else {
        $company = Company::where('owner_id', Auth::id())->firstOrFail();
    }

    // 1. تحديث بيانات الشركة
    $company->update([
        'name' => $request->name,
        'address' => $request->address,
        'industry' => $request->industry,
        'website' => $request->website,
    ]);

    // 2. تحديث بيانات المالك
    if ($company->owner) {
        $ownerData = [
            'name' => $request->owner_name,
        ];

        if ($request->filled('password')) {
            $ownerData['password'] = Hash::make($request->password);
        }

        $company->owner->update($ownerData);
    }

    if ($request->query('redirectToList') === 'true') {
        return redirect()->route('companies.index', ['archived' => 'true'])->with('success', 'Company updated successfully.');
    }

    if (Auth::user()?->role === 'company-owner') {
        return redirect()->route('my-company.show')->with('success', 'Company updated successfully.');
    }

    return redirect()->route('companies.show', $company->id)->with('success', 'Company updated successfully.');
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

        return redirect()->route('companies.index', ['archived' => 'true'])->with('success', 'Company restored successfully.');
    }
}
