<?php

namespace App\Modules;

class BinksBeatHelper
{
    public static function cleanData($var): null | string
    {
        if ($var === NULL) {
            return null;
        }
        $type = gettype($var);
        $cleanedVar = trim(htmlspecialchars($var, ENT_QUOTES));
        settype($cleanedVar, $type);
        return $cleanedVar;
    }

    public static function shortText($text): string
    {
        if (strlen($text) > 12) {
            return substr($text, 0, 12) . "...";
        }
        return $text;
    }

    public static function getPDOException(\PDOException $exception): \Exception | \PDOException
    {
        $error = $exception->errorInfo[1];
        switch ($error) {
            case 1062:
                throw new \Exception("Duplicate resource", 409);
            case 1452:
                throw new \Exception("FK constraint no reference", 1452);
            default:
                throw $exception;
        }
    }

    public static function uniqId(): string
    {
        return uniqId('binks_beats');
    }

    public static function showPage(array $page): string
    {
        $content = htmlspecialchars_decode($page['content']);
        $content = preg_replace('/\[!musiques\]/', '<audio controls>
                <source src="http://jplayer.org/audio/mp3/RioMez-01-Sleep_together.mp3" type="audio/ogg">
                Your browser does not support the audio element.
                </audio>', $content);
        [
            "backgroundColor" => $backgroundColor,
            "seoDescription" => $seoDescription,
            "seoTitle" => $seoTitle
        ] = $page;
        return <<<XML
            <html lang="fr">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta name="description" content="$seoDescription">
                        <title>$seoTitle</title>
                    </head>
                <style type="text/css">
                body, html {
                    margin: 0;
                    background: {$backgroundColor};
                }
                </style>
                <body>
                    {$content}
                </body>
            </html>
        XML;
    }

    public static function toJson($data)
    {
        if (is_array($data)) {
            $mappedData = array_map(function ($value) {
                return htmlentities($value);
            }, $data);
            echo json_encode($mappedData);
        } else {
            echo json_encode($data);
        }
    }


    public static function getRandomColor()
    {
        $colors = [
            "#F2AE72",
            "#F28177",
            "#91B0D9",
            "#FF8B94",
            "#FFAAA5",
            "#A8E6CF",
            "#DCEDC1",
            "#CCC1ED",
            "#EDEBC1"
        ];
        return $colors[array_rand($colors)];
    }

    public static function camelToKebab($str) {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $str));
    }

    public static function showSitemap(array $data): string
    {
        return <<<XML
            <?xml version="1.0" encoding="UTF-8"?>

            <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

            <url>

                <loc>http://www.example.com/</loc>

                <lastmod>2005-01-01</lastmod>

                <changefreq>monthly</changefreq>

                <priority>0.8</priority>

            </url>

            <url>

                <loc>http://www.example.com/catalog?item=12&amp;desc=vacation_hawaii</loc>

                <changefreq>weekly</changefreq>

            </url>

            <url>

                <loc>http://www.example.com/catalog?item=73&amp;desc=vacation_new_zealand</loc>

                <lastmod>2004-12-23</lastmod>

                <changefreq>weekly</changefreq>

            </url>

            <url>

                <loc>http://www.example.com/catalog?item=74&amp;desc=vacation_newfoundland</loc>

                <lastmod>2004-12-23T18:00:15+00:00</lastmod>

                <priority>0.3</priority>

            </url>

            <url>

                <loc>http://www.example.com/catalog?item=83&amp;desc=vacation_usa</loc>

                <lastmod>2004-11-23</lastmod>

            </url>

            </urlset>
        XML;
    }
}
