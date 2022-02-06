<?php

namespace sh; function x($cmd) { echo '<pre style="background-color:black;color:lightgreen;padding:12px 12px 12px 12px;margin:0px 0px;">' . '<b style="color:#fdff99;">' . "$ $cmd</b>\n"; system($cmd . ' 2>&1', $result); echo '<b style="color:white;">' . "exit code: $result</b></pre>"; }

// examples for running commands

x('pwd');

x('whoami');

x('ls -la');
