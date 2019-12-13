<?php namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class ShippingAddressRepository implements ShippingAddressRepositoryInterface
{
    // model property on class instances
    protected $ShippingAddressModel;

    // Constructor to bind model to repo
    public function __construct(Model $ShippingAddressModel)
    {
        $this->shippingaddress = $ShippingAddressModel;
    }

    // Get all instances of model
    public function all()
    {
        return $this->shippingaddress->all();
    }

    // create a new record in the database
    public function create(array $data, $user_id)
    {
        return $this->shippingaddress->create($data);
    }

    // create a new record in the database
    public function createasdefault(array $data, $user_id)
    {
        return $this->shippingaddress->create($data);
    }

    // update record in the database
    public function update(array $data, $shippingAddressId)
    {
        $record = $this->shippingaddress->find($shippingAddressId);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($shippingAddressId)
    {
        return $this->shippingaddress->destroy($shippingAddressId);
    }

    // get record from the database
    public function get($shippingAddressId)
    {
        return $this->shippingaddress->get($shippingAddressId);
    }

}
