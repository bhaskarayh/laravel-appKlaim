<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use Illuminate\Support\Facades\DB;

class ClaimController extends Controller
{
    public function index(){
        $claims = Claim::all();
    
        $combinedData = Claim::getCombinedSummaryAndDetails();
        return view('claims.index', compact('claims', 'combinedData'));
    }

    public function exportToPenampungan()
    {
        $claims = Claim::whereIn('sub_cob', ['KUR', 'PEN'])->get();
        foreach ($claims as $claim) {
            \DB::connection('penampungan')->table('integration_claims')->insert([
                'sub_cob' => $claim->sub_cob,
                'penyebab_klaim' => $claim->penyebab_klaim,
                'periode' => $claim->periode,
                'nilai_beban_klaim' => $claim->nilai_beban_klaim,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Logging the export activity
        Log::info('Claims exported to penampungan_db', [
            'count' => $claims->count(),
            'timestamp' => now(),
        ]);

        return redirect()->back()->with('status', 'Claims exported successfully!');
    }
}
