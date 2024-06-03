<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest


{

    use App\Http\Requests\ProfileUpdateRequest;

public function register(ProfileUpdateRequest $request)
{
    $validated = $request->validated();
    
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    Auth::login($user);

    return redirect(RouteServiceProvider::HOME);
}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'password' => [
                'required',
                'string',
                'min:8', // Minimum 8 characters
                'regex:/[a-z]/', // Must contain at least one lowercase letter
                'regex:/[A-Z]/', // Must contain at least one uppercase letter
                'regex:/[0-9]/', // Must contain at least one digit
                'regex:/[@$!%*?&#]/', // Must contain a special character
                'confirmed', // Must match password_confirmation
            ],
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'password.regex' => 'The password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, one digit, and one special character.',
        ];
    }
}
