<?php
    namespace SamirEltabal\AuthSystem\Traits;

    use Spatie\Permission\Traits\HasRoles;
    use Laravel\Passport\HasApiTokens;
    use Hash;
    use Str; 
    use Spatie\MediaLibrary\HasMedia;
    use Illuminate\Notifications\Notifiable;
    use Spatie\MediaLibrary\InteractsWithMedia;
    use SamirEltabal\AuthSystem\Notifications\PasswordResetRequested;

    trait AuthenticableTrait {
        use HasApiTokens, Notifiable, HasRoles, InteractsWithMedia;
        public $guard_name = 'api';
        // protected $hidden = [
        //     'roles',
        //     'uuid',
        //     'media'
        // ];

        // protected $casts = [
        //     'email_verified_at' => 'datetime',
        // ];
    
        // protected $appends = [
        //     'role',
        //     'avatar'
        // ];

        public function __construct(array $attributes = []) {
            $this->fillable[] = 'uuid';
            $this->fillable[] = 'phone';
            $this->with[] = 'social';
            $this->appends[] = 'Avatar';
            $this->appends[] = 'Role';
            parent::__construct($attributes);
        }

        public static function initializeAuthenticableTrait () : void {
            static::retrieved(function($model) {
                $model->fillable = array_merge($model->fillable, ['uuid', 'phone']);
            });
        }
        public static function boot()
        {
            parent::boot();
            self::creating(function ($model) {
                $model->uuid = (string) Str::uuid();
            });
            // $this->hidden[] = 'roles';
            // $this->hidden[] = 'uuid';
            // $this->hidden[] = 'media';
            // $this->casts[] = ['email_verified_at' => 'datetime'];
            // $this->appends[] = 'role';
            // $this->appends[] = 'avatar';

        }

        public function registerMediaCollections(): void
        {
            $this->addMediaCollection('avatars')
            ->singleFile()
            ->useFallbackUrl('/default-profile.jpg')
            ->useFallbackPath(public_path('/default-profile.jpg'));
        }

        public function getAvatarAttribute() {
            return $this->getFirstMediaUrl('avatars');
        }

        public function sendPasswordResetNotification($token) {
            $this->notify(new PasswordResetRequested($token));
        }

        public function scopeEmail($query, $value) {
            return $query->where('email', $value);
        }
        public function setPasswordAttribute($value){
            $this->attributes['password'] = Hash::make($value);
        }

        public function otp() {
            return $this->hasOne('SamirEltabal\AuthSystem\Models\Otp','user_id');
        } 

        public function getRoleAttribute() {
            if (!$this->roles->count()) {
                return 'n/a';
            }
            return $this->roles[0] ? $this->roles[0]->name : 'n/a';
        }

        public function social()
        {
            return $this->hasMany('SamirEltabal\AuthSystem\Models\SocialLink', 'user_id', 'id');
        }

        public function hasSocialLinked($service)
        {
            return (bool) $this->social->where('service', $service)->count();
        }
    }