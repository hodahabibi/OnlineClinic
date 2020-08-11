<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Provider;

class PatientController extends Controller
{
    /**
     * @return array
     */
    public function getProviders(): array{
        $providersList = [];
        $providers = Provider::all();
        foreach ($providers as $provider) {
            $providersList[] = [
                'id' => $provider['id'],
                'ProviderName' => $provider['full_name']
            ];
        }

        return [
            'error' => false,
            'providerList' => $providersList
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getProvidersAvailabilities(Request $request): array{
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'error' => true,
                'message' => $validator->errors()->all()
            ];
        }

        $fullName = $request->input('name');
        $providerAvailabilities = Provider::query()
            ->join('availabilities', function ($join) {
            $join->on('providers.id', '=', 'availabilities.provider_id');
        })
            ->select('full_name as name,', 'availabilities.start_datetime', 'availabilities.end_datetime')
            ->where('full_name', 'like', '%' . $fullName . '%')
            ->where('availabilities.status', '=', '0' )
            ->get();

        return [
            'error' => false,
            'providerList' => $providerAvailabilities
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function postAppointment(Request $request): array{
        $validator = Validator::make($request->all(), [
            'providerId'    => 'required',
            'patientId'     => 'required',
            'startDateTime' => 'required',
            'endDateTime'   => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'error'   => true,
                'message' => $validator->errors()->all()
            ];
        }

        $availability = $this->checkAppointmentValidity($request->input('providerId'), $request->input('startDateTime'));
        if ($availability['exists']) {
            return [
                'error'   => true,
                'message' => 'This appointment has been already booked!'
            ];

        } else {
            $appointment = new Appointment;
            $appointment->provider_id = $request->input('providerId');
            $appointment->patient_id = $request->input('patientId');
            $appointment->start_datetime = $request->input('startDateTime');
            $appointment->end_datetime = $request->input('endDateTime');
            $appointment->save();
        }
        return [
            'error'=> false,
            'appointment' => $appointment
        ];
    }

    /**
     * @param $providerId
     * @param $startDateTime
     * @return array
     */
    private function checkAppointmentValidity($providerId, $startDateTime): array{

        $appointment = Appointment::query()
            ->where('provider_id', '=', $providerId)
            ->where('start_datetime', '=', $startDateTime)
            ->exists();

        return [
            'error'=>false,
            'exists'=>$appointment
        ];
    }
}
