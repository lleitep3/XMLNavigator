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
        $arr = array();

        foreach ($nodes as $node)
            $arr[] = new static($node);

        return $arr;
    }

    protected function __searchNode__() {
        $path = "//{$this->name}";

        foreach ($this->attr as $k => $v)
            $path .= "[@{$k}='{$v}']";

        $nodes = $this->xml->xpath($path);

        if (empty($nodes))
            throw new Exception("node {$this->name} not Found");

        return $nodes;
    }

    public function __get($name) {
        $nodes = $this->__getNodes__($name);
        return (is_array($nodes) ? current($nodes) : $nodes);
    }

    public function all($name, $attr = array()) {
        return $this->__getNodes__($name, $attr);
    }

    public function __toString() {
        return $this->xml->asXML();
    }

    public function __call($name, $attr) {
        $nodes = $this->__getNodes__($name, $attr[0]);
        return (is_array($nodes) ? current($nodes) : $nodes);
    }

}