<?php

namespace Acacha\Relationships\Http\Controllers;

use Acacha\Relationships\Http\Requests\DestroyLoggedUserEmail;
use Acacha\Relationships\Http\Requests\ListLoggedUserEmails;
use Acacha\Relationships\Http\Requests\StoreLoggedUserEmail;
use Acacha\Relationships\Http\Requests\UpdateLoggedUserEmail;
use Acacha\Relationships\Models\Contactable;
use Acacha\Relationships\Models\Email;
use App\Http\Controllers\Controller;
use Auth;

/**
 * Class LoggedUserPersonEmailsController.
 *
 * @package Acacha\Relationships\Http\Controllers
 */
class LoggedUserPersonEmailsController extends Controller
{
    /**
     * Show emails.
     *
     * @return mixed
     */
    public function index(ListLoggedUserEmails $request)
    {
        $user = Auth::user();
        if ($user->person) return $user->person->emails;
        return [];
    }

    /**
     * Store email.
     *
     * @param StoreLoggedUserEmail $request
     * @return mixed
     */
    public function store(StoreLoggedUserEmail $request)
    {
        $user = Auth::user();
        if ($user->person) {
            $email= Email::firstOrCreate([
                'value' => $request->email
            ]);
            if (in_array($request->email,$user->person->emails()->pluck('value')->toArray())) abort(422,'Email already assigned to person!');

//            $user->person->emails()->attach($email);
            Contactable::create([
                'person_id' => $user->person->id,
                'contactable_id' => $email->id,
                'contactable_type' => Email::class
            ]);
            return $email->load('persons');
        }
        abort(422,'No personal data for current logged user');
    }

    /**
     * Update email.
     *
     * @param UpdateLoggedUserEmail $request
     * @param Email $mail
     * @return Email
     */
    public function update(UpdateLoggedUserEmail $request, Email $mail)
    {
        $user = Auth::user();
        if ($user->person) {
            if (in_array($request->email,$user->person->emails()->pluck('value')->toArray())) abort(422,'Email already assigned to person!');
            $mail->value = $request->email;
            $mail->save();
            return $mail->load('persons');
        }
        abort(422,'No personal data for current logged user');
    }

    /**
     * Destroy email.
     *
     * @param DestroyLoggedUserEmail $request
     * @param Email $mail
     * @return Email
     */
    public function destroy(DestroyLoggedUserEmail $request, Email $mail)
    {
        $user = Auth::user();
        if ($user->person) {
            $user->person->emails()->detach($mail->id);
            $mailAgain = Email::findOrFail($mail->id);
            if (count($mailAgain->persons) === 0) {
                $mail->delete();
            }
            return $mail->load('persons');
        }
        abort(422,'No personal data for current logged user');
    }
}