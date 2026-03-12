<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('notes')->insert([
            [
                'user_id' => 2,
                'title' => 'Laravel Seeder',
                'body' => 'Ako vytvoriť seeder v Laraveli?',
                'status' => 'published',
                'is_pinned' => true,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'user_id' => 3,
                'title' => 'Shopping List',
                'body' => 'Mlieko, chlieb, vajcia',
                'status' => 'draft',
                'is_pinned' => false,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'user_id' => 2,
                'title' => 'Project Idea',
                'body' => 'Nápad na nový startup...',
                'status' => 'archived',
                'is_pinned' => false,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'user_id' => 4,
                'title' => 'Meeting Notes',
                'body' => 'Zápisky zo stretnutia s tímom',
                'status' => 'draft',
                'is_pinned' => false,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'user_id' => 5,
                'title' => 'Ideas for Blog',
                'body' => 'Temy a nápady pre blog',
                'status' => 'draft',
                'is_pinned' => false,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'user_id' => 4,
                'title' => 'Meeting Notes',
                'body' => 'Zápisky zo stretnutia s tímom',
                'status' => 'draft',
                'is_pinned' => false,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'user_id' => 6,
                'title' => 'Mods for Minecraft Modpack',
                'body' => 'Mody a textures pre modpack',
                'status' => 'draft',
                'is_pinned' => false,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
        ]);
    }
}
