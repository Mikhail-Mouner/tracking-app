<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Baby
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $parent
 * @method static \Database\Factories\BabyFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Baby newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Baby newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Baby query()
 * @method static \Illuminate\Database\Eloquent\Builder|Baby whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Baby whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Baby whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Baby whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Baby whereUpdatedAt($value)
 */
	class Baby extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Partner
 *
 * @property int $id
 * @property int $parent_id
 * @property int $partner_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Baby[] $babies
 * @property-read int|null $babies_count
 * @property-read \App\Models\User $parent
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\PartnerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner wherePartnerId($value)
 */
	class Partner extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Baby[] $babies
 * @property-read int|null $babies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Partner[] $partners
 * @property-read int|null $partners_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Baby[] $partners_baby
 * @property-read int|null $partners_baby_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

