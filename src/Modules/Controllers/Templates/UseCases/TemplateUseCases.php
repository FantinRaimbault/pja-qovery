<?php

namespace App\Modules\Controllers\Templates\UseCases;

use App\Core\Logger;
use App\Modules\BinksBeatHelper;
use App\Modules\Controllers\Pages\Models\Page;
use App\Modules\Controllers\Projects\Models\Project;
use App\Modules\Controllers\Templates\Exceptions\NoTemplateForProjectException;
use App\Modules\Controllers\Templates\Models\Template;

class TemplateUseCases
{
    /**
     * Apply style template on every pages of project
     * @param int $projectId
     * @param int $templateId
     * @return void
     */
    public static function applyTemplateForProject($projectId, $templateId, $removeStyles = false): void
    {
        $pages = (new Page())->find([
            ["projectId", "=", $projectId]
        ]);
        $template = (new Template(["id" => $templateId]))->getById();
        foreach ($pages as $page) {
            self::applyTemplate($template, $page, $removeStyles);
        }
    }

    public static function applyTemplateForPage($projectId, $pageId, $removeStyles = false): void
    {
        $page = (new Page([
            "id" => $pageId
        ]))->getById();

        $project = (new Project([
            "id" => $projectId
        ]))->getById();

        $template = (new Template(["id" => $project['templateApplied']]))->getById();
        if(empty($template)) {
            throw new NoTemplateForProjectException('No template found');
        }
        self::applyTemplate($template, $page, $removeStyles);
    }

    private static function applyTemplate($template, $page, $removeStyles = false) {
        $templateSettings = (new Template($template))->getSettings();
        if (!empty($page['content'])) {
            $content = mb_convert_encoding($page['content'], 'HTML-ENTITIES', 'UTF-8');
            $doc = new \DOMDocument('1.0', 'utf-8');
            $doc->loadHTML(htmlspecialchars_decode($content), LIBXML_HTML_NODEFDTD);

            foreach ($templateSettings as $key => $styleSettings) {
                if (!empty($styleSettings)) {
                    $elements = $doc->getElementsByTagName($key);
                    foreach ($elements as $element) {
                        // h1, h2, h3 ... have childs
                        $style = $element->getAttribute('style'); // take css already set (ex: text-align)
                        foreach ($styleSettings as $key => $value) {
                            $pattern = self::buildPattern($key);
                            $count = 0;
                            if ($removeStyles) {
                                $replacement = BinksBeatHelper::camelToKebab($key) . ': ;';
                                // replace style option (color: , background: ...)
                                $style = preg_replace($pattern, $replacement, $style, count: $count);
                                // if was no style option, append style
                                if (!$count) {
                                    $style .= BinksBeatHelper::camelToKebab($key) . ': ;';
                                }
                            } else {
                                $replacement = BinksBeatHelper::camelToKebab($key) . ':' . $value . ';';
                                $style = preg_replace($pattern, $replacement, $style, count: $count);
                                if (!$count) {
                                    $style .= $replacement;
                                }
                            }
                        }
                        $element->setAttribute('style', $style);
                        // if element has childs, often its span tags
                        if ($element->hasChildNodes()) {
                            $spans = $element->getElementsByTagName('span'); // to get childs 
                            foreach ($spans as $span) {
                                $style = $span->getAttribute('style');
                                foreach ($styleSettings as $key => $value) {
                                    $pattern = self::buildPattern($key);
                                    $count = 0;
                                    if ($removeStyles) {
                                        $replacement = BinksBeatHelper::camelToKebab($key) . ': ;';
                                        $style = preg_replace($pattern, $replacement, $style, count: $count);
                                        if (!$count) {
                                            $style .= BinksBeatHelper::camelToKebab($key) . ': ;';
                                        }
                                    } else {
                                        $replacement = BinksBeatHelper::camelToKebab($key) . ':' . $value . ';';
                                        $style = preg_replace($pattern, $replacement, $style, count: $count);
                                        if (!$count) {
                                            $style .= $replacement;
                                        }
                                    }
                                }
                                $span->setAttribute('style', $style);
                            }
                        }
                    }
                }
            }
            $page = new Page([
                "id" => $page['id'],
                "content" => htmlentities(preg_replace('/(<body>|<html>)|<\/html>|<\/body>/', '', $doc->saveHTML(), ENT_QUOTES)), // need to remove html and body tags
                "backgroundColor" => $removeStyles ? '' : $template['tplBackgroundColor']
            ]);
            $page->save();
        }
    }

    private static function buildPattern($key)
    {
        return '/' . BinksBeatHelper::camelToKebab($key) . ':(.*);/';
    }
}
