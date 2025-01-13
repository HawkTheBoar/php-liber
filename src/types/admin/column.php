<?php
class Column{
        private $name;
        private $type;
        private $htmlinputtype;
        private $nullable;
        
        public function __construct($name, $type, $nullable){
            $this->name = $name;
            $this->type = $type;
            switch($this->type){
                case 'INT':
                    $this->htmlinputtype = 'number';
                    break;
                case 'DATE':
                    $this->htmlinputtype = 'date';
                    break;
                default:
                    $this->htmlinputtype = 'text';
                    break;
            }
            $this->nullable = $nullable;
        }
        public function getName(){
            return $this->name;
        }
        public function getType(){
            return $this->type;
        }
        public function getNullable(){
            return $this->nullable;
        }
}