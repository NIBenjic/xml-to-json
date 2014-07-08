<?php

namespace MarkWilson\XmlToJson;

class XmlToJsonConverter
{
    public function convert(\SimpleXMLElement $xml)
    {
        return json_encode([$xml->getName() => $this->getData($xml)]);
    }

    private function getData(\SimpleXMLElement $xml)
    {
        $data = [];

        foreach ($xml->attributes() as $key => $value) {
            $data['-' . $key] = (string)$value;
        }

        $children = $xml->children();

        if (count($children) > 0) {
            foreach ($children as $key => $child) {
                $data[$key] = $this->getData($child);
            }
        } else {
            $data['#text'] = (string)$xml;
        }

        return $data;
    }
}
