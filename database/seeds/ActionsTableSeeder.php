<?php

use Illuminate\Database\Seeder;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['skip_next', 'Pular próximo', 0],
            ['play_again', 'Jogar novamente', 0],
            ['next_draw_2', 'Próximo compra 2', 0],
            ['prev_draw_2', 'Anterior compra 2', 0],
            ['wild_card', 'Escolhe Naipe', 1],
            ['revert_order', 'Reverter a ordem', 0],
            ['wild_draw_4', 'Próximo compra 4', 1]
        ];

        foreach($data as $row)
        {
            list($key, $name) = $row;
            \MauMau\Models\Action::create([
                'key' => $key,
                'name' => $name
            ]);
        }
    }
}
