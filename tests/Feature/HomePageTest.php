<?php

test('home page loads successfully', function () {

    $this->withoutVite();

    $this->get('/')
        ->assertOk();
});