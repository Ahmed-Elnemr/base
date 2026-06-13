<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Models\User;
use App\Notifications\NewUserRegisteredNotification;
use App\Notifications\PasswordUpdatedNotification;
use App\Notifications\ProfileUpdatedNotification;
use App\Notifications\UserLoggedInNotification;
use App\Notifications\UserProfileUpdatedNotification;
use App\Notifications\WelcomeNotification;
use App\Trait\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    use ResponseTrait;

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $clientType = $data['client_type'];
        $profileImagePath = null;

        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('users', 'public');
        }

        $termsAccepted = filter_var($data['terms_accepted'] ?? false, FILTER_VALIDATE_BOOLEAN);

        $user = User::create([
            'name' => $clientType === User::CLIENT_TYPE_COMPANY ? $data['company_name'] : $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'client_type' => $clientType,
            'phone' => $data['phone'],
            'city' => $data['city'],
            'company_name' => $clientType === User::CLIENT_TYPE_COMPANY ? $data['company_name'] : null,
            'company_bio' => $clientType === User::CLIENT_TYPE_COMPANY ? $data['company_bio'] : null,
            'commercial_register' => $clientType === User::CLIENT_TYPE_COMPANY ? $data['commercial_register'] : null,
            'profile_image_path' => $profileImagePath,
            'terms_accepted_at' => $termsAccepted ? now() : null,
        ]);

        $token = $user->createToken('api')->plainTextToken;

        // إرسال إشعار للإدارة بتسجيل مستخدم جديد
        $admins = User::where('client_type', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewUserRegisteredNotification($user));
        }

        // إرسال إشعار ترحيبي للمستخدم
        $user->notify(new WelcomeNotification);

        return self::successResponse(__('auth.register.success'), [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return self::failResponse(401, __('auth.failed'));
        }

        $token = $user->createToken('api')->plainTextToken;

        // إرسال إشعار للإدارة بتسجيل دخول المستخدم
        $admins = User::where('client_type', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new UserLoggedInNotification($user));
        }

        return self::successResponse(__('auth.login.success'), [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return self::successResponse(__('auth.logout.success'));
    }

    public function me(Request $request): JsonResponse
    {
        return self::successResponse(__('auth.me.success'), [
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {

        $user = $request->user();
        $data = $request->validated();

        // Track updated fields
        $updatedFields = [];

        // Update basic information
        if (isset($data['name']) && $user->name !== $data['name']) {
            $user->name = $data['name'];
            $updatedFields[] = 'name';
        }

        if (isset($data['email']) && $user->email !== $data['email']) {
            $user->email = $data['email'];
            $updatedFields[] = 'email';
        }

        if (isset($data['phone']) && $user->phone !== $data['phone']) {
            $user->phone = $data['phone'];
            $updatedFields[] = 'phone';
        }

        if (isset($data['city']) && $user->city !== $data['city']) {
            $user->city = $data['city'];
            $updatedFields[] = 'city';
        }

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image_path) {
                Storage::disk('public')->delete($user->profile_image_path);
            }

            // Store new profile image
            $profileImagePath = $request->file('profile_image')->store('users', 'public');
            $user->profile_image_path = $profileImagePath;
            $updatedFields[] = 'profile_image';
        }

        // Update password if provided
        if (isset($data['current_password']) && isset($data['password'])) {
            if (! Hash::check($data['current_password'], $user->password)) {
                return self::failResponse(422, __('auth.password.current_password_incorrect'));
            }

            $user->password = Hash::make($data['password']);
            $updatedFields[] = 'password';
        }

        // Update company specific fields if user is a company
        if ($user->client_type === User::CLIENT_TYPE_COMPANY) {
            if (isset($data['company_name']) && $user->company_name !== $data['company_name']) {
                $user->company_name = $data['company_name'];
                // Also update name field if it's a company
                $user->name = $data['company_name'];
                $updatedFields[] = 'company_name';
            }

            if (isset($data['company_bio']) && $user->company_bio !== $data['company_bio']) {
                $user->company_bio = $data['company_bio'];
                $updatedFields[] = 'company_bio';
            }

            if (isset($data['commercial_register']) && $user->commercial_register !== $data['commercial_register']) {
                $user->commercial_register = $data['commercial_register'];
                $updatedFields[] = 'commercial_register';
            }
        }

        // Handle terms acceptance
        if (isset($data['terms_accepted'])) {
            $termsAccepted = filter_var($data['terms_accepted'], FILTER_VALIDATE_BOOLEAN);
            if ($termsAccepted && ! $user->terms_accepted_at) {
                $user->terms_accepted_at = now();
            }
        }

        $user->save();

        $user->refresh();

        // إرسال إشعار للمستخدم نفسه بتحديث ملفه الشخصي
        if (! empty($updatedFields)) {
            $user->notify(new UserProfileUpdatedNotification($updatedFields));

            // إذا تم تغيير كلمة المرور، أرسل إشعار أمان إضافي
            if (in_array('password', $updatedFields)) {
                $user->notify(new PasswordUpdatedNotification);
            }
        }

        // إرسال إشعار للإدارة بتحديث الملف الشخصي
        $admins = User::where('client_type', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new ProfileUpdatedNotification($user));
        }

        return self::successResponse(__('profile updated'), [
            'user' => $user,
        ]);
    }
}
