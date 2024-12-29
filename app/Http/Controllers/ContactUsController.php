<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
class ContactUsController extends Controller
{
    public function index()
    {
        return view("user.contact-us");
    }

    public function submit(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->route('contact')
                ->withErrors($validator)
                ->withInput();
        }

        // Prepare the data for the email
        $data = [
            'name'    => $request->input('name'),
            'email'   => $request->input('email'),
            'message' => $request->input('message'),
        ];

        // Store the message in the database
        ContactMessage::create($data);

        // Send the email to the site administrator
        try {
            Mail::to(config('mail.contact_address'))->send(new ContactUsMail($data));
        } catch (\Exception $e) {
            Log::error('Contact Us email failed to send: ' . $e->getMessage());
            return redirect()->route('contact')->with('error', __('contactus.email_send_failure'));
        }

        // Redirect back with a success message and scroll to form
        return redirect()->to(route('contact') . '#contact-form-container')
            ->with('success', __('contactus.message_sent_successfully'));
    }
}
