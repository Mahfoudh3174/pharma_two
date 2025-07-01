<?php

namespace App\Jobs;

use App\Models\Commande;
use App\Models\Fcm;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\AndroidConfig;
use Log;

class SendStatusNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected Commande $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
        Log::info('$commande: ' . $commande->user_id);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $statusMessage = "Votre demande a été répondue par " . $this->commande->status;
        $arStatusMessage = "تم الرد على طلبك ب " . $this->commande->ar_status;

        // 1. Verify Firebase credentials
        $credentialsPath = storage_path('app/firebase/pharmacy-74ca4-firebase-adminsdk-fbsvc-6e9f7c7ec1.json');
        if (!file_exists($credentialsPath)) {
            Log::error("Firebase credentials not found");
            return;
        }

        // 2. Initialize Firebase
        $factory = (new Factory())->withServiceAccount($credentialsPath);
        $messaging = $factory->createMessaging();

        // 3. Get user and FCM token
        $user = User::find($this->commande->user_id);
        $lang= $user->lang ?? 'fr';
        if (!$user) {
            Log::error("User not found for commande: " . $this->commande->id);
            return;
        }

        $fcmToken = Fcm::where('user_id', $user->id)->value('token');

        // 4. Validate token
        if (empty($fcmToken)) {
            Log::info("No FCM token found for user: " . $user->id);
            return;
        }

        // Clean and validate token
        $fcmToken = trim((string) $fcmToken);
        
        Log::info("Attempting to send to token: " . substr($fcmToken, 0, 20) . "...");

        // 5. Build message step by step
        try {
            // Create notification
            if( $lang === 'ar') {
                $notification = Notification::fromArray([
                    'title' => "حالة الطلب",
                    'body' => $arStatusMessage,
                ]);
            } else {
                $notification = Notification::fromArray([
                'title' => "Statut de commande",
                'body' => $statusMessage,
            ]);
            }

            // Create base message
            $message = CloudMessage::new();
            
            // Set target token
            $message = $message->withTarget('token', $fcmToken);
            
            // Add notification
            $message = $message->withNotification($notification);
            
            // Add data payload
            $message = $message->withData([
                'commande_id' => (string)$this->commande->id,
                'status' => $this->commande->status,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            ]);

            // Send notification
            $result = $messaging->send($message);
            Log::info("Notification sent successfully: " . $result);
            
        } catch (\Kreait\Firebase\Exception\Messaging\InvalidMessage $e) {
            Log::error("Invalid message format: " . $e->getMessage());
            Log::error("Full error: " . $e->getTraceAsString());
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            Log::error("Firebase messaging error: " . $e->getMessage());
            
            // Handle specific token errors
            if (str_contains($e->getMessage(), 'invalid-registration-token') ||
                str_contains($e->getMessage(), 'registration-token-not-registered')) {
                Fcm::where('token', $fcmToken)->delete();
                Log::info("Invalid token deleted: " . $fcmToken);
            }
        } catch (\Throwable $e) {
            Log::error("General notification error: " . $e->getMessage());
            Log::error("Error class: " . get_class($e));
        }
    }
}