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

        /*
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

       /*

        $db = TestDB::getInstance();

        $pdo = $db->connection();

        $connection = new QueryBuilder($pdo);


        $data['com_code'] = $connection
            ->table('admin_panal_settings')
            ->find_if_exists('com_code', 'system_name', $json['company_name'])['com_code'];



        $data['account_number'] = $connection
            ->table('customers')
            ->find_if_exists('account_number', 'name', $json['customer_name'])['account_number'];


        $connection
            ->table('invoices_pdf')
            ->insert([
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
            ])
            ->execute();

       */


        $data = DB::table('customers')->orderBy('id')->orderBy('id','DESC')->get();

        dd($data);


        return self::SUCCESS;
    }
}