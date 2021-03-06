<?php

namespace Nuwave\Lighthouse\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Cache\Repository;
use Nuwave\Lighthouse\GraphQL;

class ValidateSchemaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lighthouse:validate-schema';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate the GraphQL schema definition.';

    /**
     * Execute the console command.
     */
    public function handle(Repository $cache, GraphQL $graphQL): void
    {
        // Clear the cache so this always validates the current schema
        $cache->forget(config('lighthouse.cache.key'));

        $schema = $graphQL->prepSchema();
        $schema->assertValid();

        $this->info('The defined schema is valid.');
    }
}
