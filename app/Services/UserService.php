<?php
declare(strict_types = 1);
namespace App\Services;


    use App\Models\User;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;

class UserService
{

    public static function createUser(array $data): User
    {
//        dd($data["username"]);
        $rules = [
            'name' => 'bail|required',
            'password' => 'bail|required|min:5',
            'username' => 'bail|required|unique:users',
            'email' => 'bail|required'
        ];

        $messages = [
            'name.required' => __("Name is required"),
            'password.required' => __("Password is required"),
            'username.required' => __("Username is required"),
            'username.unique' => __("Username should be unique"),
            'email.required' => __('We need to know your email address!'),
        ];
        $validated = Validator::validate($data, $rules, $messages);

        return User::create($validated);
    }

    public static function generateToken(User $user): array
    {
        $token = $user->createToken('Authentication');
        $expiresIn = (int)config('sanctum.expiration');
        return [
            'token_type' => 'Bearer',
            'access_token' => $token->plainTextToken,
            'expires_in' => $expiresIn * 60
        ];
    }

    public static function login(array $data): User
    {
        $rules = [
            'password' => 'bail|required',
            'username' => 'bail|required',
        ];
        $messages = [
            'username.required' => __("Username is required"),
            'password.required' => __("Password is required"),
        ];

        $validated = Validator::validate($data, $rules, $messages);

        $user = User::where('username', $validated['username'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            abort(401, __("Wrong credentials"));
        }

        return $user;
    }

    public static function logout(User $user): void
    {
        $user?->tokens()?->where('name', 'Authentication')?->delete();
    }



}
