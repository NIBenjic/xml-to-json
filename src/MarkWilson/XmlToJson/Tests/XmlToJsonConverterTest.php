<?php

namespace MarkWilson\XmlToJson\Tests;

class XmlToJsonConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getConvertData
     */
    public function testConvert($xmlString, $expectedJson)
    {
        $xml = new \SimpleXMLElement($xmlString);

        $converter = new \MarkWilson\XmlToJson\XmlToJsonConverter();
        $json = $converter->convert($xml);

        $this->assertEquals($expectedJson, $json);
    }

    public function getConvertData()
    {
        return [
            [
                '<testing myattr="attribute"><test>Testing</test></testing>',
                '{"testing":{"-myattr":"attribute","test":"Testing"}}'
            ], [
                '<Element>Value</Element>',
                '{"Element":"Value"}'
            ], [
                '<Element attribute="Attribute value">value</Element>',
                '{"Element":{"-attribute":"Attribute value","#text":"value"}}'
            ], [
                '<Element><FirstSubElement>1st value</FirstSubElement><SecondSubElement>2nd value</SecondSubElement></Element>',
                '{"Element":{"FirstSubElement":"1st value","SecondSubElement":"2nd value"}}'
            ], [
                '<Element><SubElement>1st</SubElement><SubElement>2nd</SubElement></Element>',
                '{"Element":{"SubElement":["1st","2nd"]}}'
            ], [
                '<Element><Test /></Element>',
                '{"Element":{"Test":""}}'
            ], [
                '<Element><SubElement>Value 1</SubElement><SubElement>Value 2</SubElement></Element>',
                '{"Element":{"SubElement":["Value 1","Value 2"]}}'
            ],
        ];
    }
}
