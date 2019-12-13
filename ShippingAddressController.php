<?php

namespace App\Http\Controllers;

use App\Task;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use ShowSuite\Http\Common\Constants;

class ShippingAddressController extends Controller
{
    // space that we can use the repository from
    protected $shippingAddressModel;

    public function __construct(ShippingAddress $shippingAddress)
    {
        // set the model
        $this->shippingaddressmodel = new Repository($shippingAddress);
    }

    public function index()
    {
        return $this->shippingaddressmodel->all();
    }

    public function store(Request $ShippingAddressParams)
    {
        $shippingAddress = null;
        // validate the input parameters
        $this->validate($ShippingAddressParams, [
            'user_id' => 'required|max:50|integer',
            'country' => 'required|max:500|integer',
            'city' => 'required|max:500|integer',
            'zip_code' => 'required|max:500|integer',
            'street' => 'required|max:500|string',
        ]);

        // get user details
        $user_id = $ShippingAddressParams['user_id'];

        //get users shipping address
        $allShippingAdress = $this->shippingaddressmodel->get($user_id);

        //check if shipping address is less than 3 and has atleast one address
        $shippingAddress = $this->checkDefaultShippingAddress($allShippingAdress, $ShippingAddressParams);

        return SSResponse::getJsonResponse(true, $shippingAddress);
    }

    public function show($shippingAddressId)
    {
        return $this->shippingaddressmodel->show($shippingAddressId);
    }

    public function update(Request $ShippingAddressParams)
    {
        $shippingAddress = null;
        // validate the input parameters
        $this->validate($ShippingAddressParams, [
            'user_id' => 'required|max:50|integer',
            'country' => 'required|max:500|integer',
            'city' => 'required|max:500|integer',
            'zip_code' => 'required|max:500|integer',
            'street' => 'required|max:500|string',
            'shipping_address_id' => 'required|max:500|integer',
            'default_address' => 'max:1|integer',
        ]);

        // get user details
        $user_id = $ShippingAddressParams['user_id'];

        //get users shipping address
        $allShippingAdress = $this->shippingaddressmodel->get($user_id);

        //check if shipping address is less than 3 and has atleast one address
        $shippingAddress = $this->changeDefaultShippingAddress($allShippingAdress, $ShippingAddressParams);

        return SSResponse::getJsonResponse(true, $shippingAddress);
    }

    public function destroy($ShippingAddressParams)
    {
        $shippingAddress = null;
        // validate the input parameters
        $this->validate($ShippingAddressParams, [
            'user_id' => 'required|max:50|integer',
            'shipping_address_id' => 'required|max:500|integer',
        ]);

        // get user details
        $user_id = $ShippingAddressParams['user_id'];

        //get users shipping address
        $allShippingAdress = $this->shippingaddressmodel->get($user_id);

        if(sizeof($allShippingAdress) > Constants::SHIPPING_ADDRESS_MIN)
        {
            return $this->shippingaddressmodel->delete($ShippingAddressParams['shipping_address_id']);
        }
    }

    public function checkDefaultShippingAddress($allShippingAdress, $ShippingAddressParams)
    {
            //business logic to check available shipping address

            if(empty($allShippingAdress)) return;
            $shippingAddress = null;
            if(sizeof($allShippingAdress) < Constants::SHIPPING_ADDRESS_MAX && sizeof($allShippingAdress) > Constants::SHIPPING_ADDRESS_MIN)
            {
                // create record and pass in params
                $shippingAddress = $this->shippingaddressmodel->create($ShippingAddressParams);
            }

            if(sizeof($allShippingAdress) == 0)
            {
                $ShippingAddressParams['default_address'] = Constants::SET_DEFAULT_ADDRESS;
                // create record and pass in params and make default
                $shippingAddress = $this->shippingaddressmodel->createasdefault($ShippingAddressParams);
            }
            return $shippingAddress;
    }

    public function changeDefaultShippingAddress($allShippingAdress, $ShippingAddressParams)
    {
            //business logic to change available shipping address
            $shippingAddress = null;
            if(empty($ShippingAddressParams))
            return;

            $shippingAddress = $this->shippingaddressmodel->get($ShippingAddressParams['shipping_address_id']);
            //check if has more than one shipping address
            if(sizeof($allShippingAdress) != Constants::SHIPPING_ADDRESS_MIN && sizeof($allShippingAdress) > Constants::SHIPPING_ADDRESS_MIN)
            {
                //pass in params and update record
                $shippingAddress = $this->shippingaddressmodel->update($ShippingAddressParams);
            }

            return $shippingAddress;
    }
}
