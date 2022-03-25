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

    public function assign(Request $request)
    {


        $license = License::where('key',$request->license)->first();
        $company =Company::whereCode($request->company)->first();

        if(!$license) {
            return response()->json([
                "message" => "Invalid license",
                "status" => 412
            ],412);
        }

         if(!$company) {
            return response()->json([
                "message" => "Invalid ID",
                "status" => 412
            ],412);
        }

        if($license->company_id != $company->id) {
            return response()->json([
                "message" => "Invalid license",
                "status" => 412
            ],412);
        }

        return response()->json([
            'license' => $license->key,
            "name" => $license->licenseType->name,
            "period" => $license->licenseType->period,
            "users" => $license->licenseType->desk,
            "cloud" => $license->licenseType->cloud,
            "notification" => $license->licenseType->notification,
            "status" => $license->status,
            "created_at" => $license->created_at,
        ]);
    }
}
