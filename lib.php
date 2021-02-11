<?php
function td(...$a)
{
	echo '<pre>';
	foreach($a as $v)
		var_dump($v);
	echo '<br>--<br>';
	debug_render_html_backtrace();
	echo '<br>--<br>';
	die('td()');
}

function H($string)
{
	return htmlspecialchars($string);
}

function debug_gen_backtrace(int $skip_levels = 0) : array
{
	$a = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
	++$skip_levels;
	while ($skip_levels-- > 0)
		array_shift($a);
	return $a;
}

function debug_render_html_backtrace(int $skip_levels = 0)
{
	debug_display_backtrace(debug_gen_backtrace($skip_levels+1));
}
function debug_render_html_exception_backtrace(Throwable $E)
{
	$a = $E->getTrace();
	array_unshift($a, [ 'file' => $E->getFile(), 'line' => $E->getLine()]);
	debug_display_backtrace($a);
}

function debug_display_backtrace(array $a)
{
	$P = function(string $str) : string
	{
		return str_replace(INSTALL_DIR .'/', '', $str);
	};
	foreach($a as $frame)
		printf('%s:%d<br/>', H($P($frame['file'])), $frame['line']);
}
