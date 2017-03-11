<?php

namespace App\Http\Controllers;

use App\MerchantInvitation;
use Illuminate\Http\Request;

class InviteMerchantsController extends Controller
{
    public function index()
    {
        $this->authorize('do-vendor-thing');

        return view('vendor.invite-merchants.index', ['invalidEmails' => null]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'emails' => 'required',
        ]);

        $result = vendor()->addManyEmails($request->get('emails'));

        return view('vendor.invite-merchants.index', $this->prepareMessages($result));
    }

    /**
     * Ajax GET
     * Route name: getMerchantInvitations
     */
    public function getMerchantInvitations()
    {
        $data = vendor()->brand()->merchantInvitations();

        return response()->json($data, 200);
    }

    /**
     * Ajax PATCH
     * Route name: enqueueMerchantInvitation
     */
    public function enqueueMerchantInvitation($id)
    {
        MerchantInvitation::enqueueEmail($id);
        return response()->json([], 204);
    }

    /**
     * Ajax DELETE
     * Route name: deleteMerchantInvitation
     */
    public function deleteMerchantInvitation($id)
    {
        MerchantInvitation::destroy($id);
        return response()->json([], 204);
    }

    // PRIVATE
    
    private function prepareMessages($result)
    {
        $messages = [];

        if ($result->emails) {
            $messages['success'] = "You have successfully added " . pluralize('email', $result->count) . ".";
        }

        if ($result->invalidEmails) {
            $messages['danger'] = "Please check " . pluralize('invalid email', $result->invalidEmailCount) . ".";
        }

        return [
            'messages' => $messages, 
            'invalidEmails' => $result->invalidEmailsNlSeparated,
        ];
    }
}
