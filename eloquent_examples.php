<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;
use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$connectionParams = [
    'driver' => $_ENV['DB_DRIVER'] ?? 'mysql',
    'host' => $_ENV['DB_HOST'],
    'database' => $_ENV['DB_DATABASE'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
];

$capsule = new Capsule;

$capsule->addConnection($connectionParams);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

// ================================================================
// == CREATE
Capsule::connection()->transaction(function() {
    $invoice = new Invoice();
    $invoice->amount = 45;
    $invoice->invoice_number = '1';
    $invoice->status = InvoiceStatus::Paid;
    $invoice->due_date = (new Carbon())->addDays(10);
    $invoice->save();

    $rawInvoiceItems = [
        ['Item 1', 1, 15],
        ['Item 2', 2, 7.5],
        ['Item 3', 4, 3.75]
    ];

    foreach($rawInvoiceItems as [$description, $quantity, $unitPrice]) {
        $invoiceItem = new InvoiceItem();
        $invoiceItem->description = $description;
        $invoiceItem->quantity = $quantity;
        $invoiceItem->unit_price = $unitPrice;

        $invoiceItem->invoice()->associate($invoice);

        $invoiceItem->save();
    }
});

// == UPDATE
// $invoiceId = 1;
// Invoice::query()->where('id', $invoiceId)->update(['state' => InvoiceStatus::Paid]);

// Invoice::where('status', InvoiceStatus::Paid)->get()->each(function(Invoice $invoice) {
//     echo $invoice->id . ', '. $invoice->status->toString(). ', '. $invoice->created_at->format('m/d/Y'). PHP_EOL;

//     $item = $invoice->items->first();

//     $item->description = 'Foo Bar';

//     $invoice->invoice_name = '3';

//     // push() will update association first before updating the model
//     $invoice->push();
// });

// == DELETE
// Xóa các items có description là Item 2 của từng Invoice đã paid
// Invoice::where('status', InvoiceStatus::Paid)-> get()->each(function(Invoice $invoice) {
//     echo $invoice->id . ', '. $invoice->status->toString(). ', '. $invoice->created_at->format('m/d/Y'). PHP_EOL;

//     $invoice->items()->where('description', 'Item 2')->delete();
// } )
?>
