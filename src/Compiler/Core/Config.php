<?php

namespace App\Compiler\Core;

use App\Compiler\Helpers\ExtensionTrait;
use App\Compiler\Helpers\ProcessTrait;

class Config
{
    use ExtensionTrait;
    use ProcessTrait;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        if (!defined('ACCEPTED')) {
            define('ACCEPTED', 0);
        }
        if (!defined('WRONG_ANSWER')) {
            define('WRONG_ANSWER', 1);
        }
        if (!defined('TIME_LIMIT_EXCEEDED')) {
            define('TIME_LIMIT_EXCEEDED', 2);
        }
        if (!defined('COMPILER_ERROR')) {
            define('COMPILER_ERROR', 3);
        }
        if (!defined('CPP')) {
            define('CPP', 'cpp');
        }
        if (!defined('C')) {
            define('C', 'c');
        }
        if (!defined('JAVA')) {
            define('JAVA', 'java');
        }
        if (!defined('PYTHON')) {
            define('PYTHON', 'python');
        }
        if (!defined('DS')) {
            define('DS', DIRECTORY_SEPARATOR);
        }
        if (!defined('TEST_COMPILER_DIR')) {
            define('TEST_COMPILER_DIR', __DIR__ . DS . '..' . DS . '..' . DS . 'tests' . DS . 'testDir');
        }
    }

    /**
     * Get compiler configurations
     * @param null $compiler
     * @return array|mixed
     */
    public function getCompilerConfigs($compiler = null)
    {
        $compilers = [
            "cpp" => [
                // if you use environment variables use g++ without the complete path
                "path" => "g++",
                "file_extension" => ".cpp",
                "compile_func" => "compileCAndCPP",
                "run_func" => "runCAndCPP"
            ],
            "c" => [
                // if you use environment variables use gcc without the complete path
                "path" => "gcc",
                "file_extension" => ".c",
                "compile_func" => "compileCAndCPP",
                "run_func" => "runCAndCPP"
            ],
            "java" => [
                // make sure you did this TODO you must add path to jdk/bin to your environment variable
                "path_compile" => "javac",
                // make sure you did this TODO you must add path to jdk/bin to your environment variable
                "path_run" => "java",
                "main_class" => "Main",
                "file_extension" => ".java",
                "compile_func" => "compileJava",
                "run_func" => "runJava"
            ],
            "python2" => [
                // if you use environment variables use python2 without the complete path
                "path" => "python2",
                "file_extension" => ".py",
                "compile_func" => "runPython"
            ],
            "python3" => [
                // if you use environment variables use python3 without the complete path
                "path" => "python3",
                "file_extension" => ".py",
                "compile_func" => "runPython"
            ]
        ];

        return ($compiler != null ? $compilers[$compiler] : $compilers);
    }

}
