<?php

namespace Database\Seeders;

use App\Models\API\V1\Master\Ledger;
use Illuminate\Database\Seeder;

class LedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'ADJUSTMENT (INTEREST)',
            'ADVANCE RECEIVED FROM GENOME PATIENT',
            'BOOKS & PERIODICALS',
            'BUSINESS PROMOTION',
            'CASH COLLECTION AT HOSPITAL COUNTERS',
            'COMPUTER HARDWARE',
            'COMPUTER SOFTWARE',
            'FURNITURES , FIXTURES & FITTINGS',
            'HDFC BANK A/C 5376',
            'HOUSEKEEPING CONSUMABLES',
            'INCOME FROM DIAGNOSTICS BUSINESS (OP)',
            'INCOME FROM HOSPITAL BUSINESS (OP)',
            'INDUSIND BANK A/C 050-GENOME CLINIC',
            'LAB CONSUMABLE',
            'LINEN STOCK',
            'MEDICAL CONSUMABLES',
            'MEDICAL GAS CONSUMABLE',
            'MEDICAL INSTRUMENT',
            'OP DISCOUNTS',
            'PRINTING & STATIONARY',
            'PURCHASE OF PHARMACY GOODS',
            'REPAIR & MAINTENANCE - OTHERS',
            'REPAIR & MAINTENANCE- BIO MEDICAL',
            'REPAIR & MAINTENANCE EXPENSES- GENERAL',
            'SALE OF PHARMACY GOODS',
            'TEA & COFFEE EXPENSES',
            'TRADE ACCOUNT RECEIVABLE',
            'UTENSILS',
        ];
        foreach($data as $insert) {
            $in['general_ledger'] = $insert;
            Ledger::updateOrCreate( ['general_ledger' =>  $in['general_ledger']],$in);
        }
    }
}
