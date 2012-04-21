<?php

class XMLNavigator {

    private $xml = null;
    private $name = null;
    private $attr = array();

    public function __construct($xml) {
        try {
            if ($xml instanceof SimpleXMLElement)
                $this->xml = $xml;
            elseif (is_file($xml))
                $this->xml = simplexml_load_file($xml);
            else
                $this->xml = simplexml_load_string($xml);
        } catch (Exception $e) {
// register error log
            error_log($e->getMessage() . '-' . $e->getTraceAsString());
            throw new Exception($e->getMessage());
        }
    }

    protected function __getNodes__($name, $attr = array()) {
        $this->name = $name;
        $this->attr = $attr;
        $nodes = $this->__searchNode__();

        if (empty($nodes))
            return false;

        return new static($this->__makeRoot__($nodes));
    }

    protected function __makeRoot__($nodes) {
        $root = new SimpleXMLElement("<root/>");

        if (is_array($nodes)) {
            
            foreach ($nodes as $node) {
                $this->__addXML__($root, $node);
            }
        } else {
            $this->__addXML__($root, $nodes);
        }

        return $root;
    }

    private function __addXML__(SimpleXMLElement &$base, $add) {
        $new = $base->addChild($add->getName());

        foreach ($add->attributes() as $a => $b)
            $new[$a] = $b;

        foreach ($add->children() as $child)
            $this->__addXML__($new, $child);
    }

    protected function __searchNode__() {
        $path = "{$this->name}";

        foreach ($this->attr as $k => $v)
            $path .= "[@{$k}='{$v}']";

        try {
            $nodes = $this->xml->xpath($path);
        } catch (Exception $e) {
            $nodes = array();
        }
        return $nodes;
    }

    public function __get($name) {
        return $this->__getNodes__($name);
    }

    public function __toString() {
        return $this->xml->asXML();
    }

    public function __call($name, $attr) {
        return $this->__getNodes__($name, $attr);
    }

}

$file = 'demo.xml';
$xml = new XMLNavigator($file);
var_dump($xml->class->);
//var_dump($xml->class->studants->studant(array('idade','18')));
