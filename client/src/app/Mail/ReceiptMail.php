<?php
// app/Mail/ReceiptMail.php

namespace App\Mail;

use App\Models\Transaction;
use App\Models\FarewellMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public Transaction $transaction;
    public ?FarewellMessage $farewellMessage;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->farewellMessage = FarewellMessage::where('is_active', true)
            ->inRandomOrder()
            ->first();
    }

    public function build()
    {
        return $this->subject('Your Purchase Receipt from Possibilitea')
                    ->view('emails.receipt')
                    ->with([
                        'transaction' => $this->transaction,
                        'farewellMessage' => $this->farewellMessage,
                    ]);
    }
}