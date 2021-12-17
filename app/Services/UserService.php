<?php

namespace App\Services;

use App\Exceptions\UserHasBeeTakenException;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserService
{

    public function update(User $user, array $input)
    {
        $checkEmailUser = User::where('email', $input['email'])->where('email', '!=', $user->email)->exists();

        if (!empty($input['email']) && $checkEmailUser) {
            throw new UserHasBeeTakenException();
        }

        if (!empty($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }

        if (!empty($input['avatar'])) {
            $avatar = $input['avatar'];

            if ($avatar->isValid()) {
                Storage::disk('public')->delete($user->avatar);

                $path = $avatar->store('images', 'public');

                $input['avatar'] = $path;
            }
        }

        $user->fill($input);
        $user->save();

        return $user->fresh();
    }
}
