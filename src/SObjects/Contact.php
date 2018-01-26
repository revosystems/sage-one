<?php

namespace RevoSystems\SageOne\SObjects;

use RevoSystems\SageOne\Validators\Validator;
use RevoSystems\SageOne\SObject;

class Contact extends SObject
{
    const RESOURCE_NAME = "contacts";

    protected $tag      = ["UID" => 'contact'];

    protected $fields   = [
        "legacy_id"                         => ["required" => false, "type" => "(int32)"            ],
        "id"                                => ["required" => false, "type" => "string()"           ],
        "displayed_as"                      => ["required" => false, "type" => "string()"           ],
        "\$path"                            => ["required" => false, "type" => "string()"           ],
        "transaction"                       => ["required" => false, "type" => "object"             ],
        "transaction_type"                  => ["required" => false, "type" => "object"             ],
        "created_at"                        => ["required" => false, "type" => "string(date-time)"  ],
        "updated_at"                        => ["required" => false, "type" => "string(date-time)"  ],
        "deleted_at"                        => ["required" => false, "type" => "string(date-time)"  ],
        "links"                             => ["required" => false, "type" => "array"              ],
        "contact_type_ids"                  => ["required" => true, "type" => "array"              ],
        "name"                              => ["required" => true, "type" => "string()"            ],
        "reference"                         => ["required" => false, "type" => "string()"           ],
        "default_sales_ledger_account"      => ["required" => false, "type" => "object"             ],
        "default_sales_tax_rate"            => ["required" => false, "type" => "object"             ],
        "default_purchase_ledger_account"   => ["required" => false, "type" => "object"             ],
        "tax_number"                        => ["required" => false, "type" => "string()"           ],
        "notes"                             => ["required" => false, "type" => "string()"           ],
        "locale"                            => ["required" => false, "type" => "string()"           ],
        "main_address"                      => ["required" => false, "type" => "object"             ],
        "delivery_address"                  => ["required" => false, "type" => "object"             ],
        "main_contact_person"               => ["required" => false, "type" => "object"             ],
        "bank_account_details"              => ["required" => false, "type" => "object"             ],
        "credit_limit"                      => ["required" => false, "type" => "number(double)"     ],
        "credit_days"                       => ["required" => false, "type" => "interger(int32)"    ],
        "credit_terms_and_conditions"       => ["required" => false, "type" => "string()"           ],
        "product_sales_price_type"          => ["required" => false, "type" => "object"             ],
        "source_guid"                       => ["required" => false, "type" => "string()"           ],
        "currency"                          => ["required" => false, "type" => "object"             ],
        "aux_reference"                     => ["required" => false, "type" => "string()"           ],
        "registered_number"                 => ["required" => false, "type" => "string()"           ],
        "deletable"                         => ["required" => false, "type" => "boolean()"          ],
        "tax_treatment"                     => ["required" => false, "type" => "object"             ],
    ];
}
