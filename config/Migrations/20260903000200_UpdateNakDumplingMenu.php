<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class UpdateNakDumplingMenu extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('menu_items');
        $this->execute('DELETE FROM menu_items');
        $now = date('Y-m-d H:i:s');
        $table->insert([
            ['name' => 'Set Soup', 'description' => '6 pieces steamed dumplings with free chilli oil.', 'price' => 10.00, 'is_available' => true, 'sort_order' => 1, 'created' => $now, 'modified' => $now],
            ['name' => 'Set Mee Sua', 'description' => 'Mee sua noodles with free chilli oil.', 'price' => 5.00, 'is_available' => true, 'sort_order' => 2, 'created' => $now, 'modified' => $now],
            ['name' => 'Set Steam', 'description' => '6 pieces steamed dumplings with free chilli oil.', 'price' => 10.00, 'is_available' => true, 'sort_order' => 3, 'created' => $now, 'modified' => $now],
            ['name' => 'Set Mee Sua with Beef', 'description' => 'Mee sua noodles with beef and free chilli oil.', 'price' => 16.00, 'is_available' => true, 'sort_order' => 4, 'created' => $now, 'modified' => $now],
            ['name' => 'Set Fried', 'description' => '6 pieces fried dumplings with free Thai sauce.', 'price' => 10.00, 'is_available' => true, 'sort_order' => 5, 'created' => $now, 'modified' => $now],
            ['name' => 'Party Box Soup / Steam', 'description' => '50 pieces of soup or steamed dumplings.', 'price' => 75.00, 'is_available' => true, 'sort_order' => 6, 'created' => $now, 'modified' => $now],
            ['name' => 'Party Box Fried', 'description' => '50 pieces of fried dumplings.', 'price' => 80.00, 'is_available' => true, 'sort_order' => 7, 'created' => $now, 'modified' => $now],
            ['name' => 'Frozen Dumpling', 'description' => '12 pieces, ready to cook at home.', 'price' => 15.00, 'is_available' => true, 'sort_order' => 8, 'created' => $now, 'modified' => $now],
            ['name' => 'Add-on Soup', 'description' => 'Add a bowl of soup to your order.', 'price' => 2.00, 'is_available' => true, 'sort_order' => 9, 'created' => $now, 'modified' => $now],
            ['name' => 'Add-on Dumpling', 'description' => 'Extra dumpling, RM2 per piece.', 'price' => 2.00, 'is_available' => true, 'sort_order' => 10, 'created' => $now, 'modified' => $now],
            ['name' => 'Add-on Mee Sua', 'description' => 'Add a serving of mee sua.', 'price' => 3.00, 'is_available' => true, 'sort_order' => 11, 'created' => $now, 'modified' => $now],
            ['name' => 'Add-on Chilli Oil', 'description' => 'Small tub of house chilli oil.', 'price' => 1.00, 'is_available' => true, 'sort_order' => 12, 'created' => $now, 'modified' => $now],
        ])->save();
    }
}
