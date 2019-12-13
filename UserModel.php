<?php

namespace ShowSuite\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use ShowSuite\Models\Fields\UserFields;

/**
 * ShowSuite\Models\Eloquent\ShippingAddress
 *
 * @property int $id
 * @property int $firstname
 * @property int|null $lastname
 * @mixin \Eloquent
 */
class User extends BaseModel
{
    protected $table = USER::TABLE_NAME;
    public $timestamps = true;

    use DynamicFieldsTrait;

    public function shippingaddress()
    {
        return $this->hasmany('ShowSuite\Models\Eloquent\shippingaddress');
    }
}
