<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CSVImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        
        $file = $request->file('csv_file');
        $filePath = $file->getRealPath();

        
        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            
            
            fgetcsv($handle, 1000, ',');

            $dataToInsert = [];
            
            while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $dataToInsert[] = [
                    'id'         => $row[0],
                    'name'       => $row[1],
                    'email'      => $row[2],
                    'city'       => $row[3],
                    'country'    => $row[4],
                    'signup_date' => $row[5], 
                    'amount'     => $row[6], 
                ];
            }
            fclose($handle);

            if (!empty($dataToInsert)) {
                DB::table('people')->insert($dataToInsert);
            }
            return redirect()->route('WarmtenetDashboard')->with('success', 'CSV imported successfully!');
        }
        return redirect()->back()->with('error', 'Failed to open the CSV file.');
    }
}
