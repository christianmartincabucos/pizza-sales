<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pizza;
use App\Models\PizzaType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCsvData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from CSV files into the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting import process...');
        
        DB::beginTransaction();
        
        try {
            $this->importPizzaTypes();
            $this->importPizzas();
            $this->importOrders();
            $this->importOrderDetails();
            
            DB::commit();
            $this->info('Import completed successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Import failed: ' . $e->getMessage());
        }
    }
    
    private function importPizzaTypes()
    {
        $this->info('Importing pizza types...');
        
        $handle = fopen(base_path('data/pizza_types.csv'), 'r');
        $header = fgetcsv($handle);
        
        while (($data = fgetcsv($handle)) !== false) {
            PizzaType::create([
                'code' => $data[0],
                'name' => $data[1],
                'category' => $data[2],
                'ingredients' => $data[3],
            ]);
        }
        
        fclose($handle);
        $this->info('Pizza types imported!');
    }
    
    private function importPizzas()
    {
        $this->info('Importing pizzas...');
        
        $handle = fopen(base_path('data/pizzas.csv'), 'r');
        $header = fgetcsv($handle);
        
        $pizzaTypeMap = PizzaType::pluck('id', 'code')->toArray();
        
        while (($data = fgetcsv($handle)) !== false) {
            $pizzaType = PizzaType::where('code', $data[1])->first();

            if ($pizzaType) {
                Pizza::create([
                    'code' => $data[0],
                    'pizza_type_id' => $pizzaType['id'],
                    'size' => $data[2],
                    'price' => $data[3],
                ]);
            }
        }
        
        fclose($handle);
        $this->info('Pizzas imported!');
    }
    
    private function importOrders()
    {
        $this->info('Importing orders...');
        
        $handle = fopen(base_path('data/orders.csv'), 'r');
        $header = fgetcsv($handle);
        
        while (($data = fgetcsv($handle)) !== false) {
            Order::create([
                'date' => $data[1],
                'time' => $data[2],
            ]);
        }
        
        fclose($handle);
        $this->info('Orders imported!');
    }
    
    private function importOrderDetails()
    {
        $this->info('Importing order details...');
        
        $handle = fopen(base_path('data/order_details.csv'), 'r');
        $header = fgetcsv($handle);
        
        while (($data = fgetcsv($handle)) !== false) {
            $order = Order::find($data[1]);
            if ($order) {
                $pizza = Pizza::where('code', $data[2])->first();
                if ($pizza) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'pizza_id' => $pizza->id,
                        'quantity' => $data[3],
                    ]);
                }
            }
        }
        
        fclose($handle);
        $this->info('Order details imported!');
    }
}
