<?php

namespace App\Core\Html;

class Form
{

    private string $html;
    private array $form;

    public function __construct(array $form, int $newRowEvery = 1)
    {
        $this->form = $form;

        $html = "<form 
				method='" . ($form["config"]["method"] ?? "GET") . "' 
				id='" . ($form["config"]["id"] ?? "") . "' 
				class='" . (implode(" ", $form["config"]["class"]) ?? "") . "' 
				action='" . ($form["config"]["action"] ?? "") . "'>";

        $index = 0;
        foreach ($form["inputs"] as $name => $configInput) {
            if ($index % $newRowEvery === 0) {
                $html .= "<div class='row'>";
            }
            $index++;
            $html .= "<div class='row flex-column " . ($configInput["props"]["margin"] ?? "") . "'>";
            $html .= "<label>" . ($configInput["props"]["label"] ?? "") . " </label>";

            if ($configInput["props"]["type"] == "select") {
                $html .= self::renderSelect($name, $configInput["props"]);
            } else {
                $html .= self::renderInput($name, $configInput["props"]);
            }
            $html .= "</div>";

            if ($index % $newRowEvery === 0) {
                $html .= "</div>";
            }
        }

        $html .= isset($_SESSION['csrf']) ? "<input name='csrf' type='hidden' value='" . $_SESSION['csrf'] . "' />" : "";
        $html .= "<input 
                    class='" . (implode(" ", $form["config"]["submit"]["class"] ?? []) ?? "") . "' 
                    type='submit' 
                    value=\"" . ($form["config"]["submit"]["value"] ?? "Valider") . "\">";

        $html .= "</form>";

        $this->html = $html;
    }

    public function render(): void
    {
        echo $this->html;
    }

    public function getErrors($data): array
    {
        if (isset($_SESSION['csrf'])) {
            if (!isset($data['csrf']) || $data['csrf'] !== $_SESSION['csrf']) {
                throw new \Exception("CSRF", 401);
            }
        }
        $errors = [];
        foreach ($this->form["inputs"] as $name => $configInput) {
            $formValidator = $configInput["validator"];
            $postedValue = $data[$name] ?? null;
            if (!$formValidator->isValid($postedValue, $data)) {
                $errors[] = $configInput["props"]["error"];
            }
        }

        return $errors;
    }

    public function filterPost(array $post): array
    {
        $inputKeys = array_keys($this->form['inputs']);
        return array_filter($post, function ($key) use ($inputKeys) {
            return in_array($key, $inputKeys);
        }, ARRAY_FILTER_USE_KEY);
    }


    public function renderInput($name, $configInput): string
    {
        $input = "<input " . ($configInput["hidden"] ?? "") . "
                        " . ($configInput["disabled"] ?? "") . "
						name='" . $name . "' 
						value='" . ($configInput["value"] ?? "") . "'
                        for='" . (($configInput["value"] ?? "") ? 1 : 0) . "'
						min='" . ($configInput["min"] ?? "") . "'
						max='" . ($configInput["max"] ?? "") . "'
						type='" . ($configInput["type"] ?? "text") . "'
						id='" . ($configInput["id"] ?? "") . "'
						class='" . (implode(" ", $configInput["class"]) ?? "") . "'
						placeholder='" . ($configInput["placeholder"] ?? "") . "'
						" . (!empty($configInput["required"]) ? "required='required'" : "") . "
					>";
        switch ($configInput["type"]) {
            case 'file':
                return "<div class='row justify-content-center'>" .
                    "<label style='cursor: pointer' for='" . ($configInput["id"] ?? "") . "'>
                            <img src='" . ($configInput["value"] ?? "") . "' />
                        </label>" . $input .
                    "</div>";
            case 'textarea':
                return "<textarea " . ($configInput["hidden"] ?? "") . "
						name='" . $name . "' 
						min='" . ($configInput["min"] ?? "") . "'
						max='" . ($configInput["max"] ?? "") . "'
						id='" . ($configInput["id"] ?? "") . "'
						class='" . (implode(" ", $configInput["class"]) ?? "") . "'
						placeholder='" . ($configInput["placeholder"] ?? "") . "'
						" . (!empty($configInput["required"]) ? "required='required'" : "") . "
					>" . ($configInput["value"] ?? "") . "</textarea>";
            case 'color':
                return "<div onclick='" . ($configInput["id"]) . ".click()" . "' class='row color-picker-wrapper justify-content-space-between'>
                        <div class='flex'>
                            <div for='" . ($configInput["id"]) . "' class='color-picker bb-margin-medium-left bb-margin-medium-right'></div>
                            <p for='" . ($configInput["id"]) . "'></p>
                        </div>
                        <div class='flex'>
                            <button type='button' class='remove-color-picker soft-button soft-button--orange bb-margin-light-right' for='" . ($configInput["id"]) . "'></button>
                        </div>
                    </div>" . $input;
            default:
                return $input;
        }
    }


    public function renderSelect($name, $configInput): string
    {
        $html = "<select name='" . $name . "' id='" . ($configInput["id"] ?? "") . "'
						class='" . (implode(" ", $configInput["class"]) ?? "") . "'>";

        foreach ($configInput["options"] as $key => $value) {
            if($key === $configInput["value"]) {
                $html .= "<option selected value='" . $key . "'>" . $value . "</option>";
            } else {
                $html .= "<option value='" . $key . "'>" . $value . "</option>";
            }
        }

        $html .= "</select>";

        return $html;
    }
}
