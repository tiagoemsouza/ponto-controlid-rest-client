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
        $isBase64 = preg_match('/^data:text\/plain;base64,(.*)/m', $contents, $matches);

        if (!$isBase64) {
            $data = json_decode($contents, true);
        } else {
            $data['data'] = $matches[1];
        }
        
        return $data;
    }
}
