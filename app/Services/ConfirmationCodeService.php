<?php

namespace App\Services;

use App\Models\ConfirmationCode;
use Illuminate\Http\Resources\Json\JsonResource;

class ConfirmationCodeService
{
    /**
     * @param string $phoneNumber
     * @return void
     */
    public function deleteCode(string $phoneNumber): void
    {
        $phoneNumber = str_replace('+', '', $phoneNumber);
        ConfirmationCode::where('phone_number', $phoneNumber)->delete();
    }

    /**
     * @return void
     */
    public function deleteExpiredCodes(): void
    {
        ConfirmationCode::isExpired()->delete();
    }

    /**
     * @param string      $phoneNumber
     * @param string|null $code
     * @param bool        $isExpired
     * @return ConfirmationCode|null
     */
    public function findCode(string $phoneNumber, string $code = null, bool $isExpired = false): ?ConfirmationCode
    {
        $query = ConfirmationCode::where('phone_number', $phoneNumber)->isExpired($isExpired);

        if (!is_null($code)) {
            $query->where('code', $code);
        }

        return $query->first();
    }

    /**
     * @param string   $phoneNumber
     * @param int|null $expiresIn
     * @return void
     */
    public function send(string $phoneNumber, int|null $expiresIn = null): void
    {
        $phoneNumber = str_replace('+', '', $phoneNumber);
        $code = str_pad(rand(0, pow(10, 6) - 1), 6, '0', STR_PAD_LEFT);

        $existingCode = $this->findCode($phoneNumber);
        if (!$existingCode) {
            ConfirmationCode::create([
                'phone_number' => $phoneNumber,
                'code' => $code,
                'expires_at' => !is_null($expiresIn) ? date('Y-m-d H:i:s', time() + $expiresIn) : null
            ]);

            (new SmsService())->sendMessage(
                $phoneNumber,
                __("Your verification code for :app is :code", [
                    'app' => '@tift_olympiad_bot',
                    'code' => $code
                ])
            );
        }
    }

    /**
     * @param string $phoneNumber
     * @param string $code
     * @return bool
     */
    public function verify(string $phoneNumber, string $code): bool
    {
        $phoneNumber = str_replace('+', '', $phoneNumber);
        $code = $this->findCode($phoneNumber, $code);

        return !is_null($code);
    }
}
