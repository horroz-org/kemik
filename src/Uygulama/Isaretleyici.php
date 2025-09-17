<?php
namespace Uygulama;

class Isaretleyici {
    /**
     * İşaretli şeyi heyctiemel çevirir
     * 
     * @param string $yazi işaretli string
     * 
     * @return string HTML 
     */
    public static function htmlCevir($yazi){
        $patterns = [
            '/\#\# (.+)/' => '<div class="y-baslik-2">$1</div>', // başlık 2
            '/\# (.+)/' => '<div class="y-baslik-1">$1</div>',   // başlık 1

            '/\*\*(.+?)\*\*/' => '<strong>$1</strong>',          // kalın -> **
            '/\*(.+?)\*/' => '<em>$1</em>',                      // italik -> *
            '/\=\=(.+?)\=\=/' => '<mark>$1</mark>',              // haylayt -> ==
            
            '/\[(.+?)\]\((.+?)\)/' => '<a href="$2">$1</a>',     // md gibi link [Abi](maykıl.net)
            
            '/^- (.+)/m' => '<li>$1</li>',                       // liste
        ];
    
        foreach ($patterns as $pattern => $replace) {
            $yazi = preg_replace($pattern, $replace, $yazi);
        }
    
        // Liste gruplama
        $yazi = preg_replace('/(<li>.+<\/li>\s*)+/m', '<ul>$0</ul>', $yazi);
    
        return nl2br($yazi);
    }

    /**
     * frontmatter ile beraber hepicikten pars
     * 
     * @param string $yazi full yazi
     * 
     * @return array "metadata" => metadata, "html" => HD ML
     */
    public static function fullParse($yazi){
        $metadata = [];
        
        $satirlar = explode("\n", $yazi);
        $metadataBaslangic = 0;
        
        if(isset($satirlar[0]) && trim($satirlar[0]) == "---"){
            // metadata varmış
            for($ss = 1; $ss < count($satirlar); $ss++){
                $satir = trim($satirlar[$ss]);
                if($satir == "---"){
                    $metadataBaslangic = $ss + 1;
                    break;
                }

                try {
                    // angut: abi
                    if(strpos($satir, ':') !== false){
                        $d = explode(":", $satir, 2);
                        $metadata[trim($d[0])] = trim($d[1]);
                    }
                } catch (\Throwable $th) {
                    continue;
                }
            }
        }

        // tmm metadatayı aldık
        // kalanları da koyalım bitsin
        $icerik = "";
        for($i = $metadataBaslangic; $i < count($satirlar); $i++){
            $icerik .= $satirlar[$i] . "\n";
        }

        return [
            "metadata" => $metadata,
            "html" => self::htmlCevir(trim($icerik))
        ];
    }

    /**
     * sadece metadata
     * 
     * @param string $yazi full yazi
     * 
     * @return array "metadata" => metadata, "html" => HD ML
     */
    public static function metadataAl($yazi){
        $metadata = [];
        
        $satirlar = explode("\n", $yazi);
        
        if(isset($satirlar[0]) && trim($satirlar[0]) == "---"){
            // metadata varmış
            for($ss = 1; $ss < count($satirlar); $ss++){
                $satir = trim($satirlar[$ss]);
                if($satir == "---"){
                    $metadataBaslangic = $ss + 1;
                    break;
                }

                try {
                    // angut: abi
                    if(strpos($satir, ':') !== false){
                        $d = explode(":", $satir, 2);
                        $metadata[trim($d[0])] = trim($d[1]);
                    }
                } catch (\Throwable $th) {
                    continue;
                }
            }
        }

        return $metadata;
    }
}