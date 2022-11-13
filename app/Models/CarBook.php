<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CarBook.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CarBook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarBook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarBook query()
 *
 * @mixin \Eloquent
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property int                             $car_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CarBook whereCarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarBook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarBook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarBook whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarBook whereUserId($value)
 */
class CarBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
    ];
}
