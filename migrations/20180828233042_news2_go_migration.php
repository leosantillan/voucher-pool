<?php


use Phinx\Migration\AbstractMigration;

class News2GoMigration extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('recipients');
        $table->addColumn('name', 'string')
            ->addColumn('email', 'text')
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->create();

        $table->insert([
            'name' => 'Test',
            'email' => 'test@test.com'
        ]);
        $table->saveData();


        $table = $this->table('special_offers');
        $table->addColumn('name', 'string')
            ->addColumn('discount', 'float')
            ->addColumn('expiration_date', 'date')
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->create();


        $table = $this->table('voucher_codes');
        $table->addColumn('special_offer_id', 'integer')
            ->addColumn('recipient_id', 'integer')
            ->addColumn('code', 'string')
            ->addColumn('used_at', 'date')
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->addForeignKey('special_offer_id', 'special_offers', 'id')
            ->addForeignKey('recipient_id', 'recipients', 'id')
            ->create();
    }

    public function down() 
    {
        $this->dropTable('recipients');
        $this->dropTable('special_offers');
        $this->dropTable('voucher_codes');
    }
}
