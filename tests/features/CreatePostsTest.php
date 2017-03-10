<?php

class CreatePostsTest extends \FeatureTestCase
{
    function test_a_user_create_a_post()
    {
        //Having
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';

        $this->actingAs($user = $this->defaultUser());

        //When
        $this->visit(route('posts.create'))
            ->type($title, 'title')
            ->type($content, 'content')
            ->press('Publicar');

        //Then
        $this->seeInDatabase('posts', [
           'title' => $title,
            'content' => $content,
            'pending' => true,
            'user_id' => $user->id
        ]);

        //Usuario redirigido al detalle del post
        $this->see($title);
    }

    function test_creating_a_post_requires_authentication()
    {
        //When
        $this->visit(route('posts.create'))
            ->seePageIs(route('login'));
    }

    function test_a_guest_user_tries_to_create_a_post()
    {
        //Having
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';

        //When
        $this->visit(route('posts.create'))
            ->type($title, 'title')
            ->type($content, 'content')
            ->press('Publicar');

        //Then
        $this->seeInDatabase('posts', [
            'title' => $title,
            'content' => $content,
            'pending' => true,
            'user_id' => $user->id
        ]);

        //Usuario redirigido al detalle del post
        $this->see($title);
    }
}