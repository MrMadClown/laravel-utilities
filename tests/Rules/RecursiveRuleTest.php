<?php

namespace MrMadClown\LaravelUtilities\Tests\Rules;

use MrMadClown\LaravelUtilities\Validation\Rules\RecursiveRule;
use Illuminate\Contracts\Validation\Rule;
use PHPUnit\Framework\TestCase;

class RecursiveRuleTest extends TestCase
{
    public function testPassingArray(): void
    {
        $innerRule = $this->getMockBuilder(Rule::class)->getMock();
        $innerRule->expects(static::once())->method('passes')
            ->with(static::equalTo('key'), static::equalTo('value'))
            ->willReturn(true);

        $rule = new RecursiveRule($innerRule);
        $passed = $rule->passes('attribute', ['some' => ['nested' => ['key' => 'value']]]);

        static::assertEquals(true, $passed);
    }

    public function testPassingString(): void
    {
        $innerRule = $this->getMockBuilder(Rule::class)->getMock();
        $innerRule->expects(static::once())->method('passes')
            ->with(static::equalTo('attribute'), static::equalTo('not-nested'))
            ->willReturn(true);

        $rule = new RecursiveRule($innerRule);
        $passed = $rule->passes('attribute', 'not-nested');

        static::assertEquals(true, $passed);
    }

    public function testDelegateMessage(): void
    {
        $innerRule = $this->getMockBuilder(Rule::class)->getMock();
        $innerRule->expects(static::once())->method('message')
            ->willReturn('Dis is a message for da people');

        $rule = new RecursiveRule($innerRule);
        $message = $rule->message();
        static::assertEquals('Dis is a message for da people', $message);
    }
}
