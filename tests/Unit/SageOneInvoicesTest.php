<?php

namespace Tests\Unit;

use Carbon\Carbon;
use RevoSystems\SageOne\SObjects\Contact;
use RevoSystems\SageOne\SObjects\ContactPayment;
use RevoSystems\SageOne\SObjects\LedgerAccount;
use RevoSystems\SageOne\SObjects\SalesInvoice;

class SageOneInvoicesTest extends SageOneBaseTest
{

    private $invoice;
    private $products;
    private $contact;
    private $ledgerAccount;

    public function tearDown()
    {
        $this->invoice->destroy();
        collect($this->products)->each(function ($product) {
            $product->destroy();
        });
        $this->ledgerAccount->destroy();
        $this->contact->destroy();
    }

    /** @test */
    public function can_create_sage_invoice()
    {
        $this->contact    = (new Contact($this->api, [
            "name"             => "Jordi",
            "contact_type_ids" => ["Customer"],
        ]))->create();

        $this->ledgerAccount = (new LedgerAccount($this->api))
            ->where("?ledger_account_type_id=SALES&items_per_page=100&ledger_account_classification=ES_SALES_AND_INCOMES")
            ->get()->first(function ($ledgerAccount) {
                return str_contains($ledgerAccount->displayed_as, '70000000');
            });
        $this->ledgerAccount = (new LedgerAccount($this->api))->find($this->ledgerAccount->id);
        $invoiceResource = (new SalesInvoice($this->api));
        $invoices_count  = $invoiceResource->count();

        $this->invoice = (new SalesInvoice($this->api, [
            "contact_id"        => $this->contact->id,
            "date"              => Carbon::now()->toDateString(),
            "main_address"      => [
                "name"              => "Main Address",
                "address_line_1"    => "C/Església nº 18",
                "address_line_2"    => "",
                "city"              => "Sant Salvador de Guardiola",
                "region"            => "Barcelona",
                "postal_code"       => "08253",
                "country_id"        => "ES"
            ], "invoice_lines"      => [
                [
                    "description" => "Line 1",
                    "ledger_account_id" => $this->ledgerAccount->id,
                    "quantity" => 2,
                    "unit_price" => 55,
                    "tax_rate_id" => $this->ledgerAccount->tax_rate["id"],
                ],
            ]
        ]))->create();

        $this->assertNotFalse($this->invoice->id);
        $this->assertEquals($this->contact->id, $this->invoice->contact_id);
        $this->assertEquals(Carbon::now()->toDateString(), $this->invoice->date);
        $this->assertCount(1, $this->invoice->invoice_lines);
        $this->assertEquals($invoices_count + 1, $invoiceResource->count());
    }

    //** @test */
    public function can_create_and_pay_a_sage_invoice()
    {
//        $this->contact    = (new Contact($this->api, [
//            "name"             => "Jordi",
//            "contact_type_ids" => ["Customer"],
//        ]))->create();
//
        $this->ledgerAccount = (new LedgerAccount($this->api))
            ->where("?ledger_account_type_id=SALES&items_per_page=100&ledger_account_classification=ES_SALES_AND_INCOMES")
            ->get()->first(function ($ledgerAccount) {
                return str_contains($ledgerAccount->displayed_as, '70000000');
            });
        $invoiceResource = (new SalesInvoice($this->api));
        $invoices_count  = $invoiceResource->count();

        $contactPayment = (new ContactPayment($this->api, [
            "transaction_type_id" => "CUSTOMER_RECEIPT",
            "contact_id" => $this->contact->id,
            "bank_account_id" => "a3243d03081611e8b587065b8ec10ed1",
            "date" => Carbon::now()->toDateString(),
            "total_amount"  => 100,
        ]))->create();

        $this->invoice = (new SalesInvoice($this->api, [
            "contact_id"        => $this->contact->id,
            "date"              => Carbon::now()->toDateString(),
            "main_address"      => [
                "name"              => "Main Address",
                "address_line_1"    => "C/Església nº 18",
                "address_line_2"    => "",
                "city"              => "Sant Salvador de Guardiola",
                "region"            => "Barcelona",
                "postal_code"       => "08253",
                "country_id"        => "ES"
            ], "invoice_lines"      => [
                [
                    "description" => "Line 1",
                    "ledger_account_id" => $this->ledgerAccount->id,
                    "quantity" => 2,
                    "unit_price" => 55,
                    "tax_rate_id" => "ES_STANDARD",
                ],
            ],
//            "payments_allocations"   => [
//                [
//                    "amount" => 110,
//                    "contact_payment" => [
//                        "transaction_type_id" => "CUSTOMER_RECEIPT",
//                        "contact_id" => $this->contact->id,
//                        "bank_account_id" => "a3243d03081611e8b587065b8ec10ed1",
//                        "date" => Carbon::now()->toDateString(),
//                        "total_amount"  => 110,
//                    ]
//                ]
//                [
//                "contact_payment_id" => $contactPayment->id,
//                ]
//            ],
//            "total_paid"            => 133.10,
//            "outstanding_amount"    => 0,
//            "last_paid"             => "20/02/2018",
//            "payments_allocations_total_amount"=> 133.1,
//            "payments_allocations_total_discount"=> 0.0,
//            "base_currency_total_amount"=> 133.1,
//            "base_currency_outstanding_amount"=> 0.0,
//            ]
        ]))->create();

        $this->invoice->update(["payments_allocations" => [
                            "contact_payment_id" => $contactPayment->id,
        ]]);

        dd($this->api->log);
        $this->assertNotFalse($this->invoice->id);
        $this->assertEquals($this->contact->id, $this->invoice->contact_id);
        $this->assertEquals(Carbon::now()->toDateString(), $this->invoice->date);
        $this->assertCount(1, $this->invoice->invoice_lines);
        $this->assertEquals($invoices_count + 1, $invoiceResource->count());
    }

}
