<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_cob', 'penyebab_klaim', 'periode', 'id_wilker', 
        'tgl_keputusan_klaim', 'jumlah_terjamin', 'nilai_beban_klaim', 'debet_kredit'
    ];


    public static function getCombinedSummaryAndDetails()
    {
        return DB::table('claims')
            ->select('sub_cob', 'penyebab_klaim', 
                     DB::raw('SUM(nilai_beban_klaim) as total_nilai_beban_klaim'), 
                     DB::raw('COUNT(*) as total_klaim'))
            ->groupBy('sub_cob', 'penyebab_klaim')
            ->orderBy('sub_cob')
            ->get();
    }
}
