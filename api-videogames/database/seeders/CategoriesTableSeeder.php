<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category1=new Category;
        $category1->name="Sports";
        $category1->description="Categoria basada en deportes como fútbol, paddel, tenis...";
        $category1->save();

        $category2=new Category;
        $category2->name="Shooter";
        $category2->description="Categoria basada en shooters como call of duty";
        $category2->save();

        $category3=new Category;
        $category3->name="RPG";
        $category3->description="Categoria basada en juegos de rol";
        $category3->save();

        $category4=new Category;
        $category4->name="MMORPG";
        $category4->description="Categoria basada en rol y acción.";
        $category4->save();
    }
}
