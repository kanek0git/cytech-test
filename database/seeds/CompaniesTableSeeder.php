<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'company_name' => '株式会社A',
            'street_address' => '東京都品川区広町xx-xxx',
            'representative_name' => 'サンプル太郎'
        ];
        DB::table('companies')->insert($param);

        $param = [
            'company_name' => '株式会社B',
            'street_address' => '福岡県福岡市博多区xx-xxx',
            'representative_name' => 'テスト次郎'
        ];
        DB::table('companies')->insert($param);

        $param = [
            'company_name' => '株式会社C',
            'street_address' => '大阪府大阪市此花区桜島xx-xxx',
            'representative_name' => 'プラクティス花子'
        ];
        DB::table('companies')->insert($param);
    }
}
