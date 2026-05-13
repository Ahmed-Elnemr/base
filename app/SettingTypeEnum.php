<?php

namespace App;

enum SettingTypeEnum: int
{
    case SHORT_TEXT = 1;
    case LONG_TEXT = 2;
    case RICH_TEXT = 3;
    case INTEGER = 4;
    case DECIMAL = 5;
    case BOOLEAN = 6;
    case IMAGE = 7;
    case FILE = 8;
    case VIDEO = 9;
    case URL = 10;
    case COLOR = 11;
    case DATE = 12;
    case DATETIME = 13;



    public function label(): string
    {
        return match($this) {
            self::SHORT_TEXT => __('Short Text'),
            self::LONG_TEXT => __('Long Text'),
            self::RICH_TEXT => __('Rich Text'),
            self::INTEGER => __('Integer'),
            self::DECIMAL => __('Decimal'),
            self::BOOLEAN => __('Boolean'),
            self::IMAGE => __('Image'),
            self::FILE => __('File'),
            self::VIDEO => __('Video'),
            self::URL => __('URL'),
            self::COLOR => __('Color'),
            self::DATE => __('Date'),
            self::DATETIME => __('Date & Time'),
        };
    }
}
