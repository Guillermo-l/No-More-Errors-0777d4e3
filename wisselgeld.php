<?php
//Input van bedrag
$input = $argv[1];

try{
    if (is_null($input)) {
        throw new Exception("Je hebt geen bedrag meegegeven dat omgewisseld dient te worden");
    }
    elseif($input < 0) {
        throw new Exception("Ik kan geen negatief bedrag wisselen");
    }
    elseif (!is_numeric($input)) {
        throw new Exception("Je hebt geen geldig bedrag meegegeven");
    }
    else {
        //Afronden op 5 centen
        $rounded = round($input / 0.05) * 0.05;
        $afgerondBedrag = number_format($rounded, 2);
        $afgerondBedrag *= 100;
    
        // Geld eenheden (Brieven & Munten)
        $eenheden = [500, 200, 100, 50, 20, 10, 5, 2, 1, 0.50, 0.20, 0.10, 0.05];
    
        //Berekening van het restbedrag en aantal eenheden
        function bereken($afgerondBedrag, $eenheden)
        {
            $aantalVanEenheid = $afgerondBedrag / $eenheden;
            $restbedrag = $afgerondBedrag % $eenheden;
            $eindBedrag = floor($aantalVanEenheid);
            return array($eindBedrag, $restbedrag);
        }
    
        if (is_numeric($input)) {
            //Printen van type eenheden en de hoeveelheid daarvan
            for ($i = 0; $i < count($eenheden); $i++) {
                $eenheden[$i] *= 100;
                $uitkomst = bereken($afgerondBedrag, $eenheden[$i]);
                $afgerondBedrag = $uitkomst[1];
                if ($uitkomst[0] > 0) {
                    if ($eenheden[$i] < 100) {
                        echo $uitkomst[0] . " x " . $eenheden[$i] . " cent" . PHP_EOL;
                    } else {
                        $eenheden[$i] /= 100;
                        echo $uitkomst[0] . " x " . $eenheden[$i] . " euro" . PHP_EOL;
                    }
                }
            }
        }
        }
    } catch (Exception $ex) {
        echo "Error: " . $ex->getMessage();
}