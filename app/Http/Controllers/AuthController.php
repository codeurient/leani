<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Customer;
use App\Models\PhoneCode;
use App\Services\ResponseService;
use App\Services\SMSService;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function registerCheckSend(RegisterRequest $request)
    {
        $code = self::checkRepeatGenerateCode($request->phone);
        if(isset($code['errors'])) return $code['errors'];

        return self::codeSend($request->phone, trans('sms.register_code', ['attribute' => $code]), $code);
    }

    public function register(RegisterRequest $request)
    {
        if (!$request->code) {
            return ResponseService::error([
                'code' => [trans('validation.required', ['attribute' => 'code'])]
            ]);
        }

        $codeErrors = self::checkCodeErrors($request->phone, $request->code);
        if ($codeErrors) return $codeErrors;


        $customer = Customer::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'birthday' => $request->date,
            'phone' => $request->phone,
            'bonus' => 200,
        ]);


        $accessToken = $customer->createToken('authToken')->accessToken;
        return ResponseService::authSuccess($accessToken, $customer);
    }

    public function loginSend(LoginRequest $request)
    {
        $code = self::checkRepeatGenerateCode($request->phone);
        if(isset($code['errors'])) return $code['errors'];

        return self::codeSend($request->phone, trans('sms.login_code', ['attribute' => $code]), $code);
    }

    public function login(LoginRequest $request)
    {
        if (!$request->code) {
            return ResponseService::error([
                'code' => [trans('validation.required', ['attribute' => 'code'])]
            ]);
        }

        $codeErrors = self::checkCodeErrors($request->phone, $request->code);
        if ($codeErrors) return $codeErrors;

        $customer = Customer::where('phone', $request->phone)->first();

        $accessToken = $customer->createToken('authToken')->accessToken;
        return response()->json([
            'status' => 'success',
            'client' => $customer,
            'accessToken' => $accessToken,
        ]);
    }

    public function logout()
    {
        $token = \request()->user()->token();
        $token->revoke();
        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful!',
        ]);
    }

    private static function codeSend($phone, $message, $code)
    {
        if (app()->environment('production')) {
            $smsSend = (new SMSService())->sendSMS($phone, $message);

            if(!$smsSend) {
                return ResponseService::error([
                   'phone' => [trans('sms.sms_service_error')],
                ]);
            }

            return [
                'message' => trans('sms.code_send'),
                'seconds_to_repeat' => PhoneCode::CODE_REPEAT_SECONDS,
            ];
        }

        return [
            'message' => trans('sms.code_send'),
            'seconds_to_repeat' => PhoneCode::CODE_REPEAT_SECONDS,
            'code' => $code,
        ];
    }

    private static function checkCodeErrors($phone, $code)
    {
        $phoneCode = PhoneCode::where('phone', $phone)
            ->where('code', $code)
            ->first();

        if (!$phoneCode) {
            return ResponseService::error([
                'code' => [trans('sms.code_failed')],
            ]);
        }

        $phoneCode->delete();
        return false;
    }

    private static function checkRepeatGenerateCode($phone)
    {
        $repeatErrors = self::checkRepeatErrors($phone);
        if ($repeatErrors) return [
            'errors' => $repeatErrors,
        ];

        // create phone code
        $code = PhoneCode::generateCode();
        $phoneCode = new PhoneCode();
        $phoneCode->phone = $phone;
        $phoneCode->code = $code;
        $phoneCode->save();

        return $code;
    }

    /**
     * Check timer for repeat send and clear old entities if no errors
     * @param string $phone
     * @return false|\Illuminate\Http\Response
     */
    private static function checkRepeatErrors(string $phone)
    {
        $phoneCode = PhoneCode::where('phone', $phone)->first();
        if (!$phoneCode) return false;

        $now = Carbon::now();
        $repeatTime = $phoneCode->created_at->addSeconds(PhoneCode::CODE_REPEAT_SECONDS);

        if ($repeatTime->greaterThan($now)) {
            $secondsDifference = $repeatTime->diffInSeconds($now);

            return ResponseService::error([
                'code' => [trans('sms.code_repeat_unavailable', ['seconds' => $secondsDifference])],
            ]);
        }

        PhoneCode::where('phone', $phone)->delete();
        return false;
    }
}
