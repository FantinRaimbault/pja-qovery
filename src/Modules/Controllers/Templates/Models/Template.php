<?php

namespace App\Modules\Controllers\Templates\Models;

use App\Core\Html\Form;
use App\Core\Database\Entity;
use App\Core\Html\FormValidator;
use App\Modules\BinksBeatHelper;

class Template extends Entity
{
    const POLICES = [
        "" => "-- Sélectionner une police --",
        "andale mono, monospace" => "Andale",
        "arial, helvetica, sans-serif" => "Arial",
        "arial black, sans-serif" => "Arial Black",
        "book antiqua, palatino, serif" => "Book Antiqua",
        "comic sans ms, sans-serif" => "Comicomic",
        "courier new, courier, monospace" => "Courier new",
        "georgia, palatino, serif" => "Georgia",
        "helvetica, arial, sans-serif" => "helvetica",
        "impact, sans-serif" => "Impact",
        "symbol" => "Symbol",
        "tahoma" => "Tahoma",
        "terminal, monaco, monospace" => "Terminal",
        "times new roman, times, serif" => "Times New Roman",
        "trebuchet ms, geneva, sans-serif" => "Trebuchet",
        "verdana, geneva, sans-serif" => "Verdana",
        "webdings" => "Webdings",
        "wingdings, zapf dingbats" => "Wingdings"
    ];

    const FONT_SIZES = [
        "" => "-- Sélectionner une taille de police --",
        "8pt" => "8pt",
        "10pt" => "10pt",
        "12pt" => "12pt",
        "14pt" => "14pt",
        "18pt" => "18pt",
        "24pt" => "24pt",
        "36pt" => "36pt",
    ];

    protected string|null $name;
    protected string|null $projectId;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        extract($data);
        $this->name = BinksBeatHelper::cleanData($name ??= null);
        $this->tplBackgroundColor = BinksBeatHelper::cleanData($tplBackgroundColor ??= null);
        $this->projectId = BinksBeatHelper::cleanData($projectId ??= null);

        $this->h1FontFamily = BinksBeatHelper::cleanData($h1FontFamily ??= null);
        $this->h1FontSize = BinksBeatHelper::cleanData($h1FontSize ??= null);
        $this->h1Color = BinksBeatHelper::cleanData($h1Color ??= null);
        $this->h1BackgroundColor = BinksBeatHelper::cleanData($h1BackgroundColor ??= null);

        $this->h2FontFamily = BinksBeatHelper::cleanData($h2FontFamily ??= null);
        $this->h2FontSize = BinksBeatHelper::cleanData($h2FontSize ??= null);
        $this->h2Color = BinksBeatHelper::cleanData($h2Color ??= null);
        $this->h2BackgroundColor = BinksBeatHelper::cleanData($h2BackgroundColor ??= null);

        $this->h3FontFamily = BinksBeatHelper::cleanData($h3FontFamily ??= null);
        $this->h3FontSize = BinksBeatHelper::cleanData($h3FontSize ??= null);
        $this->h3Color = BinksBeatHelper::cleanData($h3Color ??= null);
        $this->h3BackgroundColor = BinksBeatHelper::cleanData($h3BackgroundColor ??= null);

        $this->h4FontFamily = BinksBeatHelper::cleanData($h4FontFamily ??= null);
        $this->h4FontSize = BinksBeatHelper::cleanData($h4FontSize ??= null);
        $this->h4Color = BinksBeatHelper::cleanData($h4Color ??= null);
        $this->h4BackgroundColor = BinksBeatHelper::cleanData($h4BackgroundColor ??= null);

        $this->h5FontFamily = BinksBeatHelper::cleanData($h5FontFamily ??= null);
        $this->h5FontSize = BinksBeatHelper::cleanData($h5FontSize ??= null);
        $this->h5Color = BinksBeatHelper::cleanData($h5Color ??= null);
        $this->h5BackgroundColor = BinksBeatHelper::cleanData($h5BackgroundColor ??= null);

