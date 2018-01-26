<?php

namespace Tests\Unit;

use RevoSystems\SageOne\SObjects\Contact;

class SageOneContactsTest extends SageOneBaseTest
{
    ///** @test */
    public function can_delete_all_sage_contacts()
    {
        (new Contact($this->api))->all()->first();
        (new Contact($this->api))->all()->each(function ($contact) {
            $contact->destroy();
        });
        $this->object = null;
    }

    /** @test */
    public function can_create_sage_contact()
    {
        $contactResource = (new Contact($this->api));
        $contacts_count  = $contactResource->count();

        $this->object = (new Contact($this->api, [
            "name"             => "Jordi",
            "reference"        => str_random(10),
            "contact_type_ids" => ["Customer"],
//            "main_address"      => [
//                "address_type" =>[
//                    "id" => "DELIVERY",
//                    "displayed_as" => "Delivery",
//                    "\$path" => "/address_types/DELIVERY",
//                ],
//                "name" => "Main Address",
//                "address_line_1"=> null,
//                "address_line_2"=> null,
//                "city"=> null,
//                "region"=> null,
//                "postal_code"=> null,
//                "country" => [
//                    "id"  => "GB",
//                    "displayed_as"  => "United Kingdom (GB)",
//                    "\$path"  => "/countries/GB",
//                ],
//                "country_group" => [
//                    "id"  => "ALL",
//                    "displayed_as"  => "Other",
//                    "\$path"  => "/country_groups/ALL",
//                ],
//                "is_main_address"   => true,
//                "created_at"        => "2018-01-26T08:50:03Z",
//                "updated_at"        => "2018-01-26T08:50:03Z",
//            ], "delivery_address" => [],
        ]))->create();

        $this->assertNotFalse($this->object->id);
        $this->assertEquals($contacts_count + 1, $contactResource->count());
        // dd($this->api->log);
    }

    /** @test */
    public function can_update_sage_contact()
    {
        $contactResource = (new Contact($this->api));
        $this->object    = (new Contact($this->api, [
            "name" => "Jordi",
            "contact_type_ids" => ["Customer"],
        ]))->create();
        $contacts_count  = $contactResource->count();

        $this->object->update([
            "name" => "Joan",
        ]);

        $this->assertNotFalse($this->object->id);
        $this->assertEquals("Joan", $this->object->name);
        $contact = (new Contact($this->api))->find($this->object->id);
        $this->assertEquals("Joan", $contact->name);
        $this->assertEquals($contacts_count, $contactResource->count());
    }

    /** @test */
    public function can_get_sage_contacts()
    {
        $this->object = (new Contact($this->api, [
            "name" => "Jordi",
            "contact_type_ids" => ["Customer"],
        ]))->create();

        $this->assertGreaterThanOrEqual(1, (new Contact($this->api))->count());
    }

    /** @test */
    public function can_see_a_sage_contact()
    {
        $this->object = (new Contact($this->api, [
            "name" => "Jordi",
            "contact_type_ids" => ["Customer"],
        ]))->create();

        $contact = (new Contact($this->api))->find($this->object->id);

        $this->assertEquals($this->object->id, $contact->id);
        $this->assertEquals('Jordi', $contact->name);
    }

    /** @test */
    public function can_delete_sage_contact()
    {
        $this->object = (new Contact($this->api, [
            "name" => "Jordi",
            "contact_type_ids" => ["Customer"],
        ]))->create();
        $contacts_count = (new Contact($this->api))->count();

        $this->object->destroy();
        $actual_contacts_count =  (new Contact($this->api))->count();

        $this->assertEquals($contacts_count - 1, $actual_contacts_count);
        $this->object = null;
    }
}
