<?php

function customNumberPattern() {
    return '[0-9]+';
}

function customNumberPatternMessage() {
    return 'Enkel numerieke karakters zijn toegelaten.';
}

function customDecimalNumberPattern() {
    return '^\d+(?:[\.,]\d{1,2})?$';
}

function customDecimalNumberPatternMessage() {
    return 'Geef een geheel of decimaal getal in. Een decimaal moet minimum 1 cijfer voor, en maximum 2 cijfers na het scheidingsteken hebben.';
}

function getReadableDateFormats($object) {
    $timestamp_gewijzigd = strtotime($object->gewijzigdOp);
    $timestamp_toegevoegd = strtotime($object->toegevoegdOp);
    $object->gewijzigdOp_datum = date('d/m/Y', $timestamp_gewijzigd);
    $object->gewijzigdOp_tijd = date('H:i', $timestamp_gewijzigd);
    $object->toegevoegdOp_datum = date('d/m/Y', $timestamp_toegevoegd);
    $object->toegevoegdOp_tijd = date('H:i', $timestamp_toegevoegd);
    return $object;
}

function checkString($input, $emptyStringIsAllowed = false) {
    if (is_string($input) && $input != "") {
        return $input;
    }
    else {
        return null;
    }
}

function checkInt($input) {
    if (is_int($input) && $input != 0) {
        return $input;
    }
    else {
        return null;
    }
}

function checkFloat($input) {
    if (is_float($input) && ($input != 0 || $input != 0.00)) {
        return $input;
    }
    else {
        return null;
    }
}

?>