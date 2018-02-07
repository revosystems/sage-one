<?php

namespace RevoSystems\SageOne\SObjects;

use RevoSystems\SageOne\SObject;

class LedgerAccount extends SObject
{
    const RESOURCE_NAME = "ledger_accounts";

    protected $fields   = [
        "ledger_account_type_id"            => ["required" => true, "type" => "string()"        ],
        "included_in_chart"                 => ["required" => true, "type" => "boolean()"       ],
        "name"                              => ["required" => true, "type" => "string()"        ],
        "display_name"                      => ["required" => true, "type" => "string()"        ],
        "nominal_code"                      => ["required" => true, "type" => "integer(int32)"  ],
        "transaction_id"                    => ["required" => false, "type" => "string()"       ],
        "transaction_type_id"               => ["required" => false, "type" => "string()"       ],
        "ledger_account_classification_id"  => ["required" => false, "type" => "string()"       ],
        "tax_rate_id"                       => ["required" => false, "type" => "string()"       ],
        "fixed_tax_rate"                    => ["required" => false, "type" => "boolean()"      ],
        "visible_in_banking"                => ["required" => false, "type" => "boolean()"      ],
        "visible_in_expenses"               => ["required" => false, "type" => "boolean()"      ],
        "visible_in_journals"               => ["required" => false, "type" => "boolean()"      ],
        "visible_in_other_payments"         => ["required" => false, "type" => "boolean()"      ],
        "visible_in_other_receipts"         => ["required" => false, "type" => "boolean()"      ],
        "visible_in_reporting"              => ["required" => false, "type" => "boolean()"      ],
        "visible_in_sales"                  => ["required" => false, "type" => "boolean()"      ],
        "is_control_account"                => ["required" => false, "type" => "boolean()"      ],
        "control_name"                      => ["required" => false, "type" => "string()"       ],
        "Expandable"                        => ["required" => false, "type" => "sub entity fields from GET, POST and PUT requests"      ],
        "balance_details"                   => ["required" => false, "type" => "object"         ],
    ];
}
