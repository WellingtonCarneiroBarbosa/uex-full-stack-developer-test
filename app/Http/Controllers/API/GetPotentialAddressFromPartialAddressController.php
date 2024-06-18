<?php

namespace App\Http\Controllers\API;

use App\Contracts\AddressProviderInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetPotentialAddressFromPartialAddressController extends Controller
{
    public function __construct(protected AddressProviderInterface $addressProvider)
    {
    }

    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'address' => ['required', 'min:5'],
        ]);

        $potentialAddresses = $this->addressProvider->getPotentialAddressesFromPartialAddress($data['address']);

        return response()->json($potentialAddresses);
    }
}
