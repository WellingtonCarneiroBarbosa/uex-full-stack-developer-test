<?php

namespace App\Http\Controllers\API;

use App\Contracts\CoordinatesProviderInterface;
use App\Http\Controllers\Controller;

class GetCoordinatesFromAddressController extends Controller
{
    public function __construct(
        protected CoordinatesProviderInterface $coordinatesProvider
    ) {
    }

    public function __invoke(string $address)
    {
        try {
            $data = $this->coordinatesProvider->getCoordinatesFromAddress($address);

            return response()->json($data->__toArray());
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 503);
        }
    }
}
