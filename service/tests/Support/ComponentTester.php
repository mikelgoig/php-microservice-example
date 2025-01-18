<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace App\Tests\Support;

use Codeception\Actor;
use Codeception\Util\JsonArray;
use Webmozart\Assert\Assert;

/**
 * @SuppressWarnings(PHPMD)
 */
class ComponentTester extends Actor
{
    use _generated\ComponentTesterActions;

    private ?string $bookId = null;

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
                    'Content-Type' => 'application/json',
                ],
                'body' => [
                    'name' => 'Advanced Web Application Architecture',
                ],
            ],
        );

        $this->seeResponseCodeIsSuccessful();

        $response = (new JsonArray($this->grabResponse()))->toArray();
        Assert::string($response['@id'], 'The book must have an @id');
        $this->bookId = $response['@id'];
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
                    'Content-Type' => 'application/json',
                ],
                'body' => [
                    'name' => 'Domain-Driven Design in PHP',
                ],
            ],
        );

        $this->seeResponseCodeIsSuccessful();
    }

    /**
     * @When /^I get the last book created$/
     */
    public function stepGetLastBookCreated(): void
    {
        Assert::notNull($this->bookId, 'The book must have been created.');
        $this->sendGet($this->bookId);
    }
}
