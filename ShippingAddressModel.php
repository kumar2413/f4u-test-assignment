<?php

namespace ShowSuite\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use ShowSuite\Models\Fields\ShippingAddressFields;

/**
 * ShowSuite\Models\Eloquent\ShippingAddress
 *
 * @property int $country
 * @property int $city
 * @property int|null $zipcode
 * @property int|null $street
 * @property int $shipping_address_id
 * @mixin \Eloquent
 */
class ShippingAddress extends BaseModel
{
    protected $table = ShippingAddress::TABLE_NAME;
    public $timestamps = true;

    use DynamicFieldsTrait;

    public function user()
    {
        return $this->belongsTo('ShowSuite\Models\Eloquent\User');
    }
}
