<?php

if(!function_exists('get_calling_method_name')) {
    function get_calling_method_name(int $backtraceAt = 1): string
    {
        return debug_backtrace(!DEBUG_BACKTRACE_PROVIDE_OBJECT|DEBUG_BACKTRACE_IGNORE_ARGS,$backtraceAt+1)[$backtraceAt]['function'];
    }
}
