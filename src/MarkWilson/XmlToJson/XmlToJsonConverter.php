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

        if ($xml->count() > 0) {
            $children = $xml->children();

            foreach ($children as $key => $child) {
                $childData = $this->getData($child);

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
            $value = (string)$xml;

            if (count($data) === 0) {
                $data = $value;
            } else {
                $data['#text'] = (string)$xml;
            }
        }

        return $data;
    }
}
