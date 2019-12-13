<?php namespace App\Repositories;

interface RepositoryInterface
{
    public function all();

    public function create(array $data);

    public function createasdefault(array $data);

    public function update(array $data, $shippingAddressId);

    public function delete($shippingAddressId);

    public function get($shippingAddressId);
}
