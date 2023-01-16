<?php

namespace Infinitesimal;

class Input
{
    public static function Get(string $param)
    {
        $param = self::GetPureParamName($param);
        return self::GetMulti($param)[$param];
    }

    public static function Post(string $param)
    {
        $param = self::GetPureParamName($param);
        return self::PostMulti($param)[$param];
    }

    public static function Any(string $param)
    {
        $param = self::GetPureParamName($param);
        return self::AnyMulti($param)[$param];
    }

    public static function GetMulti(string $variables)
    {
        $retArray = [];
        self::ParseParameters($variables, INPUT_GET, $retArray);
        return $retArray;
    }

    public static function PostMulti(string $variables)
    {
        $retArray = [];
        self::ParseParameters($variables, INPUT_POST, $retArray);
        return $retArray;
    }

    public static function AnyMulti(string $variables)
    {
        $retArray = [];
        self::ParseParameters($variables, INPUT_GET, $retArray);
        self::ParseParameters($variables, INPUT_POST, $retArray);
        return $retArray;
    }

    private static function ParseParameters($parametersString, $inputType, &$returnArray)
    {
        $input = self::GetCleanInput($inputType);
        $parametersList = explode(",", $parametersString);
        self::FillMissingValues($parametersList, $returnArray);
        self::AddValuesFromInput($parametersList, $input, $returnArray);
    }

    private static function GetCleanInput($inputType): array
    {
        $cleanArray = filter_input_array($inputType);
        if ($cleanArray === null) return [];
        return $cleanArray;
    }

    private static function FillMissingValues(array $parametersList, &$returnArray)
    {
        foreach ($parametersList as $parameterName)
        {
            $parameterName = self::GetPureParamName($parameterName);
            if (!isset($returnArray[$parameterName])) $returnArray[$parameterName] = null;
        }
    }

    private static function AddValuesFromInput(array $parametersList, array $input, &$returnArray)
    {
        foreach ($parametersList as $parameterName)
        {
            $parameterName = self::GetPureParamName($parameterName);
            $value = self::ReadVariable($parameterName, $input);
            if ($value !== null) $returnArray[$parameterName] = $value;
        }
    }

    private static function ReadVariable(string $variable, array $input)
    {
        return isset($input[$variable]) ? $input[$variable] : null;
    }

    private static function GetPureParamName($parameter)
    {
        return trim(str_replace("#", "", $parameter));
    }
}