<?php

namespace App\Http\Controllers\API;

use App\Contracts\CepProviderInterface;
use App\Exceptions\CepProviderUnavailable;
use App\Http\Controllers\Controller;
use Validator;

class GetCepAddressController extends Controller
{
    public function __construct(protected CepProviderInterface $cepProvider)
    {
    }

    public function __invoke(string $cep)
    {
        $cep = (Validator::make(
            [
                'cep' => extractDigitsRegex($cep),
            ],
            [
                'cep' => ['required', 'size:8'],
            ],
        ))->validate()['cep'];

        try {
            $cepData = $this->cepProvider->getAddressByCep(
                $cep
            );

            return response()->json($cepData);
        } catch (CepProviderUnavailable) {
            return response()->json([
                'message' => 'Cep providers unavailable',
            ], 503);
        }
    }
}
