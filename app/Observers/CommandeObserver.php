<?php

namespace App\Observers;

use App\Jobs\SendStatusNotification;
use App\Models\Commande;
use App\Models\Fcm;
use App\Models\User;
use Kreait\Firebase\Factory;

class CommandeObserver
{
    /**
     * Handle the Commande "created" event.
     */
    public function created(Commande $commande): void
    {
        //
    }

    /**
     * Handle the Commande "updated" event.
     */
    public function updated(Commande $commande): void
    {
        $user=User::where('id', $commande->user_id)->first();
         $credentialsPath = storage_path('app/firebase/pharmacy-74ca4-firebase-adminsdk-fbsvc-6e9f7c7ec1.json');

       if (!file_exists($credentialsPath)) {
    logger("Firebase credentials not found at: " . $credentialsPath);
    return;
}else{
    logger("Firebase credentials found at: ". $credentialsPath);
}
        $factory = (new Factory())->withServiceAccount($credentialsPath);


        $messaging = $factory->createMessaging();
        $lang= $user->lang ?? 'fr';
        if ($lang == 'ar') {
            $statusMessage = "تم  تحديث حالة طلبك  " ;
        } else {
            $statusMessage = "Le statut de votre commande a été mis à jour" ;
        }

        $token = Fcm::where('user_id', $user->id)->value('token');

                  if($lang == 'ar'){
                      $messages = [
                'token' => $token,
                'notification' => [
                    'title' => $commande->ar_status,
                    'body' => $commande->reject_reason != null ? $commande->reject_reason : $statusMessage,
                ],
            ];
                  }else{
                      $messages = [
                'token' => $token,
                'notification' => [
                    'title' => $commande->status,
                    'body' => $commande->reject_reason != null ? $commande->reject_reason : $statusMessage,
                ],
            ];
                  }
            $messaging->send($messages);
    }

    /**
     * Handle the Commande "deleted" event.
     */
    public function deleted(Commande $commande): void
    {
        //
    }

    /**
     * Handle the Commande "restored" event.
     */
    public function restored(Commande $commande): void
    {
        //
    }

    /**
     * Handle the Commande "force deleted" event.
     */
    public function forceDeleted(Commande $commande): void
    {
        //
    }
}
