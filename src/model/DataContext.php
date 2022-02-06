<?php

include_once 'natureReserves.php';

class DataContext
{
    public function natureReserves(){
        // extract the data and return all the items as an array.
        $sites = []; // this will be an array of each entity site.
        $headers = [];

        $file = fopen('../assets/data/natureReserves.csv','r');  // find json, csv file from the folder and put into var.
        if($file){

            $lineCount = 0;

            while($data = fgetcsv($file, 1000, ",")){ // while loop to run through csv file

                if($lineCount > 0){  // if it reads file then take the first line data and add to the site array. then ++
                    $temp = new natureReserves($data[0],$data [1], $data[2]);
                    $sites[] = $temp;
                    $lineCount ++;
                }
                else{  // else if nothing there add to headers do it doesnt make it out of sync.
                    $headers = $data;
                    $lineCount ++;
                }
            }
        }

        return $sites; // returns newly built array from dataset.
    }
}