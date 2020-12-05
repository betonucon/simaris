<?php

namespace App\Imports;

use App\Kpi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Auth;
class KpiImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $data; 

    public function __construct(array $data = [])
    {
        $this->data = $data; 
    }

    public function model(array $row)
    {
        

        $cek=Kpi::where('kode',$row[0])->where('name',$row[1])->where('unit_id',$row[2])->where('tahun',$row[3])->where('periode_id',$this->data['periode_id'])->count();
        if($cek>0){
            $data         = Kpi::where('kode',$row[0])->where('name',$row[1])->where('unit_id',$row[2])->where('tahun',$row[3])->where('periode_id',$this->data['periode_id'])->first();
            $data->name  = $row[1];
            $data->save();
        }else{
            return new Kpi([
                'kode'          => $row[0],
                'name'          => $row[1],
                'unit_id'       => $row[2], 
                'tahun'         => $row[3],
                'periode_id'    => $this->data['periode_id'],
                'creator'       => Auth::user()['kode'],
                'tanggal'       => date('Y-m-d'),
                'deleted'       => 0,
                'level'       => 0,
                'sts'       => 0,
                
                
            ]);
        }
            
    }

     /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
