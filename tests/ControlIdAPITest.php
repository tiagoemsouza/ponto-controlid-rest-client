<?php

declare(strict_types=1);

namespace tiagoemsouza\ControlIdAPI\Tests;

use PHPUnit\Framework\TestCase;

class ControlIdAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test(): void
    {
        $this->expectNotToPerformAssertions();
    }

    /**
     * Undocumented function
     *
     * @param string $path
     * @return array<string, string>
     */
    protected function loadFixtures(string $path): array
    {
        $filename = __DIR__ . '/Fixture/' . $path . '.json';
        $contents = file_get_contents($filename);
        if ($contents === false) {
            return [];
        }
        
        $data = json_decode($contents, true);

        if($data === null){
            $data['data'] = $contents;
        }

        return $data;
    }
}
