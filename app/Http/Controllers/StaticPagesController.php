<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StaticPagesController extends Controller
{
    /**
     * Affiche la page de tarification.
     *
     * @return \Illuminate\View\View
     */
    public function pricing()
    {
        return view('pages.pricing');
    }

    /**
     * Affiche la page de contact.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Traite le formulaire de contact.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContact(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'privacy' => 'required|accepted',
        ]);

        // Ici, vous pourriez implémenter l'envoi d'e-mail ou l'enregistrement en base de données
        // Exemple d'implémentation d'envoi d'e-mail (nécessite configuration)
        /*
        Mail::send('emails.contact', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'userMessage' => $validated['message'],
        ], function ($message) use ($validated) {
            $message->from($validated['email'], $validated['name']);
            $message->to('contact@groop.fr', 'Groop Support');
            $message->subject('Message de contact: ' . $validated['subject']);
        });
        */

        // Redirection avec message de succès
        return redirect()->route('contact')->with('success', 'Merci pour votre message ! Nous vous contacterons rapidement.');
    }
}
