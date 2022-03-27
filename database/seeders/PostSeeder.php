<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
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
        // post1
        $post1 = Post::create([
            'category_id' => Category::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'title' => 'Tradisi Bali Aga Perang Pandan - Desa Tenganan Pegringsingan',
            'slug' => Str::slug('Tradisi Bali Aga Perang Pandan - Desa Tenganan Pegringsingan' . '-' . Str::random(12)),
            'subtitle' => 'One of the unique cultures in Bali',
            'quote' => 'There is a way out of every box, a solution to every puzzle; it’s just a matter of finding it.',
            'quote_author' => 'JEAN-LUC PICARD',
            'youtube_link' => 'https://youtu.be/ebchrRL2B9A',
            'thumbnail' => 'https://images.unsplash.com/photo-1648138754704-b85f09b672c1?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwxMHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'sub_thumbnail1' => 'https://images.unsplash.com/photo-1648250412305-7d0d46c32534?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyMHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'sub_thumbnail2' => 'https://images.unsplash.com/photo-1648287029242-eced0ef703a6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0OXx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'header' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore.',
            'body' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore. Aut molestias dolor velit eaque error adipisci. Animi tempore facere quibusdam quia. Quia dolorum porro voluptatem autem. Nesciunt qui exercitationem nostrum sint. Natus aut nihil molestiae sunt impedit. Qui qui in aut possimus sint autem atque mollitia. Voluptatum aspernatur ea error odio tenetur sed cum.',
            'footer' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit.',
        ]);
        $post1->tags()->attach(Tag::all()->random()->id);

        // post2
        $post2 = Post::create([
            'category_id' => Category::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'title' => 'On the Inquisition of America`s First Black Woman Supreme Court Nominee',
            'slug' => Str::slug('On the Inquisition of America`s First Black Woman Supreme Court Nominee' . '-' . Str::random(12)),
            'subtitle' => 'Lorem ipsum dolor sit amet consectetur.',
            'quote' => 'There is a way out of every box, a solution to every puzzle; it’s just a matter of finding it.',
            'quote_author' => 'JEAN-LUC PICARD',
            'youtube_link' => 'https://youtu.be/ebchrRL2B9A',
            'thumbnail' => 'https://images.unsplash.com/photo-1648313913756-73e75187ac19?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw4fHx8ZW58MHx8fHw%3D&auto=format&fit=crop&w=500&q=60',
            'sub_thumbnail1' => 'https://images.unsplash.com/photo-1648138754704-b85f09b672c1?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwxMHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'sub_thumbnail2' => 'https://images.unsplash.com/photo-1648241412743-c1bec0152483?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwxOHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'header' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore.',
            'body' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore. Aut molestias dolor velit eaque error adipisci. Animi tempore facere quibusdam quia. Quia dolorum porro voluptatem autem. Nesciunt qui exercitationem nostrum sint. Natus aut nihil molestiae sunt impedit. Qui qui in aut possimus sint autem atque mollitia. Voluptatum aspernatur ea error odio tenetur sed cum.',
            'footer' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit.',
        ]);
        $post2->tags()->attach(Tag::all()->random()->id);

        // post3
        $post3 = Post::create([
            'category_id' => Category::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'title' => 'More Checks! The Gas Rebate Act is Peak America',
            'slug' => Str::slug('More Checks! The Gas Rebate Act is Peak America' . '-' . Str::random(12)),
            'subtitle' => 'Lorem ipsum dolor sit amet consectetur.',
            'quote' => 'There is a way out of every box, a solution to every puzzle; it’s just a matter of finding it.',
            'quote_author' => 'JEAN-LUC PICARD',
            'youtube_link' => 'https://youtu.be/ebchrRL2B9A',
            'thumbnail' => 'https://images.unsplash.com/photo-1648138754711-e4f5be56cccb?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw1OHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'sub_thumbnail1' => 'https://images.unsplash.com/photo-1648187618027-3b98343e28c3?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw2M3x8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'sub_thumbnail2' => 'https://images.unsplash.com/photo-1648313601328-b3a5799e565c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw2NHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'header' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore.',
            'body' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore. Aut molestias dolor velit eaque error adipisci. Animi tempore facere quibusdam quia. Quia dolorum porro voluptatem autem. Nesciunt qui exercitationem nostrum sint. Natus aut nihil molestiae sunt impedit. Qui qui in aut possimus sint autem atque mollitia. Voluptatum aspernatur ea error odio tenetur sed cum.',
            'footer' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit.',
        ]);
        $post3->tags()->attach(Tag::all()->random()->id);

        // post4
        $post4 = Post::create([
            'category_id' => Category::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'title' => "My Family Is in Mariupol. I Don't Know if I'll Hear From Them Again",
            'slug' => Str::slug("My Family Is in Mariupol. I Don't Know if I'll Hear From Them Again" . '-' . Str::random(12)),
            'subtitle' => 'Lorem ipsum dolor sit amet consectetur.',
            'quote' => 'There is a way out of every box, a solution to every puzzle; it’s just a matter of finding it.',
            'quote_author' => 'JEAN-LUC PICARD',
            'youtube_link' => 'https://youtu.be/ebchrRL2B9A',
            'thumbnail' => 'https://images.unsplash.com/photo-1648147443984-9fbd95bcdd54?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw3Mnx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'sub_thumbnail1' => 'https://images.unsplash.com/photo-1644982652061-df82282e178d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHw3MXx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'sub_thumbnail2' => 'https://images.unsplash.com/photo-1648280814049-ee9bfafc3f1d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw5OHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'header' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore.',
            'body' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore. Aut molestias dolor velit eaque error adipisci. Animi tempore facere quibusdam quia. Quia dolorum porro voluptatem autem. Nesciunt qui exercitationem nostrum sint. Natus aut nihil molestiae sunt impedit. Qui qui in aut possimus sint autem atque mollitia. Voluptatum aspernatur ea error odio tenetur sed cum.',
            'footer' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit.',
        ]);
        $post4->tags()->attach(Tag::all()->random()->id);

        // post5
        $post5 = Post::create([
            'category_id' => Category::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'title' => "How Can I Be Happy While Ukraine Is Being Destroyed?",
            'slug' => Str::slug("How Can I Be Happy While Ukraine Is Being Destroyed?" . '-' . Str::random(12)),
            'subtitle' => 'Lorem ipsum dolor sit amet consectetur.',
            'quote' => 'There is a way out of every box, a solution to every puzzle; it’s just a matter of finding it.',
            'quote_author' => 'JEAN-LUC PICARD',
            'youtube_link' => 'https://youtu.be/ebchrRL2B9A',
            'thumbnail' => 'https://images.unsplash.com/photo-1648147221082-b5d41bd54fc9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw3OHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'sub_thumbnail1' => 'https://images.unsplash.com/photo-1648147385426-68b1736c7d8f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw3Nnx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'sub_thumbnail2' => 'https://images.unsplash.com/photo-1648226313182-d73107e609ec?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw3N3x8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'header' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore.',
            'body' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore. Aut molestias dolor velit eaque error adipisci. Animi tempore facere quibusdam quia. Quia dolorum porro voluptatem autem. Nesciunt qui exercitationem nostrum sint. Natus aut nihil molestiae sunt impedit. Qui qui in aut possimus sint autem atque mollitia. Voluptatum aspernatur ea error odio tenetur sed cum.',
            'footer' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit.',
        ]);
        $post5->tags()->attach(Tag::all()->random()->id);

        // post6
        $post6 = Post::create([
            'category_id' => Category::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'title' => "Storytelling Secrets from the Breaking Bad Writers’ Room",
            'slug' => Str::slug("Storytelling Secrets from the Breaking Bad Writers’ Room" . '-' . Str::random(12)),
            'subtitle' => 'Lorem ipsum dolor sit amet consectetur.',
            'quote' => 'There is a way out of every box, a solution to every puzzle; it’s just a matter of finding it.',
            'quote_author' => 'JEAN-LUC PICARD',
            'youtube_link' => 'https://youtu.be/ebchrRL2B9A',
            'thumbnail' => 'https://images.unsplash.com/photo-1648277511183-c2caf34f428b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwxODl8fHxlbnwwfHx8fA%3D%3D&auto=format&fit=crop&w=500&q=60',
            // 'sub_thumbnail1' => 'https://images.unsplash.com/photo-1648147385426-68b1736c7d8f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw3Nnx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            // 'sub_thumbnail2' => 'https://images.unsplash.com/photo-1648226313182-d73107e609ec?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw3N3x8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60',
            'header' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore.',
            'body' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit. Perspiciatis minus ut animi qui id pariatur sit. Voluptatem ut natus sequi sed commodi ea nihil. Quo at earum necessitatibus excepturi natus quia labore. Aut molestias dolor velit eaque error adipisci. Animi tempore facere quibusdam quia. Quia dolorum porro voluptatem autem. Nesciunt qui exercitationem nostrum sint. Natus aut nihil molestiae sunt impedit. Qui qui in aut possimus sint autem atque mollitia. Voluptatum aspernatur ea error odio tenetur sed cum.',
            'footer' => 'Optio qui molestiae voluptas perferendis et nulla reprehenderit. Vero qui velit porro voluptas consequatur porro. Est laborum aperiam reprehenderit perferendis quisquam vel consequuntur velit.',
        ]);
        $post6->tags()->attach(Tag::all()->random()->id);
    }
}
