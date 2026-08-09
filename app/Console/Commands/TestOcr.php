<?php

namespace App\Console\Commands;

use App\Database\QueryBuilder;
use App\Database\TestDB;
use App\Database\DB;
use Illuminate\Console\Command;


class TestOcr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:ocr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $ocr = app(\App\Services\OcrService::class);
        $jsonService = app(\App\Services\JsonService::class);

        $images = $ocr->convertPdfToImages(
            'C:\Users\AhmedBhery\Downloads\Documents\Invoice_1_2.pdf'
        );

        $allText = '';

        foreach ($images as $image) {
            $allText .= $ocr->extractTextFromImage($image) . PHP_EOL;
        }

        $allText = preg_replace('/(?:---\s*)+/', '', $allText);
        $allText = trim($allText);

        //dump($allText);

        $json = $jsonService->extractInvoiceData($allText);

        //dump($json);


        $data['com_code'] = DB::table('admin_panal_settings')->where('system_name', $json['company_name'])->value('com_code');


        $data['account_number'] = DB::table('customers')->where('name', $json['customer_name'])->value('account_number');


        DB::table('invoices_pdf')->insert([
            'company_code' =>  $data['com_code'],
            'account_number' =>  $data['account_number'],
            'invoice_auto_serial' => $json['auto_serial'],
            'sub_total' => $json['subtotal'],
            'tax_rate' => $json['tax_rate'],
            'discount_rate' => $json['discount_rate'],
            'final_total' => $json['final_total'],
            'paid' => $json['paid'],
            'remaining' => $json['remaining'],
            'notes' => $json['notes']
        ]);


        return self::SUCCESS;
    }
}