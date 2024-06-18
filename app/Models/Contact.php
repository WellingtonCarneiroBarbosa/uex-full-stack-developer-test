<?php

namespace App\Models;

use App\Models\Casts\Capitalize;
use App\Models\Casts\Digits;
use App\Models\Casts\Lower;
use App\Models\Scopes\UserScope;
use App\Utils\BrazilianStates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property mixed $name
 * @property mixed $email
 * @property mixed $cpf
 * @property mixed $phone
 * @property float $latitude
 * @property float $longitude
 * @property mixed $address_cep
 * @property mixed $address_uf
 * @property mixed $address_city
 * @property mixed $address_neighborhood
 * @property mixed $address_street
 * @property mixed $address_number
 * @property string|null $address_complement
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string|null $address_state_name
 * @property-read mixed $full_address
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ContactFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAddressCep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAddressCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAddressComplement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAddressNeighborhood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAddressNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAddressStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAddressUf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCpf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUserId($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    use HasFactory;

    protected $casts = [
        'name'                 => Capitalize::class,
        'email'                => Lower::class,
        'phone'                => Digits::class,
        'cpf'                  => Digits::class,
        'address_cep'          => Digits::class,
        'address_uf'           => Lower::class,
        'address_city'         => Capitalize::class,
        'address_neighborhood' => Capitalize::class,
        'address_street'       => Capitalize::class,
        'address_number'       => Digits::class,
        'latitude'             => 'float',
        'longitude'            => 'float',
    ];

    protected $appends = [
        'address_state_name',
        'full_address',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserScope());
    }

    public function getAddressStateNameAttribute(): ?string
    {
        return (new BrazilianStates())->getStateName($this->address_uf);
    }

    public function getFullAddressAttribute()
    {
        $cep = format($this->address_cep, '#####-###');

        $address = "{$this->address_street}, {$this->address_number}, ";

        if ($this->address_complement) {
            $address .= "$this->address_complement, ";
        }

        $address .= "{$this->address_neighborhood}, {$this->address_city}, {$this->getAddressStateNameAttribute()} - {$cep}";

        return trim($address, ', ');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
