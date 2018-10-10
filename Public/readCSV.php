<?php

    main::start("example.csv");

    class main  {
        static public function start($filename) {
            $records = csv::getRecords($filename);

            $html = html::createTable($records);
            system::print($html);
        }
    }

    class system {
        public static function print($data) {
            print $data;
    }
}

    class html {

        public static function createTable($records) {
            return "<table class=\"table table-striped\">" . html::createColumns($records[0]) . html::createRows($records) . "</table>";

        }

        public static function tableBody($data) {
            return "<tbody>" . $data . "</tbody>";
        }


        public static function tableHeader($data) {
            return "<thead>" . $data . "</thead>";
        }

        public static function columnHeader($data) {
            return "<th>" . $data . "</th>";
        }


        public static function tableRow($data) {
            return "<tr>" . $data . "</tr>";
        }

        public static function tableData($data) {
            return "<td>" . $data . "</td>";
        }

        public static function createColumns($records) {
            $html = "";
            foreach ($records as $key => $value) {
                $html .= html::columnHeader($key);
            }

            return html::tableHeader($html);
        }

        public static function createRows($records) {
            $html = "";
            for ($i=0; $i < count($records); $i++) {
                foreach ($records[$i] as $key => $value) {
                    $html .= html::tableData($value);
                }
                $html = html::tableRow($html);
            }

            return html::tableBody($html);
        }


    }

    class csv {
        static public function getRecords($filename) {
            $file = fopen($filename,"r");
            $fieldNames = array();
            $count = 0;
            while(! feof($file))
            {
                $record = fgets($file);
                $string = explode(",", $record);

                if($count == 0) {
                    $fieldNames = $string;
                } else {
                    $records[] = recordFactory::create($fieldNames, $string);
                }
                $count++;
            }
            fclose($file);

            return $records;
        }
    }

    class record {
        public function __construct(Array $fieldNames = null, $values = null )
        {
            $record = array_combine($fieldNames, $values);
            foreach ($record as $property => $value) {
                $this->createProperty($property, $value);
            }
        }
        public function returnArray() {
            $array = (array) $this;
            return $array;
        }
        public function createProperty($name = 'first', $value = 'keith') {
            $this->{$name} = $value;
        }
    }

    class recordFactory
    {
        public static function create(Array $fieldNames = null, Array $values = null)
        {
            $record = new record($fieldNames, $values);
            return $record;
        }
    }



?>