<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('feed.index');
        }

        return view('home.welcome');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function imprint()
    {
        return view('home.imprint');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function showContactForm()
    {
        return view('home.contact');
    }

    /**
     * Send the contact form via mail.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendContactForm(Request $request)
    {
        $validationRules = [
            'email' => ['required', 'max:191', 'email'],
            'name' => ['required', 'max:191'],
            'content' => 'required',
        ];
        $validatedData = $request->validate($validationRules);

        $email = $validatedData['email'];
        $name = $validatedData['name'];
        $content = $validatedData['content'];

        Mail::to(config('app.contact_mail_address'))->send(new ContactFormSubmitted($email, $name, $content));

        flash(__('home.contact.success'))->success();

        return redirect()->back();
    }
}
