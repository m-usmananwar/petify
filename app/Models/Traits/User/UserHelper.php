<?php

namespace App\Models\Traits\User;

use App\Enum\VerificationEnum;
use App\Helpers\FileHandler;
use App\Models\Verification;

trait UserHelper
{

    public function isVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    public function resetPasswordVerification(): string
    {
        $verification = Verification::create([
            'user_id' => $this->id,
            'type' => VerificationEnum::PASSWORD,
            'unique_id' => uniqid(),
            'code' => mt_rand(1000, 9999),
        ]);

        return $verification->unique_id;
    }

    public function resetEmailVerification(): string
    {
        $verification = Verification::create([
            'user_id' => $this->id,
            'type' => VerificationEnum::EMAIL,
            'unique_id' => uniqid(),
            'code' => mt_rand(1000, 9999),
        ]);

        return $verification->unique_id;
    }

    public function getPasswordResetCode(): string
    {
        $verification = Verification::where(['user_id' => $this->id, 'type' => VerificationEnum::PASSWORD])->latest()->first();
        return $verification->code;
    }

    public function getVerificationCode(): string
    {
        $verification = Verification::where(['user_id' => $this->id, 'type' => VerificationEnum::EMAIL])->latest()->first();
        return $verification->code;
    }

    public function verifyEmail(string $code): bool|string
    {
        $latestVerification = Verification::where(['user_id' => $this->id, 'type' => VerificationEnum::EMAIL])->latest()->first();

        if($latestVerification !== null) {
            if(time() - strtotime($latestVerification->created_at) >= 60*24) return 'expired';
            if($latestVerification->failed_attempts >= 4) return 'failed_attempts';

            if($latestVerification->code === $code) {
                $this->email_verified_at = now();
                $this->save();
                return true;
            } else {
                $latestVerification->failed_attempts++;
                $latestVerification->save();
                
                if($latestVerification->failed_attempts >= 4) return 'failed_attempts';
            }
        }
        
        return false;
    }

    public function verifyPassword(string $code): bool|string
    {
        $latestVerification = Verification::where(['user_id' => $this->id, 'type' => VerificationEnum::PASSWORD])->latest()->first();

        if($latestVerification !== null) {
            if(time() - strtotime($latestVerification->created_at) >= 60*24) return 'expired';
            if($latestVerification->failed_attempts >= 4) return 'failed_attempts';

            if($latestVerification->code === $code) {
                return true;
            } else {
                $latestVerification->failed_attempts++;
                $latestVerification->save();
                
                if($latestVerification->failed_attempts >= 4) return 'failed_attempts';
            }
        }
        
        return false;
    }
}