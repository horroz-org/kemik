<?php
namespace Core;

class TemplateManager {
    /**
     * Placeholder'ları değerlerle değiştiren şirket.
     * 
     * Mesela $data = ["kafa" => "makat"] diye verdin,
     * o zaman template içinde {kafa} yerine makat yazılacak. Bu kadar basit.
     * 
     * @param string $template Template string.
     * @param array $data Key-value şeklinde array, key placeholder'ın ismi, value içeriği.
     * 
     * @return string Son hali.
     */
    public static function replaceData($template, $data): string {
        $replaceData = [];
        foreach ($data as $key => $value) {
            $replaceData["{" . $key . "}"] = strval($value);
        }
        
        return strtr($template, $replaceData);
    }

    /**
     * Template dosyasını bulup değiştirir sadece, ekrana basmak için print var oğlum.
     * 
     * @param string $templateName Template dosyasının ismi (uzantı olmadan, uzantı php).
     * @param array $data Placeholder'lar için key-value array.
     * 
     * @return string HTML
     * 
     * @throws \Exception Eğer template dosyası yoksa diye.
     */
    public static function get(string $templateName, array $data = []) {
        $file = BASE_PATH . "/templates/{$templateName}.html";

        if (!file_exists($file)) {
            throw new \Exception("Template '$templateName' bulamadık. Napalım?");
        }

        $fileContent = file_get_contents($file);
        return self::replaceData($fileContent, $data);
    }

    /**
     * Bir sürü data varsa teker teker print demek yerine bütün dataların listesini ver, bu öyle yapsın.
     * 
     * @param string $templateName Template dosyasının ismi (uzantı olmadan, uzantı php).
     * @param array $dataBulk key-value arrayların arrayı
     * 
     * @return array String array, değiştirilmiş HTML'lerin listesi
     * 
     * @throws \Exception Eğer template dosyası yoksa diye.
     */
    public static function getBulk(string $templateName, array $dataBulk) {
        $file = BASE_PATH . "/templates/{$templateName}.html";

        if (!file_exists($file)) {
            throw new \Exception("Template '$templateName' bulamadık. Napalım?");
        }

        $fileContent = file_get_contents($file);

        $degistirilmisListe = [];
        foreach ($dataBulk as $data) {
            $degistirilmisListe[] = self::replaceData($fileContent, $data);
        }

        return $degistirilmisListe;
    }

    /**
     * Template dosyasını bulup değiştirip ekrana basar.
     * 
     * @param string $templateName Template dosyasının ismi (uzantı olmadan, uzantı php).
     * @param array $data Placeholder'lar için key-value array.
     * 
     * @throws \Exception Eğer template dosyası yoksa diye.
     */
    public static function print(string $templateName, array $data = []) {
        echo self::get($templateName, $data);
    }
}