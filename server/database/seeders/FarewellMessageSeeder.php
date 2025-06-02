<?php
// database/seeders/FarewellMessageSeeder.php

namespace Database\Seeders;

use App\Models\FarewellMessage;
use Illuminate\Database\Seeder;

class FarewellMessageSeeder extends Seeder
{
    public function run()
    {
        $messages = [
            "Thank you for choosing Possibilitea! May your tea bring you peace and joy.",
            "Sip, savor, and smile! Thanks for being a wonderful customer.",
            "Your perfect cup of tea awaits! Come back soon for more delightful flavors.",
            "Tea is liquid wisdom - thank you for sharing this moment with us!",
            "From our tea family to yours, thank you for your purchase!",
            "May every sip remind you of the good things in life. See you again!",
            "Life is like tea - it's all about how you brew it. Thanks for visiting!",
            "You're tea-riffic! Thank you for supporting our local tea shop.",
            "Brew happiness, one cup at a time. Thank you for your visit!",
            "Tea you later! Thanks for making our day brighter.",
        ];

        foreach ($messages as $message) {
            FarewellMessage::create(['message' => $message]);
        }
    }
}