<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\License;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function show(Request $request, License $license)
    {
        return response()->json($license->load(['licenseType', 'company']));
    }

    public function assign(Request $request, $license, Company $company)
    {

        $license = License::where('key', $license)->first();

        if (!$license->company || ($license->company_id == $company->id)) {
            $license->company()->create(['company_id' => $company->id]);
            return response()->json([
                'status' => 200
            ]);
        }

        return response()->json([
            'status' => 412
        ], 412);
    }
}
