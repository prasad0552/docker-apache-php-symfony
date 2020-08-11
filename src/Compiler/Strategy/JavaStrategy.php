<?php

namespace App\Compiler\Strategy;

use App\Compiler\Core\Config;

trait JavaStrategy
{
    /**
     * This function will compile the java code
     * @param $code
     * @param $compiler
     * @return bool
     */
    public function compileJava($code, $compiler, $className = null)
    {
        $this->setCompiler($compiler);
        $compiler_configs = $this->getCompilerConfigs($compiler);

        $className = $className ?? $compiler_configs['main_class'];
        //save the code in a file with that extension
        $file_name =  $this->getCompilationPath() . DS . $className . $compiler_configs['file_extension'] ;
        file_put_contents($file_name, $code);

        //run the command that compiles the code in that file
        $command = $compiler_configs['path_compile'] . " " . $file_name . " 2>&1";

        //i did not use Core::runCommand because its not build for compilation
        exec($command, $output, $status);

        return ( empty($output) ? true : $output );
    }

    /**
     * This function will compile the java code
     * @param null $input_file
     * @param null $output_file
     * @return string
     */
    public function runJava($className = null, $input_file = null, $output_file = null)
    {
        $configs = $this->getCompilerConfigs($this->getCompiler());

        $className = $className ?? $configs['main_class'];

        if ($input_file == null && $output_file == null) {
            //get the class name and run it using java command
            $command = $configs['path_run'] . " -classpath .:". $this->getCompilationPath() . DS . " " . $className . " 2>&1";
            $output = exec($command);
            return $output;
        }
    }
}
