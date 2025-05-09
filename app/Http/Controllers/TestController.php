<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //

    public function try(){

        $result = Destination::orderByDesc(
            Flight::select('arrived_at')
                ->whereColumn('destination_id', 'destinations.id')
                ->orderByDesc('arrived_at')
                ->limit(1)
        )->get();
    
        $result = Destination::addSelect(['last_flight' => Flight::select('name')
            ->whereColumn('destination_id', 'destinations.id')
            ->orderByDesc('arrived_at')
            ->limit(1)
        ])->get();
       
        // Retrieve a model by its primary key...
        $result = Flight::find(1);
     
        // Retrieve the first model matching the query constraints...
        $result = Flight::where('active', 1)->first();
        
        // Alternative to retrieving the first model matching the query constraints...
        $result = Flight::firstWhere('active', 1);
    
        $flight = Flight::findOr(1, function () {
            // ...
        });
    
        $flight = Flight::where('legs', '>', 3)->firstOr(function () {
            // ...
        });
    
    
        $flight = Flight::findOrFail(1); // if fail  404 HTTP
     
        $flight = Flight::where('legs', '>', 3)->firstOrFail();

        // agregates 
        // https://laravel.com/docs/11.x/queries#aggregates

        $count = Flight::where('active', 1)->count();
 
        $max = Flight::where('active', 1)->max('price');

        //  updateOrCreate

        $flight = Flight::updateOrCreate(
            ['departure' => 'Oakland', 'destination' => 'San Diego'],
            ['price' => 99, 'discounted' => 1]
        );

        // mass update
        Flight::where('active', 1)
        ->where('destination', 'San Diego')
        ->update(['delayed' => 1]);

        Flight::upsert([
            ['departure' => 'Oakland', 'destination' => 'San Diego', 'price' => 99],
            ['departure' => 'Chicago', 'destination' => 'New York', 'price' => 150]
        ], uniqueBy: ['departure', 'destination'], update: ['price']);




        // DELTE

        // 1
        $flight = Flight::find(1);
 
        $flight->delete();


        // 2
        Flight::destroy(1);
 
        Flight::destroy(1, 2, 3);
        
        Flight::destroy([1, 2, 3]);
        
        Flight::destroy(collect([1, 2, 3]));


        Flight::forceDestroy(1);

        // MODEL file
        // in the model for the soft delete 

        // class Flight extends Model
        // {
        //     use SoftDeletes;
        // };

        // To determine if a given model instance has been soft deleted
        if ($flight->trashed()) {
            // ...
        }


        $flight->restore(); //restore the soft deleted model 


        // You may also use the restore method in a query to restore multiple models. 
        Flight::withTrashed()
        ->where('airline_id', 1)
        ->restore();

        //  permanently remove a soft deleted model 
        $flight->forceDelete();


        // Pruning Models
        // Sometimes you may want to periodically delete models that are no longer needed

        // MODEL file
        // class Flight extends Model
        // {
        //     use Prunable;
        //     public function prunable(): Builder
        //     {
        //         return static::where('created_at', '<=', now()->subMonth());
        //     }
        // }

        // This method can be useful for deleting any additional resources associated with the model, such as stored files, before the model is permanently removed from the database:
        // protected function pruning(): void
        // {
        //     // ...
        // }


        // Replicating Models

        $shipping = Address::create([
            'type' => 'shipping',
            'line_1' => '123 Example Street',
            'city' => 'Victorville',
            'state' => 'CA',
            'postcode' => '90001',
        ]);
         
        $billing = $shipping->replicate()->fill([
            'type' => 'billing'
        ]);
         
        $billing->save();



        // To exclude one or more attributes from being replicated to the new model
        $flight = Flight::create([
            'destination' => 'LAX',
            'origin' => 'LHR',
            'last_flown' => '2020-03-04 11:00:00',
            'last_pilot_id' => 747,
        ]);
         

        // these two cloumns wiill not be replicated
        $flight = $flight->replicate([
            'last_flown',
            'last_pilot_id'
        ]);
        


        // SCOPES

    
        // LOCAL
        // MODEL

         /**
         * Scope a query to only include popular users.
         */
        public function scopePopular(Builder $query): void
        {
            $query->where('votes', '>', 100);
        }
    
        /**
         * Scope a query to only include active users.
         */
        public function scopeActive(Builder $query): void
        {
            $query->where('active', 1);
        }


        $users = User::popular()->active()->orderBy('created_at')->get();
        $users = User::popular()->orWhere->active()->get();
        $users = User::popular()->orWhere(function (Builder $query) {
            $query->active();
        })->get();




        // EVENTS


        namespace App\Models;
 
        use App\Events\UserDeleted;
        use App\Events\UserSaved;
        use Illuminate\Foundation\Auth\User as Authenticatable;
        use Illuminate\Notifications\Notifiable;
         
        class User extends Authenticatable
        {
            use Notifiable;
         
            /**
             * The event map for the model.
             *
             * @var array<string, string>
             */
            protected $dispatchesEvents = [
                'saved' => UserSaved::class,
                'deleted' => UserDeleted::class,
            ];
        }

        // you may register closures that execute when various model events are dispatched
        protected static function booted(): void
        {
            static::created(function (User $user) {
                // ...
            });
        }


        // Muting Events

        use App\Models\User;
 
        $user = User::withoutEvents(function () {
            User::findOrFail(1)->delete();
        
            return User::find(2);
        });


        // Saving a Single Model Without Events

        $user = User::findOrFail(1);
 
        $user->name = 'Victoria Faith';
        
        $user->saveQuietly();

        $user->deleteQuietly();
        $user->forceDeleteQuietly();
        $user->restoreQuietly();




        // RELATIONSHIPS

        /**
         * Get the comments for the blog post.
         */

        // Has many
        public function comments(): HasMany
        {
            return $this->hasMany(Comment::class);
        }

        // belogns to 

        public function post(): BelongsTo
        {
            return $this->belongsTo(Post::class);
        }


        $posts = Post::whereBelongsTo($user, 'author')->get();

        // Has One of Many

        public function latestOrder(): HasOne
        {
            return $this->hasOne(Order::class)->latestOfMany();
        }

        public function oldestOrder(): HasOne
        {
            return $this->hasOne(Order::class)->oldestOfMany();
        }

        public function oldestOrder(): HasOne
        {
            return $this->hasOne(Order::class)->oldestOfMany();
        }




        /**
         * Get the user's orders.
         */
        public function orders(): HasMany
        {
            return $this->hasMany(Order::class);
        }
        
        /**
         * Get the user's largest order.
         */
        public function largestOrder(): HasOne
        {
            return $this->orders()->one()->ofMany('price', 'max');
        }


        
        
        // Has One Through
        
        class Mechanic extends Model
        {
            /**
             * Get the car's owner.
             */
            public function carOwner(): HasOneThrough
            {
                return $this->hasOneThrough(Owner::class, Car::class);
            }
        }


        // String based syntax...
        return $this->through('cars')->has('owner');
        
        // Dynamic syntax...
        return $this->throughCars()->hasOwner();



        // Has Many Through


        projects
            id - integer
            name - string
        
        environments
            id - integer
            project_id - integer
            name - string
        
        deployments
            id - integer
            environment_id - integer
            commit_hash - string



            class Project extends Model
            {
                /**
                 * Get all of the deployments for the project.
                 */
                public function deployments(): HasManyThrough
                {
                    return $this->hasManyThrough(Deployment::class, Environment::class);
                }
            }




        //  many to many relationship

        return $this->belongsToMany(Role::class)
        ->wherePivot('approved', 1);

        return $this->belongsToMany(Role::class)
            ->wherePivotIn('priority', [1, 2]);

        return $this->belongsToMany(Role::class)
            ->wherePivotNotIn('priority', [1, 2]);

        return $this->belongsToMany(Podcast::class)
            ->as('subscriptions')
            ->wherePivotBetween('created_at', ['2020-01-01 00:00:00', '2020-12-31 00:00:00']);

        return $this->belongsToMany(Podcast::class)
            ->as('subscriptions')
            ->wherePivotNotBetween('created_at', ['2020-01-01 00:00:00', '2020-12-31 00:00:00']);

        return $this->belongsToMany(Podcast::class)
            ->as('subscriptions')
            ->wherePivotNull('expired_at');

        return $this->belongsToMany(Podcast::class)
            ->as('subscriptions')
            ->wherePivotNotNull('expired_at');

        return $this->belongsToMany(Role::class)
            ->withPivotValue('approved', 1);

        return $this->belongsToMany(Badge::class)
            ->where('rank', 'gold')
            ->orderByPivot('created_at', 'desc');


        // querying relations

        use App\Models\Post;
        $posts = Post::whereRelation('comments', 'is_approved', false)->get();


        $posts = Post::whereRelation(
            'comments', 'created_at', '>=', now()->subHour()
        )->get();



        $posts = Post::doesntHave('comments')->get();

        $posts = Post::whereDoesntHave('comments', function (Builder $query) {
            $query->where('content', 'like', 'code%');
        })->get();


        $posts = Post::whereDoesntHave('comments.author', function (Builder $query) {
            $query->where('banned', 0);
        })->get();




        //Aggregating Related Models


        $posts = Post::withCount('comments')->get();


        $posts = Post::withCount(['votes', 'comments' => function (Builder $query) {
            $query->where('content', 'like', 'code%');
        }])->get();



        $book = Book::first();
        $book->loadCount('genres');



        //Eager Loading
        use App\Models\User;
 
        $users = User::withWhereHas('posts', function ($query) {
            $query->where('featured', true);
        })->get();


    }
}
