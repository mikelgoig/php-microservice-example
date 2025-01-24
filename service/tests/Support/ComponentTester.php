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
    /* Books                                                                  */
    /**************************************************************************/

    /**
     * @Given /^I create the book "([^"]*)"$/
     */
    public function stepCreateBook(string $name): void
    {
        $this->sendHttpRequestWithBodyAndHeaders(
            'POST',
            '/api/books',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => [
                    'name' => $name,
                ],
            ],
        );

        $this->seeResponseCodeIsSuccessful();

        $response = (new JsonArray($this->grabResponse()))->toArray();
        Assert::string($response['id'], 'The book must have an ID.');
        $this->bookId = $response['id'];
    }

    /**
     * @When /^I get the last book created$/
     */
    public function stepGetLastBookCreated(): void
    {
        Assert::notNull($this->bookId, 'The book must have been created.');
        $this->sendGet(sprintf('/api/books/%s', $this->bookId));
    }
}
