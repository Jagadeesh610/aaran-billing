<?php

namespace Aaran\Entries\Database\Factories;

use Aaran\Common\Models\Common;
use Aaran\Entries\Models\Sale;
use Aaran\Master\Models\Company;
use Aaran\Master\Models\Contact;
use Aaran\Master\Models\ContactDetail;
use Aaran\Master\Models\Order;
use Aaran\Master\Models\Style;
use Illuminate\Database\Eloquent\Factories\Factory;


class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        $contact = Contact::pluck('id')->random();
        $company = Company::pluck('id')->random();
        $order = Order::pluck('id')->random();
        $billing = ContactDetail::where('contact_id','=', $contact)->pluck('id')->random();
        $shipping = ContactDetail::where('contact_id','=', $contact)->pluck('id')->random();
        $style = Style::pluck('id')->random();
        $despatch = Common::where('label_id', '=', '1')->pluck('id')->random();
        $transport = Common::where('label_id', '=', '1')->pluck('id')->random();

        return [
            'uniqueno' => $this->faker->unique()->numberBetween(1, 9999),
            'acyear' => '2024_25',
            'company_id' => $company,
            'contact_id' => $contact,
            'invoice_no' => $this->faker->unique()->numberBetween(1, 9999),
            'invoice_date' => $this->faker->dateTimeThisMonth()->format('Y-m-d'),
            'sales_type' => 'CGST-SGST',
            'order_id' => $order,
            'billing_id' => $billing,
            'shipping_id' => $shipping,
            'style_id' => $style,
            'despatch_id' => $despatch,
            'transport_id' => $transport,
            'total_qty' => $this->faker->numberBetween(1, 9999),
            'total_taxable' => $this->faker->numberBetween(1, 9999),
            'total_gst' => $this->faker->numberBetween(1, 9999),
            'grand_total' => $this->faker->numberBetween(1, 9999),
            'active_id' => 1,
        ];
    }
}
