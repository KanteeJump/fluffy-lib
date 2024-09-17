<?php

namespace kante\fluffylib\logger;

class FluffyLogger {

    const PREFIX = "[FluffyLib] ";

    public static function error(string $message): void {
        echo self::PREFIX."ERROR: ".$message."\n";
    }

    public static function success(string $message): void {
        echo self::PREFIX."SUCCESS: ".$message."\n";
    }

    public static function info(string $message): void {
        echo self::PREFIX."INFO: ".$message."\n";
    }

}