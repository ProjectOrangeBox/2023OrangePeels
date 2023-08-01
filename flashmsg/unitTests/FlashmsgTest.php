<?php

declare(strict_types=1);

use dmyers\orange\Data;
use dmyers\orange\Output;
use peel\session\Session;
use peel\flashmsg\Flashmsg;
use PHPUnit\Framework\TestCase;
use Framework\Session\SaveHandlers\FilesHandler;

final class FlashmsgTest extends TestCase
{
    private $instance;
    private $data;
    private $output;

    protected function setUp(): void
    {
        $config = [
            'sticky types' => ['red', 'danger', 'warning', 'yellow'],
            'initial pause' => 3,
            'pause for each' => 1000,
            'default type' => 'info',
            'http referer' => 'https://www.example.com/about',
            'view variable' => 'messages',
            'session msg key' => '__#internal::flash::msg#__',
        ];

        $session = new Session([], new FilesHandler([
            'directory' => __DIR__ . '/support',
            'prefix' => '',
            'match_ip' => false,
            'match_ua' => false,
        ]));

        $this->output = new Output([
            'contentType' => 'text/html',
            'charSet' => 'utf-8',
            'show already sent error' => false,
            'simulate' => true,
        ]);

        $this->data = new Data();

        $this->instance = new Flashmsg($config, $session, $this->output, $this->data);
    }

    // Tests
    public function testMsg(): void
    {
        $this->instance->msg('Oh no we have a problem!');

        $this->assertEquals('Oh no we have a problem!', $this->instance->getMessages()[0]['msg']);
        $this->assertEquals('Oh no we have a problem!', $this->data['messages']['messages'][0]['msg']);
    }

    public function testMsgLevel(): void
    {
        $this->instance->msg('Oh no we have a problem!', 'danger');

        $this->assertEquals('danger', $this->instance->getMessages()[0]['type']);
        $this->assertEquals('danger', $this->data['messages']['messages'][0]['type']);
    }

    public function testMsgSticky(): void
    {
        $this->instance->msg('Oh no we have a problem!', 'danger');

        $this->assertTrue($this->instance->getMessages()[0]['sticky']);
        $this->assertTrue($this->data['messages']['messages'][0]['sticky']);
    }

    public function testMsgNotSticky(): void
    {
        $this->instance->msg('Oh no we have a problem!', 'boring');

        $this->assertFalse($this->instance->getMessages()[0]['sticky']);
        $this->assertFalse($this->data['messages']['messages'][0]['sticky']);
    }

    public function testMsgs1(): void
    {
        $this->instance->msgs(['Oh no we have a problem!', 'Another Problem!']);

        $this->assertEquals('Oh no we have a problem!', $this->instance->getMessages()[0]['msg']);
        $this->assertEquals('Another Problem!', $this->instance->getMessages()[1]['msg']);
    }

    public function testMsgs2(): void
    {
        $this->instance->msgs(['Oh no we have a problem!' => 'red', 'Another Problem!' => 'purple']);
        $this->assertEquals('red', $this->instance->getMessages()[0]['type']);
        $this->assertEquals('purple', $this->instance->getMessages()[1]['type']);
    }


    public function testRedirectUrl(): void
    {
        $this->instance->msg('Oh no we have a problem!', 'danger')->redirect('/go/here');

        $output = $this->output->__debugInfo();

        $this->assertEquals('Location: /go/here', $output['sent headers'][0]);
        $this->assertEquals(302, $output['sent code']);
    }

    public function testRedirectRefer(): void
    {
        $this->instance->msg('Oh no we have a problem!', 'danger')->redirect('@');

        $output = $this->output->__debugInfo();

        $this->assertEquals('Location: https://www.example.com/about', $output['sent headers'][0]);
        $this->assertEquals(302, $output['sent code']);
    }

}
