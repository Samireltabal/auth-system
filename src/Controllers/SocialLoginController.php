<?php 
    namespace SamirEltabal\AuthSystem\Controllers;
    
    use App\Http\Controllers\Controller;
    use Laravel\Socialite\Facades\Socialite;
    use Illuminate\Http\Request;
    use SamirEltabal\AuthSystem\Middlewares\SocialLoginMiddleware;
    use SamirEltabal\AuthSystem\Models\SocialLink;
    use App\Models\User; 
    use Str;

    class SocialLoginController extends Controller {

        public function __construct () {
            $this->middleware([SocialLoginMiddleware::class]);
        }
        public function redirect($service)
        {
            return Socialite::driver($service)->stateless()->redirect();
        }

        public function callback($service) {
            try {
                $serviceUser = Socialite::driver($service)->stateless()->user();
            } catch (\Exception $e) {
                return redirect(env('CLIENT_BASE_URL') . 'auth/social-callback?error=Unable to login using ' . $service . '. Please try again' . '&origin=login');
            }
        //  return json_encode($serviceUser);
        // if ((env('RETRIEVE_UNVERIFIED_SOCIAL_EMAIL') == 0) && ($service != 'google')) {
        //     $email = $serviceUser->getId() . '@' . $service . '.local';
        // } else {
            
        // }
        $email = $serviceUser->getEmail();
        $user = $this->getExistingUser($serviceUser, $email, $service);
        $serviceUser = collect($serviceUser);
        $newUser = false;
        if (!$user) {
            $newUser = true;
            $user = User::create([
                'name' => $serviceUser['name'],
                'email' => $email,
                'phone' => $serviceUser['id'] ,
                'password' => '',
                'uuid' => Str::uuid()
            ]);
            $user->syncRoles(['user']);
            $user->addMediaFromUrl($serviceUser['avatar'])->toMediaCollection('avatars');
            $user->markEmailAsVerified();
        }

        if ($this->needsToCreateSocial($user, $service)) {
            SocialLink::create([
                'user_id' => $user->id,
                'service_id' => $serviceUser['id'],
                'service' => $service
            ]);
        }
        $token = $user->createToken('MyApp')->accessToken;
        return redirect(env('CLIENT_BASE_URL') . '/auth/social-callback?token=' . $token . '&origin=' . ($newUser ? 'register' : 'login'));
    }

    public function needsToCreateSocial(User $user, $service)
    {
        return !$user->hasSocialLinked($service);
    }

    public function getExistingUser($serviceUser, $email, $service)
    {
        if ((env('RETRIEVE_UNVERIFIED_SOCIAL_EMAIL') == 0) && ($service != 'google')) {
            $userSocial = SocialLink::where('service_id', $serviceUser->getId())->first();
            return $userSocial ? $userSocial->user : null;
        }
        return User::where('email', $email)->orWhereHas('social', function($q) use ($serviceUser, $service) {
            $q->where('service_id', $serviceUser->getId())->where('service', $service);
        })->first();
    }
}