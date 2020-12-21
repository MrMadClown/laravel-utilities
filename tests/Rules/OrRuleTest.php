<?php

namespace MrMadClown\LaravelUtilities\Tests\Rules;

use Illuminate\Contracts\Validation\Rule;
use MrMadClown\LaravelUtilities\Validation\Rules\OrRule;
use PHPUnit\Framework\TestCase;

class OrRuleTest extends TestCase
{
    public function testEither(): void
    {
        $either = $this->getMockBuilder(Rule::class)->getMock();
        $either->expects(static::once())
            ->method('passes')
            ->with(static::equalTo('attribute'), static::equalTo(1))
            ->willReturn(true);

        $or = $this->getMockBuilder(Rule::class)->getMock();
        $or->expects(static::never())->method('passes');

        $rule = new OrRule($either, $or);
        $passed = $rule->passes('attribute', 1);

        static::assertEquals(true, $passed);
    }

    public function testOr(): void
    {
        $either = $this->getMockBuilder(Rule::class)->getMock();
        $either->expects(static::once())
            ->method('passes')
            ->with(static::equalTo('attribute'), static::equalTo(1))
            ->willReturn(false);

        $or = $this->getMockBuilder(Rule::class)->getMock();
        $or->expects(static::once())
            ->method('passes')
            ->with(static::equalTo('attribute'), static::equalTo(1))
            ->willReturn(true);

        $rule = new OrRule($either, $or);
        $passed = $rule->passes('attribute', 1);

        static::assertEquals(true, $passed);
    }

    public function testNeither(): void
    {
        $either = $this->getMockBuilder(Rule::class)->getMock();
        $either->expects(static::once())
            ->method('passes')
            ->with(static::equalTo('attribute'), static::equalTo(1))
            ->willReturn(false);

        $or = $this->getMockBuilder(Rule::class)->getMock();
        $or->expects(static::once())
            ->method('passes')
            ->with(static::equalTo('attribute'), static::equalTo(1))
            ->willReturn(false);

        $rule = new OrRule($either, $or);
        $passed = $rule->passes('attribute', 1);

        static::assertEquals(false, $passed);
    }
}
