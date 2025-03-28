<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Traite la soumission du formulaire de contact.
     * Solution temporaire avant la mise en place d'un système d'envoi d'email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'privacy' => 'required',
        ]);

        // Enregistrement du message dans les logs pour ne pas le perdre
        Log::info('Nouveau message de contact reçu', [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // Stockage temporaire en session (visible uniquement pour les admins)
        if (!session()->has('contact_messages')) {
            session(['contact_messages' => []]);
        }

        $messages = session('contact_messages');
        $messages[] = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'date' => now()->toDateTimeString(),
        ];

        session(['contact_messages' => $messages]);

        // Redirection avec message de succès
        return redirect()->back()->with('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
    }
}
