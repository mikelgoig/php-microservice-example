<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace App\Tests\Support;

use Codeception\Actor;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
*/
class ComponentTester extends Actor
{
    use _generated\ComponentTesterActions;

    /**************************************************************************/
    /* Books                                                              */
    /**************************************************************************/

    /**
     * @Given /^I create the book AWAA$/
     */
    public function stepCreateBookAWAA(): void
    {
        $this->sendHttpRequestWithBodyAndHeaders(
            'POST',
            '/api/books',
            [
                'headers' => [
                    'Content-Type' => 'application/ld+json',
                ],
                'body' => [
                    'id' => '0193e440-4dd0-7ff9-b3a6-2eb050bcd635',
                    'name' => 'Advanced Web Application Architecture',
                ],
            ],
        );

        $this->seeResponseCodeIsSuccessful();
    }

    /**
     * @Given /^I create the book DDD/
     */
    public function stepCreateBookDDD(): void
    {
        $this->sendHttpRequestWithBodyAndHeaders(
            'POST',
            '/api/books',
            [
                'headers' => [
                    'Content-Type' => 'application/ld+json',
                ],
                'body' => [
                    'id' => '0194462f-3a79-7556-a2d7-9fa7db847708',
                    'name' => 'Domain-Driven Design in PHP',
                ],
            ],
        );

        $this->seeResponseCodeIsSuccessful();
    }
}
