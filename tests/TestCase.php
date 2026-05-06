<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase; // Adicione aqui

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase; 
}