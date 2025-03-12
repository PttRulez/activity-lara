<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $calories
 * @property string|null $description
 * @property int $distance
 * @property string $date
 * @property int $elevate
 * @property int|null $heart_rate
 * @property string $name
 * @property int|null $pace
 * @property string|null $pace_string
 * @property string $source
 * @property int $source_id
 * @property string $sport_type
 * @property int $start_time_unix
 * @property int $total_time
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereElevate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereHeartRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity wherePace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity wherePaceString($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereSportType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereStartTimeUnix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereTotalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Activity whereUserId($value)
 */
	class Activity extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BaseModel query()
 */
	class BaseModel extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $carbs
 * @property int $calories
 * @property bool $created_by_admin
 * @property int $fat
 * @property string $name
 * @property int $protein
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereCarbs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereCreatedByAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereFat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereUserId($value)
 */
	class Food extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $calories
 * @property int $calories_per_100
 * @property int $meal_id
 * @property string $name
 * @property int $weight
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodInMeal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodInMeal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodInMeal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodInMeal whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodInMeal whereCaloriesPer100($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodInMeal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodInMeal whereMealId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodInMeal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodInMeal whereWeight($value)
 */
	class FoodInMeal extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $calories
 * @property string $date
 * @property string $name
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FoodInMeal> $foods
 * @property-read int|null $foods_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereUserId($value)
 */
	class Meal extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $date
 * @property int $steps
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Steps newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Steps newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Steps query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Steps whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Steps whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Steps whereSteps($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Steps whereUserId($value)
 */
	class Steps extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $access_token
 * @property string $refresh_token
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StravaInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StravaInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StravaInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StravaInfo whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StravaInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StravaInfo whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StravaInfo whereUserId($value)
 */
	class StravaInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property float $calories_per_100_steps
 * @property int $bmr
 * @property string $role
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Food> $foods
 * @property-read int|null $foods_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Meal> $meals
 * @property-read int|null $meals_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Steps> $steps
 * @property-read int|null $steps_count
 * @property-read \App\Models\StravaInfo|null $stravaInfo
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Weight> $weights
 * @property-read int|null $weights_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBmr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCaloriesPer100Steps($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $date
 * @property float $weight
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Weight whereWeight($value)
 */
	class Weight extends \Eloquent {}
}

