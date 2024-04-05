<?php

namespace App\Model\Process;

use PHPUnit\Framework\TestCase;

class ProcessTest extends TestCase
{
    public function testProcess() {

        $process = new Process();

        $result = $process->process();

        $this->assertIsArray($result);

        if (!empty($result)) {
            foreach ($result as $value) {
                $this->assertIsFloat($value);
            }
        }
    }
}
