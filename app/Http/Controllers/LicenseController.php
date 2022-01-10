<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function show(Request $request, License $license)
    {
        return response()->json($license->load(['licenseType', 'company']));
    }

    public function assign(Request $request, Company $company)
    {
        $request->validate([
            'key' => ['required', 'exists:licenses,key']
        ]);


        // $company->li
    }
}