        $this->h6FontFamily = BinksBeatHelper::cleanData($h6FontFamily ??= null);
        $this->h6FontSize = BinksBeatHelper::cleanData($h6FontSize ??= null);
        $this->h6Color = BinksBeatHelper::cleanData($h6Color ??= null);
        $this->h6BackgroundColor = BinksBeatHelper::cleanData($h6BackgroundColor ??= null);

        $this->paragraphFontFamily = BinksBeatHelper::cleanData($paragraphFontFamily ??= null);
        $this->paragraphFontSize = BinksBeatHelper::cleanData($paragraphFontSize ??= null);
        $this->paragraphColor = BinksBeatHelper::cleanData($paragraphColor ??= null);
        $this->paragraphBackgroundColor = BinksBeatHelper::cleanData($paragraphBackgroundColor ??= null);
    }

    public function getSettings()
    {
        return [
            "h1" => [
                "fontFamily" => $this->h1FontFamily,
                "fontSize" => $this->h1FontSize,
                "color" => $this->h1Color,
                "backgroundColor" => $this->h1BackgroundColor
            ],
            "h2" => [
                "fontFamily" => $this->h2FontFamily,
                "fontSize" => $this->h2FontSize,
                "color" => $this->h2Color,
                "backgroundColor" => $this->h2BackgroundColor
            ],
            "h3" => [
                "fontFamily" => $this->h3FontFamily,
                "fontSize" => $this->h3FontSize,
                "color" => $this->h3Color,
                "backgroundColor" => $this->h3BackgroundColor
            ],
            "h4" => [
                "fontFamily" => $this->h4FontFamily,
                "fontSize" => $this->h4FontSize,
                "color" => $this->h4Color,
                "backgroundColor" => $this->h4BackgroundColor
            ],
            "h5" => [
                "fontFamily" => $this->h5FontFamily,
                "fontSize" => $this->h5FontSize,
                "color" => $this->h5Color,
                "backgroundColor" => $this->h5BackgroundColor
            ],
            "h6" => [
                "fontFamily" => $this->h6FontFamily,
                "fontSize" => $this->h6FontSize,
                "color" => $this->h6Color,
                "backgroundColor" => $this->h6BackgroundColor
            ],
            "p" => [
                "fontFamily" => $this->paragraphFontFamily,
                "fontSize" => $this->paragraphFontSize,
                "color" => $this->paragraphColor,
                "backgroundColor" => $this->paragraphBackgroundColor
            ],
        ];
    }

    public static function createTemplateForm()
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "form_project",
                "class" => ["form_builder"],
                "submit" => [
                    "value" => "Créer ma page",
                    "class" => ["submit"]
                ]
            ],
            "inputs" => [
                "name" => [
                    "props" => [
                        "type" => "text",
                        "label" => "",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 1,
                        maxLength: 255,
                    )
                ],
            ]
        ]);
    }

    public static function generateTemplateForm(array $data): Form
    {
        return new Form([
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "form_project",
                "class" => ["bb-form"],
                "submit" => [
                    "value" => "Appliquer",
                    "class" => ["submit"]
                ]
            ],
            "inputs" => [
                "name" => [
                    "props" => [
                        "type" => "text",
                        "label" => "Nom du template",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "Le nom du template doit faire entre 1 et 255 charactères",
                        "value" => $data['name'] ?? null,
                        "required" => true
                    ],
                    "validator" => new FormValidator(
                        minLength: 1,
                        maxLength: 255,
                    )
                ],
                "tplBackgroundColor" => [
                    "props" => [
                        "type" => "color",
                        "label" => "Couleur d'arrière plan",
                        "id" => "tplBackgroundColor",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "bg error",
                        "required" => false,
                        "hidden" => true,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['tplBackgroundColor'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                /** fake inputs for design */
                "fake1" => [
                    "props" => [
                        "type" => "hidden",
                        "label" => "",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                    ],
                    "validator" => new FormValidator(
                        required: false
                    )
                ],
                "fake2" => [
                    "props" => [
                        "type" => "hidden",
                        "label" => "",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                    ],
                    "validator" => new FormValidator(
                        required: false
                    )
                ],
                /** ------------ H1 ------------ */
                "h1FontFamily" => [
                    "props" => [
                        "type" => "select",
                        "label" => "H1 police",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "family",
                        "options" => Template::POLICES,
                        "required" => false,
                        "value" => $data['h1FontFamily'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::POLICES)
                    )
                ],
                "h1FontSize" => [
                    "props" => [
                        "type" => "select",
                        "label" => "H1 taille (en pt)",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "size",
                        "required" => false,
                        "options" => Template::FONT_SIZES,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['h1FontSize'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::FONT_SIZES)
                    )
                ],
                "h1Color" => [
                    "props" => [
                        "type" => "color",
                        "label" => "H1 couleur",
                        "id" => "h1Color",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "color",
                        "required" => true,
                        "hidden" => true,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['h1Color'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                "h1BackgroundColor" => [
                    "props" => [
                        "type" => "color",
                        "label" => "H1 couleur d'arrière plan",
                        "id" => "h1BackgroundColor",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "bg",
                        "required" => false,
                        "hidden" => true,
                        "value" => $data['h1BackgroundColor'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                /** ------------ H2 ------------ */
                "h2FontFamily" => [
                    "props" => [
                        "type" => "select",
                        "label" => "H2 police",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "family",
                        "options" => Template::POLICES,
                        "required" => false,
                        "value" => $data['h2FontFamily'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::POLICES)
                    )
                ],
                "h2FontSize" => [
                    "props" => [
                        "type" => "select",
                        "label" => "H2 taille (en pt)",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "size",
                        "required" => false,
                        "options" => Template::FONT_SIZES,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['h2FontSize'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::FONT_SIZES)
                    )
                ],
                "h2Color" => [
                    "props" => [
                        "type" => "color",
                        "label" => "H2 couleur",
                        "id" => "h2Color",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "hidden" => true,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['h2Color'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                "h2BackgroundColor" => [
                    "props" => [
                        "type" => "color",
                        "label" => "H2 couleur d'arrière plan",
                        "id" => "h2BackgroundColor",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "hidden" => true,
                        "value" => $data['h2BackgroundColor'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                /** ------------ H3 ------------ */
                "h3FontFamily" => [
                    "props" => [
                        "type" => "select",
                        "label" => "H3 police",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "options" => Template::POLICES,
                        "required" => false,
                        "value" => $data['h3FontFamily'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::POLICES)
                    )
                ],
                "h3FontSize" => [
                    "props" => [
                        "type" => "select",
                        "label" => "H3 taille (en pt)",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "options" => Template::FONT_SIZES,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['h3FontSize'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::FONT_SIZES)
                    )
                ],
                "h3Color" => [
                    "props" => [
                        "type" => "color",
                        "label" => "H3 couleur",
                        "id" => "h3Color",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "hidden" => true,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['h3Color'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                "h3BackgroundColor" => [
                    "props" => [
                        "type" => "color",
                        "label" => "H3 couleur d'arrière plan",
                        "id" => "h3BackgroundColor",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "hidden" => true,
                        "value" => $data['h3BackgroundColor'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                /** ------------ H4 ------------ */
                "h4FontFamily" => [
                    "props" => [
                        "type" => "select",
                        "label" => "H4 police",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "options" => Template::POLICES,
                        "required" => false,
                        "value" => $data['h4FontFamily'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::POLICES)
                    )
                ],
                "h4FontSize" => [
                    "props" => [
                        "type" => "select",
                        "label" => "H4 taille (en pt)",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "options" => Template::FONT_SIZES,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['h4FontSize'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::FONT_SIZES)
                    )
                ],
                "h4Color" => [
                    "props" => [
                        "type" => "color",
                        "label" => "H4 couleur",
                        "id" => "h4Color",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "hidden" => true,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['h4Color'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                "h4BackgroundColor" => [
                    "props" => [
                        "type" => "color",
                        "label" => "H4 couleur d'arrière plan",
                        "id" => "h4BackgroundColor",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "hidden" => true,
                        "value" => $data['h4BackgroundColor'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                /** ------------ H5 ------------ */
                "h5FontFamily" => [
                    "props" => [
                        "type" => "select",
                        "label" => "H5 police",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "options" => Template::POLICES,
                        "required" => false,
                        "value" => $data['h5FontFamily'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::POLICES)
                    )
                ],
                "h5FontSize" => [
                    "props" => [
                        "type" => "select",
                        "label" => "H5 taille (en pt)",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "options" => Template::FONT_SIZES,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['h5FontSize'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::FONT_SIZES)
                    )
                ],
                "h5Color" => [
                    "props" => [
                        "type" => "color",
                        "label" => "H5 couleur",
                        "id" => "h5Color",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "hidden" => true,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['h5Color'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                "h5BackgroundColor" => [
                    "props" => [
                        "type" => "color",
                        "label" => "H5 couleur d'arrière plan",
                        "id" => "h5BackgroundColor",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "hidden" => true,
                        "value" => $data['h5BackgroundColor'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                /** ------------ H6 ------------ */
                "h6FontFamily" => [
                    "props" => [
                        "type" => "select",
                        "label" => "H6 police",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "options" => Template::POLICES,
                        "required" => false,
                        "value" => $data['h6FontFamily'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::POLICES)
                    )
                ],
                "h6FontSize" => [
                    "props" => [
                        "type" => "select",
                        "label" => "H6 taille (en pt)",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "options" => Template::FONT_SIZES,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['h6FontSize'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::FONT_SIZES),
                    )
                ],
                "h6Color" => [
                    "props" => [
                        "type" => "color",
                        "label" => "H6 couleur",
                        "id" => "h6Color",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "hidden" => true,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['h6Color'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                "h6BackgroundColor" => [
                    "props" => [
                        "type" => "color",
                        "label" => "H6 couleur d'arrière plan",
                        "id" => "h6BackgroundColor",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "hidden" => true,
                        "value" => $data['h6BackgroundColor'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                /** ------------ Paragaph ------------ */
                "paragraphFontFamily" => [
                    "props" => [
                        "type" => "select",
                        "label" => "Paragraphe police",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "options" => Template::POLICES,
                        "required" => false,
                        "value" => $data['paragraphFontFamily'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::POLICES)
                    )
                ],
                "paragraphFontSize" => [
                    "props" => [
                        "type" => "select",
                        "label" => "Paragraphe taille (en pt)",
                        "id" => "",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "options" => Template::FONT_SIZES,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['paragraphFontSize'] ?? null
                    ],
                    "validator" => new FormValidator(
                        contains: array_keys(Template::FONT_SIZES),
                    )
                ],
                "paragraphColor" => [
                    "props" => [
                        "type" => "color",
                        "label" => "Paragraphe couleur",
                        "id" => "paragraphColor",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "hidden" => true,
                        "margin" => "bb-margin-input-template",
                        "value" => $data['paragraphColor'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
                "paragraphBackgroundColor" => [
                    "props" => [
                        "type" => "color",
                        "label" => "Paragraphe couleur d'arrière plan",
                        "id" => "paragraphBackgroundColor",
                        "class" => [""],
                        "placeholder" => "",
                        "error" => "",
                        "required" => false,
                        "hidden" => true,
                        "value" => $data['paragraphBackgroundColor'] ?? null
                    ],
                    "validator" => new FormValidator(
                        required: false,
                        regex: '/#([a-f0-9]{3}){1,2}\b/'
                    )
                ],
            ]
        ], 4);
    }
}
