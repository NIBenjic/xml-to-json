<?php

namespace MarkWilson\XmlToJson\Tests;

class XmlToJsonConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConvert()
    {
        $xml = new \SimpleXMLElement('<testing myattr="attribute"><test>Testing</test></testing>');

        $converter = new \MarkWilson\XmlToJson\XmlToJsonConverter();
        $json = $converter->convert($xml);

        $expectedJson = '{"testing":{"-myattr":"attribute","test":{"#text":"Testing"}}}';
        $this->assertEquals($expectedJson, $json);
    }
}
