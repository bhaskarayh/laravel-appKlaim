<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use Illuminate\Support\Facades\DB;
use Log;

class ClaimController extends Controller
{
    public function index(){
        $claims = Claim::all();
    
        $combinedData = Claim::getCombinedSummaryAndDetails();
        return view('claims.index', compact('claims', 'combinedData'));
    }

    public function exportToPenampungan()
    {
        $claims = Claim::whereIn('sub_cob', ['LOB', 'KUR', 'PEN'])->get();
        foreach ($claims as $claim) {
            \DB::connection('penampungan')->table('integration_claims')->insert([
                'sub_cob' => $claim->sub_cob,
                'penyebab_klaim' => $claim->penyebab_klaim,
                'id_wilker' => $claim->id_wilker,
                'periode' => $claim->periode,
                'nilai_beban_klaim' => $claim->nilai_beban_klaim,
                'tgl_keputusan_klaim' => $claim->tgl_keputusan_klaim,
                'jumlah_terjamin' => $claim->jumlah_terjamin,
                'debet_kredit'=> $claim->debet_kredit,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
                // echo($claim);
        }

        

        // Logging the export activity
        Log::info('Claims exported to penampungan_db', [
            'count' => $claims->count(),
            'timestamp' => now(),
        ]);

        // die();

        // return redirect()->back()->with('status', 'Claims exported successfully!');

        return "xxx";
    }
}
