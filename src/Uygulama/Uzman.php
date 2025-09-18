<?php
namespace Uygulama;

use Core\OutputManager;
use \Core\TemplateManager as TM;

class Uzman {
    /**
     * yazilar klasöründeki dosyaları alak
     * 
     * @return array dosya listesi
     */
    public static function yaziDosyalariAl(){
        $yazilarKlasor = BASE_PATH . "/yazilar";

        $yaziDosyalari = [];

        // klasöre göz atıverelim
        $dosyalar = scandir($yazilarKlasor);

        if($dosyalar === false){
            throw new \Exception("Klasörü açamadık abi.");
        }

        foreach($dosyalar as $dosya){
            if ($dosya === '.' || $dosya === '..') {
                continue;
            }

            $dosyaYolu = $yazilarKlasor . '/' . $dosya;
            if(is_file($dosyaYolu)){
                // .y uzantısı
                if(pathinfo($dosya, PATHINFO_EXTENSION) === 'y'){
                    $yaziDosyalari[] = $dosya;
                }
            }
        }

        return $yaziDosyalari;
    }

    /**
     * Yazıların listesini alak. En yeniden en eskiye.
     * Direkt metadataların listesi aslında oğlum.
     * 
     * @return array liste
     */
    public static function yaziListeAl(){
        $yaziListe = [];
        $dosyaListe = self::yaziDosyalariAl();

        foreach ($dosyaListe as $dosya) {
            $dosyaIcerik = file_get_contents(BASE_PATH . "/yazilar/" . $dosya);
            
            $data = Isaretleyici::metadataAl($dosyaIcerik);
            $data["id"] = pathinfo($dosya, PATHINFO_FILENAME);

            $yaziListe[] = $data;
        }

        // bi de tarihe göre sıralıyalım abicim
        // https://stackoverflow.com/questions/1597736/sort-an-array-of-associative-arrays-by-column-value
        usort($yaziListe, function ($item1, $item2) {
            return $item2['tarih'] <=> $item1['tarih'];
        });

        return $yaziListe;
    }

    /**
     * Ana sayfadaki liste için htmlyi al
     * 
     * @return string html
     */
    public static function yaziListeHTML(){
        $yaziDataListe = self::yaziListeAl();
        foreach ($yaziDataListe as &$data) {
            $data["tarih"] = date("Y-m-d H:i", $data["tarih"]);
        }
        unset($data);

        $htmlListe = TM::getBulk("yazi-blok", $yaziDataListe);
        return implode("", $htmlListe);
    }

    /**
     * Bakalım id doğru muymuş değil miymiş. Değilse geberiyoz.
     * 
     * @param string $id id
     */
    public static function idKontrol($id){
        if(is_string($id) && ctype_digit($id) && strlen($id) === 6){
            if(file_exists(BASE_PATH . "/yazilar/$id.y")){
                return;
            }
            else{
                OutputManager::error("Yazı silinmiş olabilir.");
                die();
            }
        }
        else{
            OutputManager::error("Ya sen ne yapmaya çalışıyosun kardeşim? Sıkıntılı mısın?");
            die();
        }
    }

    public static function oku($id){
        self::idKontrol($id);

        $yaziYolu = BASE_PATH . "/yazilar/$id.y";
        $data = Isaretleyici::fullParse(file_get_contents($yaziYolu));

        TM::print("yazi-ust", [
            "baslik" => $data["metadata"]["baslik"],
            "tarih" => date("Y-m-d H:i", $data["metadata"]["tarih"]), // güzel yapalım misçene
            "yazi" => $data["html"]
        ]);
    }
}