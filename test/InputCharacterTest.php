<?php

namespace PhpSchool\TerminalTest;

use PhpSchool\Terminal\InputCharacter;
use PHPUnit\Framework\TestCase;

/**
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class InputCharacterTest extends TestCase
{
    public function testWhenCharacterIsAControl() : void
    {
        $char = new InputCharacter("\n");

        self::assertTrue($char->isControl());
        self::assertFalse($char->isNotControl());
        self::assertEquals('ENTER', $char->getControl());
        self::assertEquals("\n", $char->get());
        self::assertEquals("\n", $char->__toString());
    }

    public function testWhenCharacterIsNotAControl() : void
    {
        $char = new InputCharacter('p');

        self::assertFalse($char->isControl());
        self::assertTrue($char->isNotControl());
        self::assertEquals('p', $char->get());
        self::assertEquals('p', $char->__toString());
    }

    public function testExceptionIsThrownIfGetControlCalledWhenNotAControl() : void
    {
        self::expectException(\RuntimeException::class);
        self::expectExceptionMessage('Character "p" is not a control');

        $char = new InputCharacter('p');
        $char->getControl();
    }

    public function testGetControls() : void
    {
        self::assertEquals(
            [
                'UP',
                'DOWN',
                'RIGHT',
                'LEFT',
                'CTRLA',
                'CTRLB',
                'CTRLE',
                'CTRLF',
                'BACKSPACE',
                'CTRLW',
                'ENTER',
                'TAB',
            ],
            InputCharacter::getControls()
        );
    }

    public function testFromControlNameThrowsExceptionIfControlDoesNotExist() : void
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('Control "w" does not exist');

        InputCharacter::fromControlName('w');
    }

    public function testFromControlName() : void
    {
        $char = InputCharacter::fromControlName(InputCharacter::UP);

        self::assertTrue($char->isControl());
        self::assertEquals('UP', $char->getControl());
        self::assertEquals("\033[A", $char->get());
    }

    public function testControlExists() : void
    {
        self::assertTrue(InputCharacter::controlExists(InputCharacter::UP));
        self::assertFalse(InputCharacter::controlExists('w'));
    }
}