<?php

namespace MrMadClown\LaravelUtilities\Tests\Rules;

use Illuminate\Contracts\Validation\Rule;
use MrMadClown\LaravelUtilities\Validation\Rules\XOrRule;
use PHPUnit\Framework\TestCase;

class XOrRuleTest extends TestCase
{
    public function testEither(): void
    {
        $either = $this->getMockBuilder(Rule::class)->getMock();
        $either->expects(static::once())
            ->method('passes')
            ->with(static::equalTo('attribute'), static::equalTo(1))
            ->willReturn(true);

        $or = $this->getMockBuilder(Rule::class)->getMock();
        $or->expects(static::once())->method('passes')
            ->with(static::equalTo('attribute'), static::equalTo(1))
            ->willReturn(false);

        $rule = new XOrRule($either, $or);
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

        $rule = new XOrRule($either, $or);
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

        $rule = new XOrRule($either, $or);
        $passed = $rule->passes('attribute', 1);

        static::assertEquals(false, $passed);
    }

    public function testBoth(): void
    {
        $either = $this->getMockBuilder(Rule::class)->getMock();
        $either->expects(static::once())
            ->method('passes')
            ->with(static::equalTo('attribute'), static::equalTo(1))
            ->willReturn(true);

        $or = $this->getMockBuilder(Rule::class)->getMock();
        $or->expects(static::once())
            ->method('passes')
            ->with(static::equalTo('attribute'), static::equalTo(1))
            ->willReturn(true);

        $rule = new XOrRule($either, $or);
        $passed = $rule->passes('attribute', 1);

        static::assertEquals(false, $passed);
    }
}
