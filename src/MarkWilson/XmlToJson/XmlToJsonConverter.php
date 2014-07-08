<?php

namespace MarkWilson\XmlToJson;

/**
 * XML to JSON string converter
 *
 * @package MarkWilson\XmlToJson
 * @author  Mark Wilson <mark@89allport.co.uk>
 */
class XmlToJsonConverter
{
    /**
     * Convert from SimpleXMLElement to json string
     *
     * @param \SimpleXMLElement $xml XML element
     *
     * @return string
     */
    public function convert(\SimpleXMLElement $xml)
    {
        return json_encode([$xml->getName() => $this->getData($xml)]);
    }

    /**
     * Get the XML data
     *
     * Returns an array of the XML data. If the XML data is just a single value it will return a string instead.
     *
     * @param \SimpleXMLElement $xml XML element
     *
     * @return array|string
     */
    private function getData(\SimpleXMLElement $xml)
    {
        $data = [];

        // loop through the attributes and append them to the data array with '-' suffix on keys
        foreach ($xml->attributes() as $key => $value) {
            $data['-' . $key] = (string)$value;
        }

        if ($xml->count() > 0) {
            $children = $xml->children();

            // loop through the children
            foreach ($children as $key => $child) {
                $childData = $this->getData($child);

                // decide how to put this into the data array, if the key exists it becomes an array of values
                if (isset($data[$key])) {
                    if (is_array($data[$key])) {
                        $data[$key][] = $childData;
                    } else {
                        $data[$key] = [$data[$key], $childData];
                    }
                } else {
                    $data[$key] = $childData;
                }
            }
        } else {
            // get the string value of the XML
            $value = (string)$xml;

            // check if this is just a single value element, i.e. <Element>Value</Element
            if (count($data) === 0) {
                $data = $value;
            } else {
                $data['#text'] = (string)$xml;
            }
        }

        return $data;
    }
}
