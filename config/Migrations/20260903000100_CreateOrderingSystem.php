<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateOrderingSystem extends AbstractMigration
{
    public function change(): void
    {
        $users = $this->table('users');
        $users
            ->addColumn('name', 'string', ['limit' => 120])
            ->addColumn('email', 'string', ['limit' => 191])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('role', 'string', ['limit' => 20, 'default' => 'customer'])
            ->addColumn('phone', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->addIndex(['email'], ['unique' => true])
            ->create();

        $menuItems = $this->table('menu_items');
        $menuItems
            ->addColumn('name', 'string', ['limit' => 120])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('image', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('is_available', 'boolean', ['default' => true])
            ->addColumn('sort_order', 'integer', ['default' => 0])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->create();

        $locations = $this->table('delivery_locations');
        $locations
            ->addColumn('user_id', 'integer', ['null' => true])
            ->addColumn('latitude', 'decimal', ['precision' => 10, 'scale' => 7])
            ->addColumn('longitude', 'decimal', ['precision' => 10, 'scale' => 7])
            ->addColumn('address', 'string', ['limit' => 255])
            ->addColumn('details', 'text', ['null' => true])
            ->addColumn('house_photo', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->create();

        $orders = $this->table('orders');
        $orders
            ->addColumn('user_id', 'integer', ['null' => true])
            ->addColumn('delivery_location_id', 'integer', ['null' => true])
            ->addColumn('status', 'string', ['limit' => 30, 'default' => 'received'])
            ->addColumn('payment_method', 'string', ['limit' => 30, 'default' => 'cash'])
            ->addColumn('payment_status', 'string', ['limit' => 30, 'default' => 'unpaid'])
            ->addColumn('subtotal', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('delivery_fee', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0])
            ->addColumn('total', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('notes', 'text', ['null' => true])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('delivery_location_id', 'delivery_locations', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addIndex(['status'])
            ->addIndex(['created'])
            ->create();

        $orderItems = $this->table('order_items');
        $orderItems
            ->addColumn('order_id', 'integer')
            ->addColumn('menu_item_id', 'integer', ['null' => true])
            ->addColumn('item_name', 'string', ['limit' => 120])
            ->addColumn('unit_price', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('quantity', 'integer')
            ->addColumn('line_total', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('notes', 'string', ['limit' => 255, 'null' => true])
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('menu_item_id', 'menu_items', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->create();

        $reviews = $this->table('reviews');
        $reviews
            ->addColumn('order_id', 'integer')
            ->addColumn('user_id', 'integer', ['null' => true])
            ->addColumn('rating', 'integer')
            ->addColumn('comment', 'text', ['null' => true])
            ->addColumn('is_published', 'boolean', ['default' => true])
            ->addColumn('created', 'datetime')
            ->addColumn('modified', 'datetime')
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addIndex(['order_id'], ['unique' => true])
            ->create();

        $history = $this->table('order_status_history');
        $history
            ->addColumn('order_id', 'integer')
            ->addColumn('status', 'string', ['limit' => 30])
            ->addColumn('changed_by', 'integer', ['null' => true])
            ->addColumn('note', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('created', 'datetime')
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('changed_by', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addIndex(['order_id', 'created'])
            ->create();

        $this->table('menu_items')->insert([
            [
                'name' => 'Classic Pork Dumplings',
                'description' => 'Steamed dumplings with pork, cabbage, and ginger.',
                'price' => 6.50,
                'is_available' => true,
                'sort_order' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Chicken Dumplings',
                'description' => 'Steamed dumplings with chicken, spring onion, and sesame.',
                'price' => 6.00,
                'is_available' => true,
                'sort_order' => 2,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Vegetable Dumplings',
                'description' => 'Steamed dumplings with mushroom, cabbage, and carrot.',
                'price' => 5.50,
                'is_available' => true,
                'sort_order' => 3,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Chilli Oil',
                'description' => 'House chilli oil for dipping.',
                'price' => 1.00,
                'is_available' => true,
                'sort_order' => 4,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ])->save();
    }
}
