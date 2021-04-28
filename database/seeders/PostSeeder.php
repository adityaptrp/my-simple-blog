<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::create([
            'category_id' => 3,
            'user_id' => 1,
            'title' => 'Tradisi Bali Aga Perang Pandan - Desa Tenganan Pegringsingan',
            'subtitle' => 'One of the unique cultures in Bali',
            'quote' => 'There is a way out of every box, a solution to every puzzle; it’s just a matter of finding it.',
            'quote_author' => 'JEAN-LUC PICARD',
            'youtube_link' => 'https://youtu.be/ebchrRL2B9A',
            'thumbnail' => 'images/posts/perang-pandan.jpg',
            'sub_thumbnail1' => 'images/posts/post-5.jpg',
            'sub_thumbnail2' => 'images/posts/post-6.jpg',
            'slug' => Str::slug('Tradisi Bali Aga Perang Pandan - Desa Tenganan Pegringsingan' . '-' . Str::random(12)),
            'header' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore.',
            'body' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore. Aut molestias dolor velit eaque error adipisci. Animi tempore facere quibusdam quia. Quia dolorum porro voluptatem autem. Nesciunt qui exercitationem nostrum sint. Natus aut nihil molestiae sunt impedit. Qui qui in aut possimus sint autem atque mollitia. Voluptatum aspernatur ea error odio tenetur sed cum.',
            'footer' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit.',
        ]);
    }
}
